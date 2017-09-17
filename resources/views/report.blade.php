@extends('layout.dashboard')

@section('content')

<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link active" href="#"><i class="fa fa-table"></i> Tabel</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#"><i class="fa fa-line-chart"></i> Grafik</a>
    </li>
</ul>

<form class="form-inline mb-3">
    <label class="sr-only" for="inlineFormInputGroup">Tanggal Awal</label>
    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
        <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Tanggal Awal">
    </div>

    <label class="sr-only" for="inlineFormInputGroup">Tanggal Akhir</label>
    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
        <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Tanggal Akhir">
    </div>

    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
</form>

<div class="card mb-3">
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

<div class="card mb-3">
    <div class="card-body">
        <iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
        <canvas id="myAreaChart" width="1118" height="335" style="display: block; width: 1118px; height: 335px;"></canvas>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-8 my-auto">
                        <iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                        <canvas id="myBarChart" width="471" height="235" style="display: block; width: 471px; height: 235px;"></canvas>
                    </div>
                    <div class="col-sm-4 text-center my-auto">
                        <div class="h4 mb-0 text-primary">$34,693</div>
                        <div class="small text-muted">YTD Revenue</div>
                        <hr>
                        <div class="h4 mb-0 text-warning">$18,474</div>
                        <div class="small text-muted">YTD Expenses</div>
                        <hr>
                        <div class="h4 mb-0 text-success">$16,219</div>
                        <div class="small text-muted">YTD Margin</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-body">
                <iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                <canvas id="myPieChart" width="325" height="325" style="display: block; width: 325px; height: 325px;"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection