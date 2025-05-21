<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {

    private const CATEGORIES = [
        'Sport',
        'News',
        'Technology',
        'Weather',
    ];
    private const USERS = [
        [
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'password' => 'password',
            'posts' => [[
                'title' => "Why Walking is the Best Exercise You're Not Doing Enough",
                'content' => "In a world full of gym memberships and fitness trends, walking remains one of the most underrated forms of exercise.

It’s free, low-impact, and accessible to nearly everyone. Just 30 minutes a day can improve heart health, boost mood, and support weight management.

Unlike intense workouts, walking doesn't require special equipment or recovery time. It’s also great for mental health—giving your brain a break, reducing stress, and sparking creativity.

Whether it’s a stroll through the park or a brisk walk during your lunch break, a simple daily walk might be the healthiest habit you can start today.",
                'categories' => [1, 4]
            ]]
        ],
        [
            'name' => 'Alex Ruby',
            'email' => 'alex@ruby.com',
            'password' => 'password',
            'posts' => [[
                'title' => "The Rise of Digital Minimalism",
                'content' => "As technology becomes more embedded in our lives, many are pushing back—not by quitting, but by choosing more deliberately. This movement is called digital minimalism.

Instead of constant scrolling, digital minimalists limit screen time, remove distracting apps, and focus only on tools that add real value. It’s not anti-tech—it’s intentional tech.

The benefits? More focus, less stress, and more time for real-world experiences.

In a noisy digital age, doing less online might help you live more offline.",
                'categories' => [1, 2]
            ]]
        ],
        [
            'name' => 'Anna Crypto',
            'email' => 'anna@crypto.com',
            'password' => 'password',
            'posts' => []
        ],
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach (self::CATEGORIES as $category) {
            Category::create([
                'title' => $category,
            ]);
        }

        foreach (self::USERS as $user) {
            $createdUser = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => password_hash($user['password'], PASSWORD_DEFAULT),
            ]);

            foreach ($user['posts'] as $post) {
                $createdPost = Post::create([
                    'user_id' => $createdUser->id,
                    'title' => $post['title'],
                    'content' => $post['content'],
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
