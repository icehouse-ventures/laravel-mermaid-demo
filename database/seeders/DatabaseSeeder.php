<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Entity;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create users for our Eloquent demo
        $users = User::factory(4)->create();

        Post::factory(20)->create([
            'user_id' => function() use($users) {
                return $users->random();
            }
        ]);

        // Create entities for our more complex Livewire demo
        // First define our series rounds
        $seriesLabels = ['A', 'B', 'C', 'D',];

        // Start with the fund
        $fund = Entity::factory()->create([
            'name' => 'Example Venture Fund',
            'type' => 'Fund',
        ]);

        // Create a random number of portfolio companies
        $companies = Entity::factory(rand(2, 5))->create([
            'type' => 'Company',
            'parent_id' => $fund->id,
        ]);

        // Create preferred shares and notes for each company
        foreach($companies as $company) {
            $seriesLabel = $seriesLabels[array_rand($seriesLabels)]; // Pick a seed round

            $preferredStocks = Entity::factory(rand(1, 3))->create([
                'name' => $company->name . ' Series ' . $seriesLabel . '-'. rand(1, 5) . ' Preferred Stock',
                'type' => 'PreferredStock',
                'parent_id' => $company->id,
            ]);

            $convertibleNotes = Entity::factory(rand(1, 2))->create([
                'name' => $company->name . ' Convertible Note ' . $seriesLabel . '-'. rand(1, 5),
                'type' => 'ConvertibleNote',
                'parent_id' => $company->id,
            ]);

            // Create dividends for each preferred stock
            foreach($preferredStocks as $preferredStock) {
                Entity::factory(rand(1, 3))->create([
                    'name' => $preferredStock->name . ' Dividend',
                    'type' => 'Dividend',
                    'parent_id' => $preferredStock->id,
                ]);
            }
        }
    }
}
