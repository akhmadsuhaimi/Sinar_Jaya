@extends('layout.master')
@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">User</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li> <li class="breadcrumb-item active" aria-current="page">Edit User</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="col">
            <div class="card border-0 border-4">
                <div class="card-body p-5">
                    <div class="card-title d-flex align-items-center">
                        <div><i class="font-22 text-primary"></i>
                        </div>
                        <h5 class="mb-0 text-primary">Form Edit User</h5>
                    </div>
                    <hr>
                    <form class="row g-3" action="{{route('user.update', $data->id)}}" method="post">
                          @csrf
                         @method('put')

                          <div class="col-12">
                            <label class="form-label">Nama</label>
                            <input type="text"  class="form-control" placeholder="Masukkan Nama" name="name" required autofocus value="{{$data->name}}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Email</label>
                            <input type="email"  class="form-control" value="{{$data->email}}" placeholder="Masukkan Email" name="email" required >
                        </div>
                        <div class="col-12">
                            <label class="form-label">Level</label>
                            <select class="form-control" name="level" required>
                                <option value="pimpinan" {{$data->level == 'pimpinan' ? 'selected' : ''}}>Pimpinan</option>
                                <option value="admin" {{$data->level == 'admin' ? 'selected' : ''}}>Admin</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password" >
                            <span class="text-muted">abaikan jika tidak ingin ganti password</span>
                        </div>
                        <div class="col-12 mt-5">
                            <button type="submit" class="btn btn-primary px-5">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection