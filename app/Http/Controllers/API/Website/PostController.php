<?php

namespace App\Http\Controllers\API\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\StorePostRequest;
use App\Http\Resources\Website\PostResource;
use App\Jobs\Website\NewPostPublishedJob;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class PostController extends Controller
{
    public function __invoke(StorePostRequest $request, Website $website)
    {
        $existingPost = $website->posts()->where(function ($query) use ($request) {
            $query->where('title', $request->get('title'))->orWhere('description', $request->get('description'));
        })->exists();

        if ($existingPost) {
            return response()->json(['status' => 'error', 'message' => 'A post already exists with this same title and description. Kindly check previous posts.'], 400);
        }

        $post = $website->posts()->create($request->validated());

        Artisan::call('website:send-post-mail', ['post' => $post->id]);

        return new PostResource($post);
    }
}
