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
                        <h3>EDIT USER  <a href="{{route('admin.user.index')}}" class="btn btn-danger float-end">Quay lại</a></h3>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.user.update',['id'=>$user->id])}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-3">
                            <label for="">Name</label>
                            <input type ="text" name="name" id ="" value ="{{$user->name}}" class="form-control" minlength="3" maxlength="50" required>
                            @error('email')
                           <span class="text-danger">{{ $message }}</span>
                           @enderror 
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Email</label>
                            <input type ="text" name="email" id ="" value ="{{$user->email}}" class="form-control" maxlength="255" required>
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
                            <label for="">Address</label>
                            <input type ="text" name="address" id ="" class="form-control" value ="{{$user->address}}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">About</label>
                            <input type ="text" name="about" id ="" class="form-control" value ="{{$user->about}}">
                        </div>
                        <!-- <div class="form-group mb-3">
                            <label for="">Password</label>
                            <input type ="text" name="password" id ="" class="form-control" value ="{{$user->password}}">
                        </div> -->
                        <div class="form-group mb-3">
                            <label for="">Avatar</label>
                            <input type ="file" name="avatar" id ="" class="form-control" value ="{{$user->avatar}}">
                            <img src="{{asset('/'.$user->avatar)}}" width="70px" height ="70px" alt="Avatar">
                        </div>
                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection