<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Post;
use Illuminate\Console\Command;

class ForceDeleteOldSoftDeletedPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:force-delete-old';
    protected $description = 'Force delete all softly-deleted posts older than 30 days';

    public function handle()
    {
        $thresholdDate = Carbon::now()->subDays(30);

        // Find and force delete posts that are softly-deleted and older than 30 days
        Post::onlyTrashed()
            ->where('deleted_at', '<', $thresholdDate)
            ->forceDelete();

        $this->info('Soft-deleted posts older than 30 days have been force-deleted.');
    }
}
