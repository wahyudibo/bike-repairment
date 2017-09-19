@extends('layout.dashboard')

@section('content')
<div class="row" id="stats">
    <div class="col-xl-4 col-sm-6 mb-3">
        <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-header text-center">
                MENUNGGU
            </div>
            <div class="card-body">
                <h1 class="text-center">{{ $stats->waiting ?? 0 }}</h1>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6 mb-3">
        <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-header text-center">
                DIKERJAKAN
            </div>
            <div class="card-body">
                <h1 class="text-center">{{ $stats->on_progress ?? 0 }}</h1>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6 mb-3">
        <div class="card text-white bg-success o-hidden h-100">
            <div class="card-header text-center">
                SELESAI
            </div>
            <div class="card-body">
                <h1 class="text-center">{{ $stats->done ?? 0 }}</h1>
            </div>
        </div>
    </div>
</div>


<div class="card mb-3">
    <div class="card-header">
        DAFTAR LAPORAN
        <form class="form-inline float-right">
            <select class="custom-select" id="statusFilter">
                    <option value="" selected>Status: SEMUA</option>
                    <option value="waiting">Status: MENUNGGU</option>
                    <option value="on_progress">Status: DIKERJAKAN</option>
                    <option value="done">Status: SELESAI</option>
                    <option value="canceled">Status: BATAL</option>
                </select>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered datatable" width="100%" id="dashboardDataTable" cellspacing="0">
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
@endsection

@section('scripts')
<script>
    $(function() {
        // Set sidebar menu to active
        $('li.nav-item').removeClass('active');
        $('li:eq(0).nav-item').addClass('active');

        var datatable = $('#dashboardDataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ url('api/dashboard') }}',
                data: function (data) {
                  return $.extend( {}, data, {
                    status: $('#statusFilter').val(),
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

            $('.btn-update-status').on('click', function() {});
            $('.btn-delete').on('click', function() {});
        });

        $('#statusFilter').on('change', function() {
            datatable.clear().draw();
        });

        function updateStats() {
            $.getJSON('{{ url('api/dashboard/stats') }}', function(res) {
                $('#stats').find('.card-body:eq(0) > h1').text(res.data.stats.waiting);
                $('#stats').find('.card-body:eq(1) > h1').text(res.data.stats.on_progress);
                $('#stats').find('.card-body:eq(2) > h1').text(res.data.stats.done);
            });
        }

        // Set interval to always get latest data
        setInterval(function() {
            updateStats();
            datatable.clear().draw();
        }, 180000);
    })
</script>
@endsection