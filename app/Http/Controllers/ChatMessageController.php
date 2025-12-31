<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Consultation;
use Illuminate\Support\Facades\Auth;
use App\Models\Major;
use App\Models\ChatMessage;

class ChatMessageController extends Controller
{
    public function customer(){
        $teachers = User::role('teacher')->get();
        $consultations = [];
        if (Auth::check()) {
            $consultations = Consultation::where('customer_id', Auth::id())->with(['teacher','messages'=>function($q){$q->latest();}])->get();
        }
        return view('customer.chat.index', compact('teachers', 'consultations'));
    }

    public function teacher()
    {
        $teacher = Auth::user();
        $consultations = Consultation::where('assigned_teacher_id', $teacher->id)
            ->with(['customer', 'messages' => function($q){ $q->latest(); }])
            ->get();
        return view('teacher.chat.index', compact('consultations'));
    }

    public function startConsultation($teacherId)
    {
        $customer = Auth::user();
        $major = Major::first();
        if (! $major) {
            return back()->with('error', 'No Majors available to create consultation.');
        }

        $consultation = Consultation::create([
            'consultation_code' => 'C' . strtoupper(uniqid()),
            'customer_id' => $customer->id,
            'major_id' => $major->id,
            'subject' => 'Chat with ' . optional(User::find($teacherId))->name,
            'status' => 'open',
            'assigned_teacher_id' => $teacherId,
        ]);

        return redirect()->route('customer.konsultation.chat', ['id' => $consultation->id]);
    }

    public function showConversation(Request $request, $id)
    {
        $consultation = Consultation::with([
            'messages.sender',
            'customer',
            'teacher',
        ])->findOrFail($id);

        $consultation->messages()
            ->where('sender_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        if ($request->ajax()) {
            return view('chat._conversation', compact('consultation'));
        }

        return view('chat.conversation', compact('consultation'));
    }

    public function storeMessage(Request $request, $id)
    {
        $consultation = Consultation::findOrFail($id);
        $request->validate([
            'message_text' => 'nullable|string',
        ]);

        $message = ChatMessage::create([
            'consultation_id' => $consultation->id,
            'sender_id' => Auth::id(),
            'message_text' => $request->input('message_text'),
            'is_read' => false,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([ 'status' => 'ok', 'message' => $message ], 201);
        }

        return redirect()->back();
    }
}
