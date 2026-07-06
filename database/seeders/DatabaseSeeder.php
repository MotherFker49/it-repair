<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // สร้าง roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'technician']);
        Role::create(['name' => 'user']);

        // สร้าง admin user
        $admin = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('admin');

        // สร้าง technician user
        $tech = User::create([
            'name'     => 'ช่างซ่อม',
            'email'    => 'tech@example.com',
            'password' => bcrypt('password'),
        ]);
        $tech->assignRole('technician');

        // สร้าง user ปกติ
        $user = User::create([
            'name'     => 'ผู้ใช้ทดสอบ',
            'email'    => 'user@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('user');
    }
}