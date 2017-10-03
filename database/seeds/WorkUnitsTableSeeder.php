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
            ['name' => 'Direktorat Aset', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Fakultas Geografi', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Fakultas Farmasi', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Fakultas Kedokteran Gigi', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Fakultas kedokteran Hewan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Fakultas Kehutanan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Fakultas Pertanian', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Fakultas Peternakan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Fakultas Ilmu Budaya', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Fakultas Hukum', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Fakultas Psikologi', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Fakultas Teknologi Pertanian', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Sekolah Vokasi', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Sekolah Pascasarjana', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Direktorat Pendidikan dan Pengajaran', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Direktorat Sumber Daya Manusia', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Direktorat Perencanaan dan Pengembangan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Direktorat Kemitraan dan Alumni', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Direktorat Pengembangan Usaha dan Inkubasi', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Direktorat Pengabdian Kepada Masyarakat', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Direktorat Keuangan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Direktorat Sumberdaya dan Sistem Informasi', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        DB::table('work_units')->insert($data);
    }
}
