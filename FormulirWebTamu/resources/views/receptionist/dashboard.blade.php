@extends('layouts.app')

@section('header', 'Receptionist Dashboard')

@section('content')
<a href="{{ route('receptionist.form') }}" class="btn btn-primary">Create New Form</a>
@endsection
