@extends('layout.dashboard')

@section('styles')
<link rel="stylesheet" href="{{ asset('vendor/css/bootstrap-datepicker.standalone.min.css') }}" type="text/css">
@endsection

@section('content')

<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link active" href="#" id="reportTableTab"><i class="fa fa-table"></i> Tabel</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#" id="reportGraphTab"><i class="fa fa-line-chart"></i> Grafik</a>
    </li>
</ul>

<form class="form-inline mb-3" id="reportFilter">
    <label class="sr-only" for="startDate">Tanggal Awal</label>
    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
        <input type="text" class="form-control datepicker" name="startDate" id="startDate" placeholder="Tanggal Awal">
    </div>

    <label class="sr-only" for="endDate">Tanggal Akhir</label>
    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
        <input type="text" class="form-control datepicker" name="endDate" id="endDate" placeholder="Tanggal Akhir">
    </div>

    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
        <select class="custom-select" name="status">
            <option value="" selected>Status: SEMUA</option>
            <option value="waiting">Status: MENUNGGU</option>
            <option value="on_progress">Status: DIKERJAKAN</option>
            <option value="done">Status: SELESAI</option>
            <option value="canceled">Status: BATAL</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
</form>

<div id="reportTableSection">
    <div class="card mb-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered datatable" width="100%" id="reportDataTable" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No.Laporan</th>
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
                        <th>No.Laporan</th>
                        <th>Nama</th>
                        <th>NIP / NIU</th>
                        <th>No Telpon</th>
                        <th>Unit Kerja</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
            </div>
        </div>
    </div>
</div>

<div id="reportGraphSection" style="display: none;">
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-8 my-auto">
                            <iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                            <canvas id="barChartCanvas" width="471" height="235" style="display: block; width: 471px; height: 235px;"></canvas>
                        </div>
                        <div class="col-sm-4 text-center my-auto">
                            <div class="h4 mb-0 text-primary"><span id="waiting">0</span></div>
                            <div class="small text-muted">Laporan Masuk</div>
                            <hr>
                            <div class="h4 mb-0 text-warning"><span id="onProgress">0</span></div>
                            <div class="small text-muted">Laporan Dikerjakan</div>
                            <hr>
                            <div class="h4 mb-0 text-success"><span id="done">0</span></div>
                            <div class="small text-muted">Laporan Selesai</div>
                            <hr>
                            <div class="h4 mb-0 text-danger"><span id="canceled">0</span></div>
                            <div class="small text-muted">Laporan Dibatalkan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-body">
                    <iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                    <canvas id="pieChartCanvas" width="325" height="325" style="display: block; width: 325px; height: 325px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('vendor/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('template/sb-admin/vendor/chart.js/Chart.min.js') }}"></script>
<script>
    $(function() {
        // -- Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#292b2c';

        var barChart;
        var pieChart;

        function initChart() {
            $.getJSON('{{ url('api/report/graph') }}', function(res) {
                // load chart
                var barChartCtx = document.getElementById("barChartCanvas");
                var pieChartCtx = document.getElementById("pieChartCanvas");

                barChart = new Chart(barChartCtx, {
                    type: 'bar',
                    data: {
                        labels: res.data.labels,
                        datasets: [
                            {
                                label: "Jumlah",
                                backgroundColor: "rgba(2,117,216,1)",
                                borderColor: "rgba(2,117,216,1)",
                                data: res.data.numbers,
                            }
                        ],
                    },
                    options: {
                        scales:
                            {
                                xAxes: [
                                    {
                                        gridLines: { display: false },
                                    }
                                ],
                                yAxes: [
                                    {
                                        ticks: { min: 0 },
                                        gridLines: { display: true }
                                    }
                                ],
                            },
                        legend: { display: false }
                    }
                    });


                pieChart = new Chart(pieChartCtx, {
                    type: 'pie',
                    data: {
                        labels: res.data.labels,
                        datasets: [{
                        data: res.data.numbers,
                        backgroundColor: res.data.colors,
                        }],
                    },
                });

                $('#waiting').text(res.data.numbers[0]);
                $('#onProgress').text(res.data.numbers[1]);
                $('#done').text(res.data.numbers[2]);
                $('#canceled').text(res.data.numbers[3]);
            });
        }

        // Set sidebar menu to active
        $('li.nav-item').removeClass('active');
        $('li:eq(1).nav-item').addClass('active');

        $('#reportTableTab').on('click', function() {
            $('#reportGraphTab').removeClass('active');
            $('#reportGraphSection').hide();

            $(this).addClass('active');
            $('#reportTableSection').show();
        });

        $('#reportGraphTab').on('click', function() {
            $('#reportTableTab').removeClass('active');
            $('#reportTableSection').hide();

            $(this).addClass('active');
            $('#reportGraphSection').show();
        });

        $('.datepicker').datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy',
        });

        initChart();

        var datatable = $('#reportDataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ url('api/report/datatable') }}',
                data: function (data) {
                  return $.extend( {}, data, {
                    startDate: $('input[name=startDate]').val(),
                    endDate: $('input[name=endDate]').val(),
                    status: $('select[name=status]').val(),
                  });
                }
            },
            columns: [
                {
                    data: 'id',
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'report_number' },
                { data: 'name' },
                { data: 'identity_number' },
                { data: 'phone' },
                { data: 'unit' },
                {
                    data: 'status',
                    render: function (data, type, row, meta) {
                        var statusInBahasa;

                        switch (data) {
                            case 'WAITING':
                                statusInBahasa = 'MENUNGGU';
                                break;

                            case 'ON_PROGRESS':
                                statusInBahasa = 'DIKERJAKAN';
                                break;

                            case 'DONE':
                                statusInBahasa = 'SELESAI';
                                break;

                            case 'CANCELED':
                                statusInBahasa = 'BATAL';
                                break;
                        }

                        return statusInBahasa;
                    }
                },
                { data: 'action', searchable: false, orderable: false, width: '10em' }
            ]
        });

        datatable.on('draw', function() {
            $('.btn-view').on('click', function() {
                var repairmentId = $(this).val();
                var url = '{{ url('repairment') }}' + '/' + repairmentId + '/map';

                window.open(url);
                return false;
            });
        });

        $('#reportFilter').on('submit', function(e) {
            e.preventDefault();
            datatable.clear().draw();

            var startDate = $('input[name=startDate]').val();
            var endDate = $('input[name=endDate]').val();
            var status = $('select[name=status]').val();

            var qs = $.param({ status: status, startDate: startDate, endDate: endDate });
            var url = '{{ url('api/report/graph') }}' + '?' + qs;

            $.getJSON(url, function(res) {
                barChart.data.labels = res.data.labels;
                barChart.data.datasets.data = res.data.numbers;
                barChart.update();

                pieChart.data.labels = res.data.labels;
                pieChart.data.data = res.data.numbers;
                pieChart.data.backgroundColor = res.data.colors;
                pieChart.update();

                $('#waiting').text(res.data.numbers[0]);
                $('#onProgress').text(res.data.numbers[1]);
                $('#done').text(res.data.numbers[2]);
                $('#canceled').text(res.data.numbers[3]);
            });
        });
    });
</script>
@endsection