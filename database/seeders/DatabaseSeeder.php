<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'firstname' => 'admin',
            'lastname' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'), // password
            'remember_token' => Str::random(10),
            'role'=>3
        ]);

         $owner1 = User::create([
            'firstname' => 'MATT',
            'lastname' => 'Gacia',
            'email' => 'matt@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'), // password
            'remember_token' => Str::random(10),
            'role'=>2
        ]);
          $branch = Branch::create([
            'name'=>'Pilyo Barbershop Angeles',
            'number'=>'09568470768',
            'location'=>'MacArthur Hwy, Angeles, 2009 Pampanga',
            'email' => 'matt@gmail.com',
            'status'=>1,
            'owner_id'=>$owner1->id,
            'start_time'=>'07:00',
            'end_time'=>'16:00',
            'lat_long'=>'15.147425622485523, 120.59413826919592',
            ]);

        $employee1 = User::create([
            'firstname' => 'Albert',
            'lastname' => 'marcos',
            'email' => 'coco@gmail.com ',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'), // password
            'remember_token' => Str::random(10),
            'role'=>1,
            'owner_id'=>$owner1->id
        ]);

           $owner2 = User::create([
            'firstname' => 'Ashlei',
            'lastname' => 'Cruz ',
            'email' => 'ashei@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'), // password
            'remember_token' => Str::random(10),
            'role'=>2
        ]);
          $branch = Branch::create([
            'name'=>'Ashlei Salon',
            'number'=>'09568470768',
            'location'=>'4HFX+4Q Angeles, Pampanga',
            'email' => 'ashei@gmail.com',
            'status'=>1,
            'owner_id'=>$owner2->id,
            'start_time'=>'08:00',
            'end_time'=>'17:00',
            'lat_long'=>'15.122847493206717, 120.599349626578',
            ]);
           $employee1 = User::create([
            'firstname' => 'leni',
            'lastname' => 'marcos',
            'email' => 'leni@gmail.com ',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'), // password
            'remember_token' => Str::random(10),
            'role'=>1,
            'owner_id'=>$owner2->id
        ]);
    }
}
