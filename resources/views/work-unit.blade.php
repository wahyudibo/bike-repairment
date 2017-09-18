@extends('layout.dashboard')

@section('content')
<div class="row mb-3" style="display: none;">
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                FORM UNIT KERJA
                <a href="#" class="float-right" id="workUnitFormClose">
                    <i class="fa fa-times"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="error" style="display: none;">
                        <div class="alert alert-danger" role="alert">
                            <ul></ul>
                        </div>
                    </div>
                    <form id="workUnitForm">
                        <input type="hidden" name="id" value="">

                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" placeholder="Nama Unit Kerja" data-parsley-required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2 mx-auto">
                                <button type="submit" class="btn btn-primary">Simpan</button>
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
        UNIT KERJA
        <button class="btn btn-outline-dark btn-sm float-right" id="workUnitFormButton">
            <i class="fa fa-plus"></i>
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered datatable" width="100%" id="workUnitDataTable" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
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
        $('li:eq(2).nav-item > a').removeClass('collapsed');
        $('#dataMenuCollapse').addClass('show');
        $('#dataMenuCollapse > li:eq(0)').addClass('active');

        var datatable = $('#workUnitDataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url('api/work-units') }}',
            columns: [
                {
                    data: 'id',
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'name' },
                { data: 'action', searchable: false, orderable: false, width: '6em' }
            ]
        });

        datatable.on('draw', function() {
            $('.btn-edit').on('click', function() {
                var workUnitId = $(this).val();

                $.getJSON('{{ url('api/work-units') }}' + '/' + workUnitId, function(res) {
                    $('#workUnitForm').closest('div.row').show();
                    $('#workUnitForm').find('input[name=id]').val(res.data.id);
                    $('#workUnitForm').find('input[name=name]').val(res.data.name);
                });
            });

            $('.btn-delete').on('click', function() {
                var workUnitId = $(this).val();
                var workUnitName = $(this).closest('tr').children('td:eq(1)').text();

                $('#workUnitForm').closest('div.row').hide();

                swal({
                    title: 'Hapus data',
                    html: 'Hapus data <strong>' + workUnitName + '</strong> ?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonText: 'Batal',
                    confirmButtonText: 'Hapus'
                })
                .then(function () {
                    $.ajax({
                        url: '{{ url('api/work-units') }}' + '/' + workUnitId,
                        method: 'DELETE',
                        dataType: 'json',
                    })
                    .done(function(res) {
                        if (res.status === 'success') {
                            datatable.clear().draw();
                        } else if (res.status === 'error') {
                            swal('Error!', res.message, 'error');
                        }
                    })
                    .fail(function(xhr) {
                        swal('Error!', xhr.responseText, 'error');
                    });
                });
            });
        });

        $('#workUnitFormButton').on('click', function() {
            $('#workUnitForm').find('input[name=id]').val('');
            $('#workUnitForm')[0].reset();
            $('#workUnitForm').closest('div.row').show();
        });

        $('#workUnitFormClose').on('click', function() {
            $('#workUnitForm').closest('div.row').hide();
        });

        $('#workUnitForm').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);

            form.parsley().validate();

            if (!form.parsley().isValid()) {
                return false;
            }

            var isEdit = $('input[name=id]').val() !== '';
            var workUnitId = isEdit ? $('input[name=id]').val() : '';
            var method = isEdit ? 'PUT' : 'POST';
            var url = workUnitId
                ? '{{ url('api/work-units') }}' + '/' + workUnitId
                : '{{ url('api/work-units') }}';

            $.ajax({
                url: url,
                method: method,
                data: form.serialize(),
                dataType: 'json',
                beforeSend: function() {
                    $('#workUnitForm').closest('div.row .card').block();
                }
            })
            .done(function(res) {
                if (res.status === 'success') {
                    form[0].reset();
                    datatable.clear().draw();

                    if (isEdit) {
                        $('#workUnitForm').closest('div.row').hide();
                    }
                }

                if (res.status === 'error' && res.message.includes('Validation')) {
                    var validationList = res.data.map(function (message) {
                        return '<li>'+ message +'</li>'
                    });

                    $('.error ul').html(validationList);
                }

                if (res.status === 'error') {
                    swal('Error!', res.message, 'error');
                }
            })
            .fail(function(xhr) {
                swal('Error!', xhr.responseText, 'error');
            })
            .always(function() {
                $('#workUnitForm').closest('div.row .card').unblock();
            });

        });
    });
</script>
@endsection