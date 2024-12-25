@extends('layout')
@section('main')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                  <h5 class="alert alert-success">{{session('status')}}</h5>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h3>CREATE USER  <a href="{{route('admin.user.index')}}" class="btn btn-danger float-end">Quay lại</a></h3>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.user.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-3">
                            <label for="">Name</label>
                            <input type="text" name="name"  class="form-control" minlength="3" maxlength="50" required>
                             @error('name')
                             <span class="text-danger">{{ $message }}</span>
                             @enderror
                        </div>
                    <div class="form-group mb-3">
                            <label for="">Email</label>
                            <input type ="text" name="email" id ="" class="form-control" maxlength="255" required>
        @error('email')
            <span class="text-danger">{{ $message }}</span>
        @enderror
                        </div>
                        <div class="form-group mb-3">
                        <label for="">Role</label>
                         <select name="role" class="form-control">
                             <option value="normal_user">Normal User</option>
                             <option value="admin">Admin</option>
                             <option value="moderate_user">Moderate User</option>
                         </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Avatar</label>
                            <input type ="file" name="avatar" id ="" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary">Create user</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection