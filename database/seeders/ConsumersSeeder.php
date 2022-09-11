<?php

namespace Database\Seeders;

use App\Models\ConsumersModel;
use Illuminate\Database\Seeder;

class ConsumersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        ConsumersModel::factory()->count(1)->create();
    }
}
