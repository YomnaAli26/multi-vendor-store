@extends('layouts.dashboard')
@section("page_header","Trash Categories")
@section("page_name")
    @parent
    <li class="breadcrumb-item active">Trash Categories</li>
@endsection
@section('content')
    <div class="mb-5">
        <a href="{{ route('dashboard.categories.index') }}" class="btn btn-primary">Back</a>

    </div>
    <x-alert type="success"/>
    <form action="{{URL::current()}}" method="get" class="d-flex justify-content-between mb-4">
        <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')"/>
        <x-form.select class="mx-2" name="status" default_option_name="All"
                       :options="['active'=>'Active','archived'=>'Archived']" :selected="request('status')"/>
        <button type="submit" class="btn btn-dark mx-2">Filter</button>
    </form>
    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Name</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Deleted At</th>
            <th>Image</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($categories as $category)
            <tr>
                <td></td>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->status }}</td>
                <td>{{ $category->created_at }}</td>
                <td>{{ $category->deleted_at }}</td>
                <td><img src="{{ asset('storage/'.$category->image) }}" height="50" alt=""></td>
                <td>
                    <form action="{{ route('dashboard.categories.restore',$category->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-sm btn-outline-primary" type="submit">Restore</button>
                    </form>
                </td>
                <td>
                    <form action="{{ route('dashboard.categories.force-delete',$category->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" type="submit">Force Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No categories defined.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    {{ $categories->withQueryString()->links() }}
@endsection
