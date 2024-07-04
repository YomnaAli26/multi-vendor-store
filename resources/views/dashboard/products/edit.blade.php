@extends('layouts.dashboard')
@section("page_header","Edit Product")
@section("page_name")
    @parent
    <li class="breadcrumb-item active">Edit Product</li>
@endsection
@section('content')
    @include('dashboard.products._form',['button_label'=>'Update'])
@endsection

