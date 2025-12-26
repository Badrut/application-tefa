<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Major;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\UserProfile;

use Illuminate\Http\Request;
use function Symfony\Component\Translation\t;

class MasterDataController extends Controller
{
    public function users(){

        $users = User::with(['profile', 'roles'])->get()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'profile' => [
                    'address' => $user->profile->address ?? '-',
                    'phone_number' => $user->profile->phone_number ?? '-',
                    'picture' => $user->profile->profile_picture
                        ? asset( $user->profile->profile_picture)
                        : asset('dist/images/profile-15.jpg'),
                ],
                'roles' => $user->roles->pluck('name')->toArray(),
            ];
        });

        // dd($users);
        return view('admin.master.users'  , ['users' => $users]);
    }

    public function userCreate(){
        $majors = Major::all();
        return view('admin.master.add-user' , compact('majors'));
    }

    public function userStore(Request $request){


        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:50|unique:users,username',
            'role' => 'required|in:admin,teacher,student,customer,supplier',
            'address' => 'nullable|string|max:500',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $password = match ($data['role']) {
            'teacher' => bcrypt('guru123'),
            'student' => bcrypt('siswa123'),
            default => bcrypt($request->validate([
                'password' => 'required|string|min:8|confirmed'
            ])['password']),
        };

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => $password,
        ]);

        UserProfile::create([
            'user_id' => $user->id,
            'address' => $data['address'] ?? null,
            'phone_number' => $data['phone_number'] ?? null,
        ]);

        $user->assignRole($data['role']);

        if ($data['role'] === 'teacher') {
            $request->validate([
                'nip' => 'required|string|unique:teachers,nip',
                'major_id' => 'required|exists:majors,id',
            ]);

            Teacher::create([
                'user_id' => $user->id,
                'nip' => $request->nip,
                'major_id' => $request->major_id,
                'specialization' => $request->specialization,
                'is_active' => $request->boolean('is_active', true),
            ]);

            return redirect()->route('admin.master-data.users')->with('success', 'Guru berhasil ditambahkan.');
        }

        if ($data['role'] === 'student') {
            $request->validate([
                'nis' => 'required|string|unique:students,nis',
                'major_id' => 'required|exists:majors,id',
            ]);

            Student::create([
                'user_id' => $user->id,
                'nis' => $request->nis,
                'major_id' => $request->major_id,
                'grade' => $request->grade,
                'class' => $request->class,
                'year_of_entry' => $request->year_of_entry,
            ]);

            return redirect()->route('admin.master-data.users')->with('success', 'Siswa berhasil ditambahkan.');
        }

        return redirect()->route('admin.master-data.users')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function userShow($id){
        $user = User::with(['profile', 'teacher.major', 'student.major'])->findOrFail($id);
        return view('admin.master.show-user', compact('user'));
    }

    public function userEdit($id){
        $user = User::with(['profile', 'teacher', 'student'])->findOrFail($id);
        $majors = Major::all();
        return view('admin.master.edit-user', compact('user', 'majors'));
    }

    public function  userUpdate(Request $request , $id){
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'username' => 'required|string|max:50|unique:users,username,' . $id,
            'role' => 'required|in:admin,teacher,student,customer,supplier',
            'address' => 'nullable|string|max:500',
            'phone_number' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->update([
        'name' => $data['name'],
        'email' => $data['email'],
        'username' => $data['username'],
        'password' => $data['password']
            ? bcrypt($data['password'])
            : $user->password,
        ]);

        UserProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'address' => $data['address'] ?? null,
                'phone_number' => $data['phone_number'] ?? null,
            ]
        );

        if (! $user->hasRole($data['role'])) {
            $user->syncRoles([$data['role']]);
        }

        if ($data['role'] === 'teacher') {

            $request->validate([
                'nip' => 'required|string|unique:teachers,nip,' . optional($user->teacher)->id,
                'major_id' => 'required|exists:majors,id',
            ]);

            Teacher::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nip' => $request->nip,
                    'major_id' => $request->major_id,
                    'specialization' => $request->specialization,
                    'is_active' => $request->boolean('is_active', true),
                ]
            );

            Student::where('user_id', $user->id)->delete();
        }

        if ($data['role'] === 'student') {

            $request->validate([
                'nis' => 'required|string|unique:students,nis,' . optional($user->student)->id,
                'major_id' => 'required|exists:majors,id',
            ]);

            Student::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nis' => $request->nis,
                    'major_id' => $request->major_id,
                    'grade' => $request->grade,
                    'class' => $request->class,
                    'year_of_entry' => $request->year_of_entry,
                ]
            );
            Teacher::where('user_id', $user->id)->delete();
        }

        return redirect()
        ->route('admin.master-data.users')
        ->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function userDestroy($id){
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()
            ->route('admin.master-data.users')
            ->with('success', 'Pengguna berhasil dihapus.');
    }

    public function majorCreate(){
        $users = User::whereHas('teacher')->get();
        return view('admin.master.add-major' , compact('users'));
    }

    public function majorStore(Request $request){

        $data = $request->validate([
            'code' => 'required',
            'name' => 'required',
            'description' => 'required',
            'head_teacher_id' => 'required|exists:teachers,id',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        Major::create($data);
        return redirect()->route('admin.master-data.major')->with('success' , 'Jurusan berhasil di tambah');
    }

    public function majorEdit($id){
        $users = User::whereHas('teacher')->get();
        $major = Major::findorFail($id);
        return view('admin.master.edit-major' , compact('users' , 'major'));
    }

    public function majorUpdate(Request $request , $id){
        $major = Major::findOrFail($id);

        $data = $request->validate([
            'code' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'head_teacher_id' => 'required|exists:teachers,id',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->has('is_active');

        $major->update($data);

        return redirect()
            ->route('admin.master-data.major')
            ->with('success', 'Jurusan berhasil diperbarui');
    }

    public function majorDestroy($id){
        $major = Major::findOrFail($id);
        $major->delete();

        return redirect()
            ->route('admin.master-data.major')
            ->with('success', 'Jurusan berhasil dihapus.');
    }

    public function major(){
        $majors = Major::with('headTeacher')->get()->map(function ($major) {
            return [
                'id' => $major->id,
                'code' => $major->code,
                'name' => $major->name,
                'head_teacher' => $major->headTeacher ? $major->headTeacher->name : '-',
                'description' => $major->description,
            ];
        });
        return view('admin.master.major', ['majors' => $majors]);
    }
}
