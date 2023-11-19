<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Admin
        $userAdmin = User::create([
            'name'=>'admin',
            'email'=>'admin@bim-venture.com',
            'password'=>Hash::make('admin@bim-venture.com'),
        ]);
        $userAdmin->assignRole('admin');
        $userAdmin->givePermissionTo('view_transaction');
        $userAdmin->givePermissionTo('create_transaction');
        $userAdmin->givePermissionTo('edit_transaction');

        //Customer
        $userConsumer = User::create([
            'name'=>'thomas',
            'email'=>'thomas@bim-venture.com',
            'password'=>Hash::make('thomas@bim-venture.com'),
        ]);
        $userConsumer->assignRole('customer');
        $userConsumer->givePermissionTo('view_transaction');
    }
}
