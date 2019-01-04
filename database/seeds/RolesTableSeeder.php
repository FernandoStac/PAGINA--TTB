<?php

use Illuminate\Database\Seeder;
use App\role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        role::create([
        	'name'=>'Super Usuario',
            'type'=>'root'
        ]);

        role::create([
        	'name'=>'Administrador',
            'type'=>'admin'
        ]);

        role::create([
        	'name'=>'Empresa',
            'type'=>'empresa'
        ]);
    }
}
