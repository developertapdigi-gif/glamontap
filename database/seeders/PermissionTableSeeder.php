<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
        $permissions = [
            'admin-job-manage',
            'admin-job-list',      
            
            'admin-skill_category-manage',
            'admin-skill_category-list',           
            'admin-skill_category-create',  
            'admin-skill_category-update',
            'admin-skill_category-delete',

            'admin-trader-manage',
            'admin-trader-list',           
            'admin-trader-create',  
            'admin-trader-update',
            'admin-trader-delete',

            'admin-company-manage',
            'admin-company-list',           
            'admin-company-create',  
            'admin-company-update',
            'admin-company-delete',

            'admin-sub_user-manage',
            'admin-sub_user-list',

            'admin-trader-manage',
            'admin-trader-list',           
            'admin-trader-create',  
            'admin-trader-update',

            'admin-post_over_wall-manage',
            'admin-post_over_wall-list',  
            'admin-post_over_wall-delete',

            'admin-plan-manage',
            'admin-plan-list',           
            'admin-plan-create',  
            'admin-plan-update',
            'admin-plan-delete',

            'admin-addon_plan-manage',
            'admin-addon_plan-list',           
            'admin-addon_plan-create',  
            'admin-addon_plan-update',
            'admin-addon_plan-delete',

            'admin-subscribers-manage',
            'admin-subscribers-list',

            'admin-badges-manage',
            'admin-badges-list',           
            'admin-badges-create',  
            'admin-badges-update',
            'admin-badges-delete',

            'admin-setting-manage',  
            'admin-setting-create',  
            'admin-setting-update',

            'admin-profile-manage',  
            'admin-profile-update',
        ];
        foreach ($permissions as $permission) {
            $ifExist = Permission::where('name',$permission)->first();
            if(!$ifExist){
                Permission::create(['name' => $permission]);
            }            
        }
    }
}
