@extends('layouts.backend.app')

@section('title')
Murid
@endsection

@section('content')

@if ($message = Session::get('success'))
<div class="alert alert-success" role="alert">
    <div class="alert-body">
        <strong>{{ $message }}</strong>
        <button type="button" class="close" data-dismiss="alert">×</button>
    </div>
</div>
@elseif($message = Session::get('error'))
<div class="alert alert-danger" role="alert">
    <div class="alert-body">
        <strong>{{ $message }}</strong>
        <button type="button" class="close" data-dismiss="alert">×</button>
    </div>
</div>
@endif
<div class="content-wrapper container-xxl p-0">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2> Murid</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="row">
            <div class="col-12">
                <section>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title">Murid

                                        <form id="importForm" action="{{ url('importExcelMurid') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <label for="fileInput" class="btn btn-success mt-1">
                                                <img src="{{asset('Assets/Backend/images/excel.png')}}"
                                                    style="width:15px; margin-right:5px;">
                                                Import
                                                Excel</label>
                                            <input type="file" name="file" id="fileInput" class="d-none" required>
                                        </form>
                                    </h4>
                                </div>
                                <div class="card-datatable">
                                    <table class="dt-responsive table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>NISN</th>
                                                <th>Email</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Kelas Ke</th>
                                                <th>Nama Kelas</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @php
                                            $no = 1;
                                            @endphp

                                            @foreach ($murid as $user)
                                            @foreach($user->dataMurid as $userDetail)
                                            <tr>
                                                <td></td>
                                                <td> {{$no++}} </td>
                                                <td> {{$user->name}} </td>
                                                <td> {{$userDetail->nisn}} </td>
                                                <td> {{$user->email}} </td>
                                                <td> {{$userDetail->jenis_kelamin}} </td>
                                                <td> {{$userDetail->kelas}} </td>
                                                <td> {{$userDetail->nama_kelas}} </td>
                                                <td> {{$user->status}} </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href=" {{route('backend-pengguna-murid.edit', $user->id)}} "
                                                            class="btn btn-success btn-sm mr-2">Edit</a>

                                                        <form
                                                            action="{{ route('backend-pengguna-murid.destroy', $user->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus murid ini?')">
                                                                <i class="bi bi-trash-fill"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection