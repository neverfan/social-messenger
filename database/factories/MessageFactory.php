<?php

namespace Database\Factories;

use App\Models\Dialog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /** @var Dialog $dialog */
        $dialog = isset($attributes['dialog_id']) ? Dialog::first($attributes['dialog_id']) : Dialog::factory();
        $fromUserId = $this->faker->randomElement($dialog->users->toArray());

        return [
            'dialog_id' => $dialog->id,
            'from_user_id' => $fromUserId,
            'to_user_id' => null,
            'text' => $this->faker->text(100),
            'created_at' => now(),
            'update_at' => now(),
        ];
    }


}
