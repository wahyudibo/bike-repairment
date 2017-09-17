<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Sistem Pelaporan Layanan Bengkel Sepeda UGM</title>

  @include('shared.styles')
  @include('dashboard.styles')
  @yield('styles')
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="#">Bengkel Sepeda Kampus UGM</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive"
      aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav">
        <li class="nav-item active" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="{{ route('dashboard') }}">
              <i class="fa fa-fw fa-dashboard"></i>
              <span class="nav-link-text">
                Dashboard</span>
            </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Rekapitulasi">
          <a class="nav-link" href="{{ route('report') }}">
              <i class="fa fa-fw fa-bar-chart"></i>
              <span class="nav-link-text">
                Rekapitulasi</span>
            </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Data">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti">
              <i class="fa fa-fw fa-table"></i>
              <span class="nav-link-text">
                Data</span>
            </a>
          <ul class="sidenav-second-level collapse" id="collapseMulti">
            <li>
              <a href="{{ route('work-unit') }}">Unit Kerja</a>
            </li>
            <li>
              <a href="{{ route('bike-type') }}">Tipe Sepeda</a>
            </li>
          </ul>
        </li>
      </ul>
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
              <i class="fa fa-fw fa-angle-left"></i>
            </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#logoutModal">
              <i class="fa fa-fw fa-sign-out"></i>
              Logout</a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="content-wrapper">
    <div class="container-fluid">

      @yield('content')

    </div>
    <!-- /.container-fluid -->
  </div>

  <footer class="sticky-footer">
    <div class="container">
      <div class="text-center">
        <small>Copyright &copy; Bengkel Sepeda Kampus 2017</small>
      </div>
    </div>
  </footer>

  <!-- Scroll to Top Button -->
  <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>

  <!-- Logout Modal -->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="logoutModalLabel">Keluar Dari Sistem?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          Pilih logout untuk keluar dari sistem
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
          </form>
        </div>
      </div>
    </div>
  </div>

  @include('shared.scripts')
  @include('dashboard.scripts')
  @yield('scripts')
</body>

</html>