@extends('layout.master')

@section('styles')
<link rel="stylesheet" href="{{ asset('vendor/css/jquery.fullpage.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/front.min.css') }}">
@endsection

@section('navbar')

@include('navbar.fixed-dark');

@endsection

@section('content')
<div id="fullpage">
    <div class="section text-center">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>Layanan Bengkel Sepeda Kampus UGM</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-8 mx-auto">
                    <p class="sub-content">
                        Jika anda memerlukan bantuan karena sepeda anda rusak atau anda menemukan sepeda yang rusak, silakan untuk menghubungi
                        kami dan kami akan segera mengirimkan petugas untuk menangani masalah anda.
                    </p>
                    <button type="button" class="btn btn-primary" id="startBtn">Buat Laporan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="section">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-12">
                    <form id="repairmentForm">
                        {{ csrf_field() }}

                        <input type="hidden" name="latitude" id="lat" value="">
                        <input type="hidden" name="longitude" id="long" value="">

                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input
                                type="text"
                                class="form-control"
                                name="name"
                                id="name"
                                data-parsley-required
                                data-parsley-error-message="Field nama wajib diisi">
                        </div>
                        <div class="form-group">
                            <label for="id">NIP / NIU</label>
                            <input type="text" class="form-control" name="identityNumber" id="id">
                        </div>
                        <div class="form-group">
                            <label for="phone">No. Telepon</label>
                            <input
                                type="text"
                                class="form-control"
                                name="phone"
                                id="phone"
                                data-parsley-required
                                data-parsley-error-message="Field telepon wajib diisi">
                        </div>
                        <div class="form-group">
                            <label for="remark">Laporan</label>
                            <textarea
                                class="form-control"
                                name="remark"
                                id="remark"
                                rows="3"
                                data-parsley-required
                                data-parsley-error-message="Field laporan wajib diisi"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="unit">Unit Kerja</label>
                            <select class="form-control" name="workUnit" id="workUnit">
                                    <option value="">-- Pilih Unit Kerja --</option>
                                    <option value="1">Fakultas MIPA</option>
                                    <option value="2">Fakultas Teknik</option>
                                    <option value="3">Fakultas ISIPOL</option>
                                    <option value="4">Fakultas Ekonomika & Bisnis</option>
                                    <option value="5">Fakultas Kedokteran</option>
                                </select>
                        </div>
                        <div class="form-group">
                            <label for="bikeType">Tipe Sepeda</label>
                            <select class="form-control" name="bikeType" id="bikeType">
                                    <option value="">-- Pilih Tipe Sepeda --</option>
                                    <option value="1">Sepeda Kampus</option>
                                    <option value="2">Sepeda Dinas</option>
                                </select>
                        </div>
                        <br>
                        <button type="button" class="btn btn-primary btn-block" id="formBtn">Selanjutnya</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="section">
        <div class="container-fluid">
            <div id="map"></div>
            <div class="row">
                <div class="col-11 mx-auto">
                    <button type="button" class="btn btn-primary btn-block" id="mapBtn">Kirim Laporan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="section text-center">
        <div class="intro">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1>Terimakasih Atas Laporan Anda!</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8 mx-auto">
                        <p class="sub-content">
                            Laporan anda akan segera kami proses dan petugas kami akan segera mendatangi anda.
                            <br/>
                            ID Laporan:
                                <strong>
                                    <span id="reportNumber"></span>
                                </strong>
                            <br/>
                            No Antrian:
                                <strong>
                                    <span id="waitingReports"></span>
                                </strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('vendor/js/scrolloverflow.min.js') }}"></script>
<script src="{{ asset('vendor/js/jquery.fullpage.min.js') }}"></script>
<script src="{{ asset('js/front.min.js') }}"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuEW184kfvX3SNt7lwHD1nqoN-1U8jdeU&callback=initMap">
</script>

<script type="text/javascript">
    function initMap() {
        // Init map with UGM location
        var location = new google.maps.LatLng(-7.7713794, 110.3753111);

        var mapCanvas = document.getElementById('map');
        var mapOptions = {
            center: location,
            zoom: 16,
            panControl: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(mapCanvas, mapOptions);

        var marker = new google.maps.Marker({
            draggable: true,
            position: location,
            map: map,
        });

        var updateLatLongInput = function(location) {
            $('#lat').val(location.lat());
            $('#long').val(location.lng());
        }

        function placeMarkerAndPanTo(location, map) {
            marker.setPosition(location);
            map.panTo(location);
            updateLatLongInput(location);
        }

        map.addListener('click', function(e) {
            placeMarkerAndPanTo(e.latLng, map);
        });

        google.maps.event.addListener(marker, 'dragend', function (e) {
            updateLatLongInput(e.latLng);
        });

        // set default location if user not click or drag the marker
        updateLatLongInput(location);
    }

    $(function () {
        $('#fullpage').fullpage({
            sectionsColor: ['#052A49', '#FAF8F1', '#FFFFFF', '#3D7F76'],
            keyboardScrolling: false,
            scrollOverflow: true,
        });

        $.fn.fullpage.setMouseWheelScrolling(false);
        $.fn.fullpage.setAllowScrolling(false);

        $('#startBtn').on('click', function () {
            $.fn.fullpage.moveTo(2);
        });

        $('#formBtn').on('click', function () {
            var form = $('#repairmentForm');

            form.parsley().validate();

            if (!form.parsley().isValid()) {
                return false;
            }

            $.fn.fullpage.moveTo(3);
        });

        $('#mapBtn').on('click', function () {
            $.ajax({
                url: '{{ url('api/repairment') }}',
                method: 'POST',
                data: $('#repairmentForm').serialize(),
                dataType: 'json',
                beforeSend: function() {
                    $('.section:eq(2)').block();
                },
            })
            .done(function(res) {
                console.log(res);
                $('#reportNumber').html(res.data.reportNumber);
                $('#waitingReports').html(res.data.waitingReports);

                $.fn.fullpage.moveTo(4);
            })
            .fail(function(xhr) {
                swal('Error!', xhr.responseText, 'error')
            })
            .always(function() {
                $('.section:eq(2)').unblock();
            });
        });
    });
</script>
@endsection