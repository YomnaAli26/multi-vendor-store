@extends('layouts.dashboard')
@section("page_header","Create User")
@section("page_name")
    @parent
    <li class="breadcrumb-item active">Create User</li>
@endsection
@section('content')
    <form action="{{ route('dashboard.users.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('dashboard.users._form',['button_label'=>'Create'])
    </form>

@endsection
