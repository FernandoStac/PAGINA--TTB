<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Access;

class Menu extends Model
{


    protected $fillable = [
        'name', 'slug','order'
    ];
    
    public function getChildren($data, $line)
    {
        $children = [];
        foreach ($data as $line1) {
            if ($line['id'] == $line1['parent']) {
                $children = array_merge($children, [ array_merge($line1, ['submenu' => $this->getChildren($data, $line1) ]) ]);
            }
        }
        return $children;
    }

    public function optionsMenu()
    {   
        if(Auth::guest()){

            return $this->select('menus.id as id','menus.name as name','menus.parent as parent','menus.order as order','menus.slug as slug')
                ->LeftJoin("description_accesses","description_accesses.menu_id",'=',"menus.id")
                ->where('description_accesses.id',null)
               
                ->orderby('parent')
                ->orderby('order')
                ->orderby('menus.name')

                ->get()
                ->toArray();

        }else{


        $role_id=Auth::user()->role_id;

        return $this->select('menus.id as id','menus.name as name','menus.parent as parent','menus.order as order','menus.slug as slug')
            ->LeftJoin("description_accesses","description_accesses.menu_id",'=',"menus.id")
            ->LeftJoin("accesses","accesses.description_accesses_id",'=',"description_accesses.id")
       
            ->where('accesses.enabled', 1)
            ->where('accesses.role_id',$role_id)
            ->orWhere('description_accesses.id',null)
            ->distinct()
           
            ->orderby('parent')
            ->orderby('order')
            ->orderby('menus.name')

            ->get()
            ->toArray();
                  }
    }

    public static function menus()
    {
        $menus = new Menu();
        $data = $menus->optionsMenu();
        $menuAll = [];
        foreach ($data as $line) {
            $item = [ array_merge($line, ['submenu' => $menus->getChildren($data, $line) ]) ];
            $menuAll = array_merge($menuAll, $item);
        }
        return $menus->menuAll = $menuAll;
    }
}
