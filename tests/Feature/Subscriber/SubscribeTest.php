<?php

namespace Tests\Feature\Subscriber;

use App\Models\Subscriber;
use App\Models\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscribeTest extends TestCase
{
    use RefreshDatabase;

    public function test_will_add_an_email_to_subscribtion_list_for_a_website()
    {
        $website = Website::factory()->create()->first();

        $this->postJson("api/{$website->id}/subscribe", [
            'email' => 'sample@mail.com'
        ])->assertExactJson([
            'status' => 'success',
            'message' => 'Subscription was successful.'
        ])->assertSuccessful();

        $this->assertDatabaseHas('subscribers', [
            'email' => 'sample@mail.com'
        ]);

        $subscriber = Subscriber::where('email', 'sample@mail.com')->first();

        $this->assertTrue($subscriber->websites->contains($website));
    }

    public function test_cannot_subscribe_to_a_website_twice()
    {
        $website = Website::factory()->create()->first();

        $this->postJson("api/{$website->id}/subscribe", [
            'email' => 'sample@mail.com'
        ])->assertExactJson([
            'status' => 'success',
            'message' => 'Subscription was successful.'
        ])->assertSuccessful();

        $this->postJson("api/{$website->id}/subscribe", [
            'email' => 'sample@mail.com'
        ])->assertStatus(422)->assertJsonValidationErrors([
            'email' => 'You are already subscribed to this website.'
        ]);
    }
}
