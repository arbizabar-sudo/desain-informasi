<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Str;

class BackfillUsernames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backfill:usernames';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backfill missing usernames from user names';

    public function handle()
    {
        $users = User::whereNull('username')->orWhere('username', '')->get();
        $this->info('Users to update: ' . $users->count());
        foreach ($users as $user) {
            $base = Str::slug($user->name ?: $user->email ?: 'user');
            $candidate = $base ?: 'user';
            $i = 0;
            while (User::where('username', $candidate)->exists()) {
                $i++;
                $candidate = ($base ?: 'user') . '-' . $i;
            }
            $user->username = $candidate;
            $user->save();
            $this->line('Backfilled user '.$user->id.' -> '.$candidate);
        }
        $this->info('Done.');
        return 0;
    }
}
