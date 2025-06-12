<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Task;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $content = ['Web用', '機械学習用', 'フロントエンド用', '業務用', 'Unity用', 'iphone用', 'Android用'];
        $status = ['php', 'python', 'JavaScript', 'Java', 'C#', 'swift', 'kotolin'];

        $content = $content[rand(0, count($content) - 1)];
        $status = $status[rand(0, count($status) - 1)];
        return [
            'content' => $content,
            'status' => $status,
        ];
    }
}
