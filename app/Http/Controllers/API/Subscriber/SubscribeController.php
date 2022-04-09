<?php

namespace App\Http\Controllers\API\Subscriber;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subscriber\SubscribeRequest;
use App\Models\Subscriber;
use App\Models\Website;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    public function __invoke(SubscribeRequest $request, Website $website): JsonResponse
    {
        $subscriber = Subscriber::firstOrCreate(['email' => $request->get('email')]);

        $website->subscribers()->sync($subscriber);

        return response()->json(['status' => 'success', 'message' => 'Subscription was successful.']);
    }
}
