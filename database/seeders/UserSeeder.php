<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Arunendra',
            'last_name' => 'Pratap',
            'email' => 'dev.aprai@gmail.com',
            'mobile' => '7814075655',            
            'email_verified_at' => now(),
            'user_type' =>1,
            'status' =>1,
            'password' => Hash::make('apr_800#'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
