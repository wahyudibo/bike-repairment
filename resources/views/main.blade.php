<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistem Pelaporan Layanan Bengkel Sepeda UGM</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.fullpage.min.css') }}">

    <style>
        /* Style for our header texts
	* --------------------------------------- */

        h1 {
            font-size: 3em;
            font-family: arial, helvetica;
            color: #fff;
            margin: 0;
        }

        p.sub {
            color: #fff;
        }

        #map {
        height: 640px;
        width: 100%;
       }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="/">Bengkel Sepeda Kampus UGM</a>
    </nav>

    <div id="fullpage">
        <div class="section text-center" id="section0">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1>Selamat Datang di Layanan Bengkel Sepeda Kampus UGM</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8 mx-auto">
                        <p class="sub">
                            Jika anda memerlukan bantuan karena sepeda yang rusak atau anda menjumpai adanya sepeda yang rusak, silakan untuk menghubungi
                            kami dan kami akan segera mengirimkan petugas untuk menangani masalah anda.
                        </p>
                        <button type="button" class="btn btn-primary" id="start">Buat Laporan</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="section" id="section1">
            <div class="container">
                <div class="row no-gutters">
                    <div class="col-6">
                        <form>
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                            <div class="form-group">
                                <label for="id">NIP / NIU</label>
                                <input type="text" class="form-control" id="id">
                            </div>
                            <div class="form-group">
                                <label for="phone">No. Telepon</label>
                                <input type="text" class="form-control" id="phone">
                            </div>
                            <div class="form-group">
                                <label for="phone">Unit Kerja</label>
                                <select class="form-control">
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
                                <select class="form-control">
                                    <option value="1">Sepeda Kampus</option>
                                    <option value="2">Sepeda Dinas</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="location">Lokasi</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="lat">
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="long">
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary btn-block">Kirim</button>
                        </form>
                    </div>
                    <div class="col-5 ml-auto">
                        <div id="map"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section text-center" id="section2">
            <div class="intro">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h1>Terimakasih Atas Laporan Anda!</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8 mx-auto">
                            <p class="sub">
                                Laporan anda akan segera kami proses.
                                <br/> No laporan Anda adalah : 123456.
                                <br/> Jumlah laporan yang sedang ditangani : 6
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.fullpage.min.js') }}"></script>

    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuEW184kfvX3SNt7lwHD1nqoN-1U8jdeU&callback=initMap">
    </script>

    <script type="text/javascript">
        $(function () {
            $('#fullpage').fullpage({
                sectionsColor: ['#052A49', '#FAF8F1' ,'#3D7F76'],
                keyboardScrolling: false,
            });

            /*$.fn.fullpage.setMouseWheelScrolling(false);
            $.fn.fullpage.setAllowScrolling(false);*/

            $('#start').on('click', function () {
                $.fn.fullpage.moveTo(2);
            });

            $('#send').on('click', function (e) {
                e.preventDefault();
                $.fn.fullpage.moveTo(3);
            });

            function initMap() {

                var location = new google.maps.LatLng(50.0875726, 14.4189987);

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
                    title: 'Hello World!'
                });

                google.maps.event.addListener(marker, 'dragend', function (event) {
                console.log(event.latLng.lat());
                document.getElementById("lat").value = event.latLng.lat();
                document.getElementById("long").value = event.latLng.lng();
            });
            }

            google.maps.event.addDomListener(window, 'load', initMap);


        });
    </script>
</body>
</html