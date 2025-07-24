<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Message;
use App\Models\Conversation;

class ResetPrivateMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'messages:reset-private';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all private messages and conversations, leaving group chat data untouched.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->confirm('Are you sure you want to delete ALL private messages and conversations? This cannot be undone.')) {
            $this->info('Aborted. No data was deleted.');
            return 0;
        }

        DB::beginTransaction();
        try {
            $this->info('Deleting all private messages...');
            $deletedMessages = Message::query()->delete();
            $this->info("Deleted $deletedMessages messages.");

            $this->info('Deleting all private conversations...');
            $deletedConversations = Conversation::query()->delete();
            $this->info("Deleted $deletedConversations conversations.");

            DB::commit();
            $this->info('All private messages and conversations have been deleted.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }
        return 0;
    }
} 