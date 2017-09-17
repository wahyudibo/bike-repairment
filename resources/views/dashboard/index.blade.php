@extends('layout.dashboard')

@section('content')
<!-- Icon Cards -->
<div class="row">
    <div class="col-xl-4 col-sm-6 mb-3">
        <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-header text-center">
                Menunggu Penanganan
            </div>
            <div class="card-body">
                <h1 class="text-center">26</h1>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6 mb-3">
        <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-header text-center">
                Dalam Penanganan
            </div>
            <div class="card-body">
                <h1 class="text-center">14</h1>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6 mb-3">
        <div class="card text-white bg-success o-hidden h-100">
            <div class="card-header text-center">
                Selesai
            </div>
            <div class="card-body">
                <h1 class="text-center">12</h1>
            </div>
        </div>
    </div>
</div>


<div class="card mb-3">
    <div class="card-header">
        DAFTAR LAPORAN HARI INI
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIP / NIU</th>
                        <th>No Telpon</th>
                        <th>Unit Kerja</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIP / NIU</th>
                        <th>No Telpon</th>
                        <th>Unit Kerja</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Wahyudi Wibowo</td>
                        <td>323816</td>
                        <td>085643036837</td>
                        <td>Fakultas MIPA</td>
                        <td>MENUNGGU</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-primary"><i class="fa fa-eye"></i></button>
                            <button type="button" class="btn btn-success"><i class="fa fa-check"></i></button>
                            <button type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection