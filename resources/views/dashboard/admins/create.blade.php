@extends('layouts.dashboard')
@section("page_header","Create Admin")
@section("page_name")
    @parent
    <li class="breadcrumb-item active">Create Admin</li>
@endsection
@section('content')
    <form action="{{ route('dashboard.admins.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('dashboard.admins._form',['button_label'=>'Create'])
    </form>

@endsection
