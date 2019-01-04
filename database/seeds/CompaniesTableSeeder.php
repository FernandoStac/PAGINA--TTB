<?php

use Illuminate\Database\Seeder;
use App\companie;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        companie::create([
        	'name'=>'Bios Instala SA de CV',
            'name_short'=>'bios',
            'email'=>'javelie@gmail.com'
        ]);

    }
}
