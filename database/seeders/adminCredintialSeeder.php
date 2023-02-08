<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class adminCredintialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $usr[] = [
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin@123')
        ];
       
        //save admin details
        DB::table('users')->insert($usr);
    }
}
