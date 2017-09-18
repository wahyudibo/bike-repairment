<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class WorkUnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Fakultas MIPA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Fakultas Teknik', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Fakultas ISIPOL', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Fakultas Ekonomika & Bisnis', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Fakultas Kedokteran', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        DB::table('work_units')->insert($data);
    }
}
