<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $roles = array(
            [
                'id' =>1,
                'name' => 'admin',
                'guard_name' => 'web',
                'created_at' => now(),'updated_at' => now()
            ],[
                'id' =>2,
                'name' => 'agency',
                'guard_name' => 'web',
                'created_at' => now(),'updated_at' => now()
            ],[
                'id' =>3,
                'name' => 'trader',
                'guard_name' => 'web',
                'created_at' => now(),'updated_at' => now()
            ]
        );
        foreach($roles as $rr){
            DB::table('roles')->insert($rr);
        }

        $first_user = DB::table('users')->first();
        $first_user_id = $first_user->id;
        $model_has_roles = array(
          array('role_id' => '1','model_type' => 'App\Models\User','model_id' => $first_user_id)
        );
        foreach($model_has_roles as $mrr){
            DB::table('model_has_roles')->insert($mrr);
        }

        $all_permissions = DB::table('permissions')->get();
        if(!empty($all_permissions)){
            foreach($all_permissions as $apr){
                $inrr = array('permission_id'=>$apr->id, 'role_id'=>'1');
                DB::table('role_has_permissions')->insert($inrr);
            }
        }
    }
}
