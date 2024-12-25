@extends('layout')
@section('main')
    <div class="container my-4">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <h5 class="alert alert-danger">{{ session('status') }}</h5>
                @endif
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">User Management</h3>
                        <a href="{{ route('admin.user.adduser') }}" class="btn btn-light float-end">Create User</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Avatar</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $user->role }}</span>
                                        </td>
                                        <td>
                                            <img src="{{ asset('/' . $user->avatar) }}" width="70" height="70" alt="Avatar" class="rounded-circle">
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.user.edit', ['id' => $user->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="{{ route('admin.user.delete', ['id' => $user->id]) }}" class="btn btn-sm btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
