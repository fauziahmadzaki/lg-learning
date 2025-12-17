<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            [
                'name' => 'Unit Kemiri',
                'address' => 'Kemiri, Sukorejo',
                
            ],
            [
                'name' => 'Unit Bangil',
                'address' => 'Bangil',
            ],
            [
                'name' => 'Unit Purwosari',
                'address' => 'Purwosari',
            ],
            [
                'name' => 'Unit Prigen',
                'address' => 'Jatiarjo, Prigen',
            ],
        ];

        foreach ($branches as $branch) {
            Branch::create($branch);
        }
    }
}