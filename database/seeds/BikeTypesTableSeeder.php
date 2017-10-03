<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BikeTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Sepeda Kampus', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Sepeda Dinas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Sepeda Pribadi', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        DB::table('bike_types')->insert($data);
    }
}
