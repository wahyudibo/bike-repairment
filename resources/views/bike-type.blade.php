@extends('layout.dashboard')

@section('content')
<div class="row mb-3" style="display: none;">
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                FORM TIPE SEPEDA
                <a href="#" class="float-right" id="bikeTypeFormClose">
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
                    <form id="bikeTypeForm">
                        <input type="hidden" name="id" value="">

                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" placeholder="Nama Tipe Sepeda" data-parsley-required>
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
        TIPE SEPEDA
        <button class="btn btn-outline-dark btn-sm float-right" id="bikeTypeFormButton">
            <i class="fa fa-plus"></i>
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered datatable" width="100%" id="bikeTypeDataTable" cellspacing="0">
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
        $('#dataMenuCollapse > li:eq(1)').addClass('active');

        var datatable = $('#bikeTypeDataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url('api/bike-types') }}',
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
                var bikeTypeId = $(this).val();

                $.getJSON('{{ url('api/bike-types') }}' + '/' + bikeTypeId, function(res) {
                    $('#bikeTypeForm').closest('div.row').show();
                    $('#bikeTypeForm').find('input[name=id]').val(res.data.id);
                    $('#bikeTypeForm').find('input[name=name]').val(res.data.name);
                });
            });

            $('.btn-delete').on('click', function() {
                var bikeTypeId = $(this).val();
                var bikeTypeName = $(this).closest('tr').children('td:eq(1)').text();

                $('#bikeTypeForm').closest('div.row').hide();

                swal({
                    title: 'Hapus data',
                    html: 'Hapus data <strong>' + bikeTypeName + '</strong> ?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonText: 'Batal',
                    confirmButtonText: 'Hapus'
                })
                .then(function () {
                    $.ajax({
                        url: '{{ url('api/bike-types') }}' + '/' + bikeTypeId,
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

        $('#bikeTypeFormButton').on('click', function() {
            $('#bikeTypeForm').find('input[name=id]').val('');
            $('#bikeTypeForm')[0].reset();
            $('#bikeTypeForm').closest('div.row').show();
        });

        $('#bikeTypeFormClose').on('click', function() {
            $('#bikeTypeForm').closest('div.row').hide();
        });

        $('#bikeTypeForm').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);

            form.parsley().validate();

            if (!form.parsley().isValid()) {
                return false;
            }

            var isEdit = $('input[name=id]').val() !== '';
            var bikeTypeId = isEdit ? $('input[name=id]').val() : '';
            var method = isEdit ? 'PUT' : 'POST';
            var url = bikeTypeId
                ? '{{ url('api/bike-types') }}' + '/' + bikeTypeId
                : '{{ url('api/bike-types') }}';

            $.ajax({
                url: url,
                method: method,
                data: form.serialize(),
                dataType: 'json',
                beforeSend: function() {
                    $('#bikeTypeForm').closest('div.row .card').block();
                }
            })
            .done(function(res) {
                if (res.status === 'success') {
                    form[0].reset();
                    datatable.clear().draw();

                    if (isEdit) {
                        $('#bikeTypeForm').closest('div.row').hide();
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
                $('#bikeTypeForm').closest('div.row .card').unblock();
            });

        });
    });
</script>
@endsection