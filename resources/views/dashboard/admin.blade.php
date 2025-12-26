@extends('layouts.general')
@section('page', 'Dashboard')
@section('title', 'Admin Dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>
    <p>Welcome, {{ $user->name }}!</p>
    <p>Your role: {{ $role ? 'Administrator' : 'User' }}</p>
@endsection
