@extends('layout.dashboard')

@section('content')

<div class="row mb-3">
    <div class="col-6">
        <div class="card">
    <div class="card-header">
        FORM TIPE SEPEDA
        <a href="#" class="float-right"><i class="fa fa-times"></i></a>
    </div>
    <div class="card-body">
        <div class="container">
            <form>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputEmail3" placeholder="Nama Tipe Sepeda">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 mx-auto">
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        TIPE SEPEDA
        <button class="btn btn-outline-dark btn-sm float-right"><i class="fa fa-plus"></i></button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Sepeda Kampus</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-warning"><i class="fa fa-pencil"></i></button>
                            <button type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Sepeda Dinas</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-warning"><i class="fa fa-pencil"></i></button>
                            <button type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection