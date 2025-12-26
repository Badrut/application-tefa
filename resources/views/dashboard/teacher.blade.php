@extends('layouts.general')
@section('content')
    <h1 class="text-2xl font-bold mb-4">Teacher Dashboard</h1>
    <p>Welcome, {{ $user->name }}!</p>
    <p>Your role: {{ $role ? 'Teacher' : 'User' }}</p>
@endsection
