@extends('employee.layouts.app')

@section('title','Admin Dashboard')

@section('content')
    <h1>Admin Dashboard</h1>
    <p>Welcome, {{ auth()->user()->name }}</p>
@endsection
