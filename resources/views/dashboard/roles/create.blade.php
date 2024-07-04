@extends('layouts.dashboard')
@section("page_header","Create Role")
@section("page_name")
    @parent
    <li class="breadcrumb-item active">Create Role</li>
@endsection
@section('content')
    <form action="{{ route('dashboard.roles.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('dashboard.roles._form',['button_label'=>'Create'])
    </form>

@endsection
