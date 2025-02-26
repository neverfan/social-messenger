<?php

namespace Database\Seeders;

use App\Models\Dialog;
use Database\Factories\DialogFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $dialogCount = 10;
        $dialogUserCount = 20;
        $messagesPerHour = 60 * 60;
        $messageHours = 3;
        $chunkSize = 500;

        DB::table('dialogs')->truncate();
        DB::table('messages')->truncate();

        $dialogs = DialogFactory::new()->withUserCount($dialogUserCount)->count($dialogCount)->create();

        /** @var Dialog $dialog */
        foreach ($dialogs as $dialog) {
            $date = now()->subHours($messageHours);
            $diffSeconds = round ((($messageHours * 60 * 60) / $messagesPerHour), 1, PHP_ROUND_HALF_EVEN);
            $messages = [];
            for($i = 0; $i < $messagesPerHour; $i++) {
                $date = $date->copy()->addSeconds($diffSeconds);
                $messages[] = [
                    'dialog_id' => $dialog->id,
                    'from_user_id' => $dialog->users->random(),
                    'to_user_id' => (rand(1, 10) > 7) ? null : $dialog->users->random(),
                    'text' => fake()->realText(100),
                    'created_at' => $date,
                    'updated_at' => $date,
                ];
            }

            collect($messages)
                ->chunk($chunkSize)
                ->each(function ($chunk) {
                    DB::table('messages')->insert($chunk->toArray());
                });
        }
    }
}
