<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Major;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ConsultationController extends Controller
{
    public function create(){
        $majors = Major::all();
        $teachers = Teacher::all();

        return view('customer.chat.create-konsultation' , compact('majors' , 'teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'assigned_teacher_id' => 'required|exists:teachers,id',
        ]);

        try {
            $teacher = Teacher::findOrFail($request->assigned_teacher_id);
            $data = [
                'consultation_code' => Str::upper(Str::random(8)),
                'subject' => $request->subject,
                'assigned_teacher_id' => $teacher->id,
                'customer_id' => auth()->id(),
                'major_id' => $teacher->major_id,
                'status' => 'open',
            ];

            // Buat konsultasi
            Consultation::create($data);

            return redirect()->route('customer.konsultation')
                ->with('success', 'Pengajuan proyek Anda sudah terkirim. Harap tunggu konfirmasi lebih lanjut dari pihak sekolah. Terima kasih :)');

        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

}
