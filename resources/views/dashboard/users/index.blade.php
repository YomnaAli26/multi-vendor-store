@extends('layouts.dashboard')
@section("page_header","Users")
@section("page_name")
    @parent
    <li class="breadcrumb-item active">Users</li>
@endsection
@section('content')
    <div class="mb-5">
        @can('create','App\Models\User')
        <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary mr-2">Create User</a>
        @endcan
    </div>
    <x-alert type="success"/>
    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Roles</th>
            <th colspan="2"></th>

        </tr>
        </thead>
        <tbody>
        @forelse($users as $user)
            <tr>
                <td></td>
                <td>{{ $user->id }}</td>
                <td>
                    <a href="{{ route('dashboard.users.show',$user->id) }}">
                        {{ $user->name }}
                    </a>
                </td>
                <td>
                    {{$user->email}}
                </td>

                <td>{{implode('-',$user->roles()->pluck('name')->toArray())}}</td>

                <td>
                    @can('update',$user)
                        <a href="{{ route('dashboard.users.edit',$user->id) }}"
                        class="btn btn-sm btn-outline-success">Edit</a>
                    @endcan
                </td>
                <td>
                    @can('delete',$user)
                        <form action="{{ route('dashboard.users.destroy',$user->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                         </form>
                    @endcan
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No users defined.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    {{ $users->withQueryString()->links() }}
@endsection
