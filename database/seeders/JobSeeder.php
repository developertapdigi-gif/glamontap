<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Job;
use App\Models\JobApplication;
use Faker\Factory as Faker;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $traderFaker = Faker::create();
        $traderData = [];
        for($j=1;$j<=10;$j++){
            $trader = User::create([
                'first_name' => $traderFaker->firstName,
                'last_name' => $traderFaker->lastName,
                'email' => $traderFaker->unique()->safeEmail,
                'mobile' => $traderFaker->unique()->phoneNumber,  
                'address'=>$traderFaker->address,          
                'email_verified_at' => now(),
                'user_type' =>3,
                'status' =>1,
                'password' => Hash::make('apr_800#'),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            array_push($traderData,$trader->id);
        }
        
        $faker = Faker::create();
        for($i=1;$i<=50;$i++){
            $job = Job::create([
                'title' => 'Job '.$i,
                'agency_id'=>'15',
                'location'=>$faker->address,
                //'latitude'=>$faker->address()->latitude,
                //'longitude'=>$faker->address()->longitude,
                'experiance_range'=>$faker->numberBetween(1, 10),
                'number_of_employees'=>$faker->numberBetween(1, 10),
                'minimum_price'=>$faker->numberBetween(10, 100),
                'maximum_price'=>$faker->numberBetween(10, 100),
                'start_date'=>'2024-9-12',
                'end_date'=>'2024-12-12',
                'image'=>$faker->imageUrl(),
                'note'=>$faker->text,
            ]);

            foreach($traderData as $limit =>$_user){
                if($limit==$job->number_of_employees){
                    break;
                }
                JobApplication::create([
                    'task_id' => $job->id,
                    'bidder_id'=>$_user,
                    'agency_id'=>15,
                    'status'=>rand(0,2),
                    'created_at'=>now(),
                    'updated_at'=>now()
                ]);
            }          
        }
    }
}
