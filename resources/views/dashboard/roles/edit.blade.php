@extends('layouts.dashboard')
@section("page_header","Edit Role")
@section("page_name")
    @parent
    <li class="breadcrumb-item active">Edit Role</li>
@endsection
@section('content')
    <form action="{{ route('dashboard.roles.update',$role->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('dashboard.roles._form',['button_label'=>'Update'])
    </form>

@endsection
