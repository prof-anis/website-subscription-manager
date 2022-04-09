<?php

namespace Tests\Feature\Jobs;

use App\Jobs\Website\NewPostPublishedJob;
use App\Models\Post;
use App\Models\Subscriber;
use App\Models\Website;
use App\Notifications\Website\NewPostPublishedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NewPostPublishedJobTest extends TestCase
{
    public function test_will_send_send_mails_to_subscribers()
    {
        Notification::fake();

        $website = Website::factory()->create()->first();

        $subscribers = Subscriber::factory()->count(5)->create();

        $website->subscribers()->sync($subscribers);

        $post = Post::factory()->create(['website_id' => $website->id])->first();

        NewPostPublishedJob::dispatchSync($post);

        foreach ($subscribers as $subscriber) {
            Notification::assertSentTo($subscriber, NewPostPublishedNotification::class);
        }
    }
}
