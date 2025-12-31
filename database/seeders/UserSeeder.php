<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $roles = ['admin', 'teacher', 'student', 'customer', 'supplier'];
        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web'
            ]);
        }

        $users = [
            ['admin', 'admin@skanda.id', 'Administrator Sistem', 'admin'],

            ['budi.guru', 'budi@guru.id', 'Budi Santoso', 'teacher'],
            ['guru', 'siti@guru.id', 'Siti Aminah', 'teacher'],

            ['andi.siswa', 'andi@siswa.id', 'Andi Pratama', 'student'],
            ['rina.siswa', 'rina@siswa.id', 'Rina Maharani', 'student'],

            ['ahmad.customer', 'ahmad@customer.id', 'Ahmad Fauzi', 'customer'],
            ['customer', 'dewi@customer.id', 'Dewi Lestari', 'customer'],

            ['supplier.jaya', 'jaya@supplier.id', 'PT Jaya Abadi', 'supplier'],
            ['supplier.makmur', 'makmur@supplier.id', 'CV Makmur Sejahtera', 'supplier'],
        ];

        foreach ($users as [$username, $email, $name, $role]) {
            $user = User::create([
                'username' => $username,
                'email' => $email,
                'name' => $name,
                'password' => Hash::make('password'),
            ]);

            $user->assignRole($role);

            UserProfile::create([
                'user_id' => $user->id,
                'phone_number' => '08' . rand(1111111111, 9999999999),
                'address' => 'Indonesia',
            ]);
        }
    }
}
