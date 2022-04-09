<?php

namespace App\Rules\Subscriber;

use App\Models\Subscriber;
use App\Models\Website;
use Illuminate\Contracts\Validation\Rule;

class CanSubscribeToWebsite implements Rule
{
    /**
     * @var Website
     */
    private $website;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Website $website)
    {
        $this->website = $website;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $subscriber = Subscriber::where('email', $value)->first();

        if (!$subscriber) {
            return true;
        }

        return !$subscriber->websites()->where('website_id', $this->website->id)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You are already subscribed to this website.';
    }
}
