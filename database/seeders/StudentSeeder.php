<?php

namespace Database\Seeders;

use App\Models\Major;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classMajor = [
            'M' => ['A', 'B', 'C'],
            'T' => ['A', 'B' , 'C'],
            'O' => ['A', 'B' , 'C'],
            'R' => ['A', 'B' , 'C'],
        ];

        $siswa = User::role('student')->get();

        foreach($siswa as $index => $user){
            $major = Major::inRandomOrder()->first();
            $code = $major->code;

            $classList = $classMajor[$code];
            $class = $classList[array_rand($classList)];
            $yearOfEntry = rand(2018, 2023);
            $grade = rand(10 ,12);

            Student::create([
                'user_id' => $user->id,
                'nis' => str_pad($user->id, 5, '0', STR_PAD_LEFT),
                'major_id' => $major->id,
                'class' => $class,
                'grade' => $grade,
                'year_of_entry' => $yearOfEntry,
            ]);
        }
    }
}
