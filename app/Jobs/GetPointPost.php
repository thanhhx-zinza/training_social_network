<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetPointPost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $id;
    private $type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id, $type)
    {
        $this->id = $id;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->type == 'like') {
            $this->getPointLike();
        } else {
            $this->getPointComment();
        }
    }

    private function getPointLike()
    {
        $post = Post::isPublic()->findOrFail($this->id);
        $post->total_reaction_count += 1;
        $post->save();
    }

    private function getPointComment()
    {
        $post = Post::isPublic()->findOrFail($this->id);
        $post->total_reaction_count += 5;
        $post->save();
    }
}
