<?php

namespace Database\Seeders;

use App\Models\Major;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $spesialisasiPerJurusan = [
            'R' => 'Pemrograman Web',
            'M' => 'Desain Grafis',
            'T' => 'Jaringan Komputer',
            'O' => 'Teknik Kendaraan Ringan',
        ];

        $majors = Major::all()->values(); // collection berurutan
        $guru = User::role('teacher')->get();

        foreach ($guru as $index => $user) {

            // bagi rata guru ke jurusan
            $major = $majors[$index % $majors->count()];
            $kode  = $major->major_code;

            $teacher = Teacher::create([
                'user_id' => $user->id,
                'nip' => fake()->numerify('################'),
                'major_id' => $major->id,
                'specialization' => $spesialisasiPerJurusan[$kode] ?? 'Umum',
            ]);

            if($major->head_teacher_id === null){
                // set kepala jurusan jika belum ada
                $major->head_teacher_id = $teacher->id;
                $major->save();
            }
        }
    }
}
