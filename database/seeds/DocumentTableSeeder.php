<?php

use Illuminate\Database\Seeder;
use App\Document;

class DocumentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $cont=0;

        while($cont<500){

            if($cont<100){

                 Document::create([
                      'name'=>'Javier',
                         'uuid'=>'123e4567-e89b-12d3-a456-426655440000',
                         'document'=>'aa.pdf',
                         'url'=>'files/bios/2018-10/',
                         'date'=>'2018-10-30',
                         'user_id'=>'2',
                         'companie_id'=>'1'
                     ]); 

            }

            if($cont<150){
                 Document::create([
                      'name'=>'Javier',
                         'uuid'=>'123e4567-e89b-12d3-a456-426655440000',
                         'document'=>'a.pdf',
                         'url'=>'files/bios/2018-09/',
                         'date'=>'2018-03-06',
                         'user_id'=>'2',
                         'companie_id'=>'1'
                     ]); 
                
            }

            if($cont<200){
                 Document::create([
                      'name'=>'Javier',
                         'uuid'=>'123e4567-e89b-12d3-a456-426655440000',
                         'document'=>'a.pdf',
                         'url'=>'files/bios/2018-09/',
                         'date'=>'2018-09-06',
                         'user_id'=>'2',
                         'companie_id'=>'1'
                     ]); 
                
            }

            if($cont<300){
                 Document::create([
                      'name'=>'Javier',
                         'uuid'=>'123e4567-e89b-12d3-a456-426655440000',
                         'document'=>'a.pdf',
                         'url'=>'files/bios/2018-09/',
                         'date'=>'2018-01-16',
                         'user_id'=>'2',
                         'companie_id'=>'1'
                     ]); 
                
            }

                      

                       $cont++;
        }
         

    }
}
