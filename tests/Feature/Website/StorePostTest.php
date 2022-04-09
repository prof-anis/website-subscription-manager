<?php

namespace Tests\Feature\Website;

use App\Jobs\Website\NewPostPublishedJob;
use App\Models\Subscriber;
use App\Models\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class StorePostTest extends TestCase
{
    public function test_will_send_mail_notification_to_subscribers_when_new_post_is_stored()
    {
        Queue::fake();

        $website = Website::factory()->create()->first();

        $subscribers = Subscriber::factory()->count(5)->create();

        $website->subscribers()->sync($subscribers);

        $this->postJson("api/{$website->id}/post", [
            'title' => 'A dummy post',
            'description' => 'Just a dummy post',
            'body' => 'Nothing serious here, just some post'
        ])->assertStatus(201);

        Queue::assertPushed(NewPostPublishedJob::class);
    }

    public function test_will_not_allow_duplicate_post()
    {
        Queue::fake();

        $website = Website::factory()->create()->first();

        $subscribers = Subscriber::factory()->count(5)->create();

        $website->subscribers()->sync($subscribers);

        $this->postJson("api/{$website->id}/post", [
            'title' => 'A dummy post',
            'description' => 'Just a dummy post',
            'body' => 'Nothing serious here, just some post'
        ])->assertStatus(201);

        Queue::assertPushed(NewPostPublishedJob::class);

        $this->postJson("api/{$website->id}/post", [
            'title' => 'A dummy post',
            'description' => 'Just a dummy post',
            'body' => 'Nothing serious here, just some post'
        ])->assertStatus(400)->assertExactJson([
            'status' => 'error',
            'message' => 'A post already exists with this same title and description. Kindly check previous posts.'
        ]);
    }
}
