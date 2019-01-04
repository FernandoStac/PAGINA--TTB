<?php

use Illuminate\Database\Seeder;
use App\configManager;

class configTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$command=$this->command->choice(
    		'Tipo de despliegue?',[
    			'Produccion',
    			'Desarrollo'
    		]
    	);

    	if($command=="Produccion"){
    		$command="cloud/";
    	}else{
    		$command="";
    	}
        configManager::create([
        	'version'=>'1',
            'state'=>'production',
            'route'=>$command
        ]);
    }
}
