@extends('layouts.dashboard')
@section("page_header","Categories")
@section("page_name")
    @parent
    <li class="breadcrumb-item active">Categories</li>
@endsection
@section('content')
    <div class="mb-5">
        @can('create','App\Models\Category')
        <a href="{{ route('dashboard.categories.create') }}" class="btn btn-primary mr-2">Create Category</a>
        @endcan
        <a href="{{ route('dashboard.categories.trash') }}" class="btn btn-dark">Trash Categories</a>

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
            <th>Parent</th>
            <th>Status</th>
            <th>Products Number</th>
            <th>Created At</th>
            <th>Image</th>
            <th colspan="2"></th>

        </tr>
        </thead>
        <tbody>
        @forelse($categories as $category)
            <tr>
                <td></td>
                <td>{{ $category->id }}</td>
                <td><a href="{{ route('dashboard.categories.show',$category->id) }}">
                        {{ $category->name }}
                    </a></td>
                <td>{{ $category->parent->name }}</td>
                <td>{{ $category->status }}</td>
                <td>{{ $category->products_count }}</td>
                <td>{{ $category->created_at }}</td>
                <td><img src="{{ asset('storage/'.$category->image) }}" height="50" alt=""></td>
                <td>
                    @can('update',$category)
                    <a href="{{ route('dashboard.categories.edit',$category->id) }}"
                       class="btn btn-sm btn-outline-success">Edit</a>
                    @endcan
                </td>
                <td>
                    @can('delete',$category)
                    <form action="{{ route('dashboard.categories.destroy',$category->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                    </form>
                    @endcan
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
