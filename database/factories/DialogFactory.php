<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use Random\RandomException;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class DialogFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = $this->generateUsers(random_int(2, 1000));
        $userId = array_pop($users);

        return [
            'user_id' => $userId,
            'users' => $users
        ];
    }

    public function withUserCount(int $count): DialogFactory
    {
        return $this->state(function (array $attributes) use ($count) {
            $users = $this->generateUsers(random_int(2, 1000));
            $userId = array_pop($users);
            return [
                'user_id' => $userId,
                'users' => $this->generateUsers($count)
            ];
        });
    }

    /**
     * @throws RandomException
     */
    private function generateUsers(int $count = 10): array
    {
        $users = [];
        for ($i = 0; $i < $count; $i++) {
            do {
                $userId = $this->faker->numberBetween(1, 100000);
            } while (in_array($userId, $users));

            $users[] = $userId;
        }

        return $users;
    }
}
