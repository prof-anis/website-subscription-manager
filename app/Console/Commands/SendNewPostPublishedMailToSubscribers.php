<?php

namespace App\Console\Commands;

use App\Jobs\Website\NewPostPublishedJob;
use App\Models\Post;
use Illuminate\Console\Command;

class SendNewPostPublishedMailToSubscribers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'website:send-post-mail {post}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mails of new published posts to website subscribers';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $post = Post::findOrFail($this->argument('post'));

        if (!$post->isSent()) {
            NewPostPublishedJob::dispatch($post);
        }
    }
}
