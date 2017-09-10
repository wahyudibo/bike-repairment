@extends('layouts.master')

@section('navbar')
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="/">Bengkel Sepeda Kampus UGM</a>
</nav>
@endsection

@section('content')
<div id="fullpage">
    <div class="section text-center">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>Selamat Datang di Layanan Bengkel Sepeda Kampus UGM</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-8 mx-auto">
                    <p class="sub-content">
                        Jika anda memerlukan bantuan karena sepeda anda rusak atau anda menemukan ada sepeda yang rusak, silakan untuk menghubungi
                        kami dan kami akan segera mengirimkan petugas untuk menangani masalah anda
                    </p>
                    <button type="button" class="btn btn-primary" id="start">Buat Laporan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="section">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-6">
                    <form id="repairmentForm">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
                        <div class="form-group">
                            <label for="id">NIP / NIU</label>
                            <input type="text" class="form-control" name="identityNumber" id="id">
                        </div>
                        <div class="form-group">
                            <label for="phone">No. Telepon</label>
                            <input type="text" class="form-control" name="phone" id="phone">
                        </div>
                        <div class="form-group">
                            <label for="unit">Unit Kerja</label>
                            <select class="form-control" name="unit" id="unit">
                                    <option value="1">Fakultas MIPA</option>
                                    <option value="2">Fakultas Teknik</option>
                                    <option value="3">Fakultas ISIPOL</option>
                                    <option value="4">Fakultas Ekonomika & Bisnis</option>
                                    <option value="5">Fakultas Kedokteran</option>
                                </select>
                        </div>
                        <div class="form-group">
                            <label for="remark">Laporan</label>
                            <textarea class="form-control" name="remark" id="remark" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="bikeType">Tipe Sepeda</label>
                            <select class="form-control" name="bikeType" id="bikeType">
                                    <option value="1">Sepeda Kampus</option>
                                    <option value="2">Sepeda Dinas</option>
                                </select>
                        </div>
                        <div class="form-group">
                            <label for="location">Lokasi</label>
                            <div class="row">
                                <div class="col-6">
                                    <div class="input-group mb-2 mb-sm-0">
                                        <div class="input-group-addon">Lat</div>
                                        <input type="text" class="form-control" name="latitude" id="lat" readonly>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group mb-2 mb-sm-0">
                                        <div class="input-group-addon">Long</div>
                                        <input type="text" class="form-control" name="longitude" id="long" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Kirim</button>
                    </form>
                </div>
                <div class="col-5 ml-auto">
                    <div id="map"></div>
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
                            Laporan anda akan segera kami proses.
                            <br/> No laporan anda adalah : 123456.
                            <br/> Jumlah laporan yang sedang ditangani : 6
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="{{ asset('css/jquery.fullpage.min.css') }}">
<script src="{{ asset('js/jquery.fullpage.min.js') }}"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuEW184kfvX3SNt7lwHD1nqoN-1U8jdeU&callback=initMap">
</script>

<script type="text/javascript">
    $(function () {
        $('#fullpage').fullpage({
            sectionsColor: ['#052A49', '#FAF8F1', '#3D7F76'],
            keyboardScrolling: false,
        });

        $.fn.fullpage.setMouseWheelScrolling(false);
        $.fn.fullpage.setAllowScrolling(false);

        $('#start').on('click', function () {
            $.fn.fullpage.moveTo(2);
        });

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
                updateLatLongInput(location)
            }

            map.addListener('click', function(e) {
                placeMarkerAndPanTo(e.latLng, map);
            });

            google.maps.event.addListener(marker, 'dragend', function (e) {
                updateLatLongInput(e.latLng);
            });
        }

        google.maps.event.addDomListener(window, 'load', initMap);

        $('#repairmentForm').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);

            $.ajax({
                url: '{{ url('api/repairment') }}',
                method: 'POST',
                data: form.serialize(),
                dataType: 'json',
                beforeSend: function() {
                    $('.section:eq(1)').block();
                },
            })
            .done(function(data) {
                $.fn.fullpage.moveTo(3);
            })
            .fail(function(xhr) {

            })
            .always(function() {
                $('.section:eq(1)').unblock();
            });
        });
    });
</script>
@endsection