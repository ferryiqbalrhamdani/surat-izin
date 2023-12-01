<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>{{ $title ?? 'Page Title' }}</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{asset('vendor/sb-admin/css/styles.css')}}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="/">Surat Izin App</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            {{-- <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
                    aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i
                        class="fas fa-search"></i></button>
            </div> --}}
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="/logout">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Utama</div>
                        <a @if(request()->route()->uri == '/')
                            class="nav-link active"
                            @else
                            class="nav-link"
                            @endif
                            href="/">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 4)

                        <div class="sb-sidenav-menu-heading">Data Input</div>
                        <a @if(request()->route()->uri == 'surat-izin' || request()->route()->uri ==
                            'surat-izin/tambah-data')
                            class="nav-link active"
                            @else
                            class="nav-link"
                            @endif
                            href="/surat-izin">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-solid fa-envelope-open-text"></i>
                            </div>
                            Surat Izin
                        </a>
                        <a class="nav-link" href="charts.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-solid fa-envelope-open-text"></i></div>
                            Izin Cuti
                        </a>
                        <a class="nav-link" href="charts.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-solid fa-envelope-open-text"></i></div>
                            Izin Lembur
                        </a>
                        @endif

                        @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 4 || Auth::user()->role_id == 3)
                        <div class="sb-sidenav-menu-heading">Data</div>
                        <a class="nav-link" href="charts.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-solid fa-table"></i></div>
                            Data Izin
                        </a>
                        <a class="nav-link" href="charts.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-solid fa-table"></i></div>
                            Data Cuti
                        </a>
                        <a class="nav-link" href="charts.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-solid fa-table"></i></div>
                            Data Lembur
                        </a>
                        @endif

                        @if (Auth::user()->role_id == 1)
                        <div class="sb-sidenav-menu-heading">Data Master</div>
                        <a @if(request()->route()->uri == 'user')
                            class="nav-link active"
                            @else
                            class="nav-link"
                            @endif
                            href="/user">
                            <div class="sb-nav-link-icon"><i class="fas fa-solid fa-users-gear"></i></div>
                            Data User
                        </a>
                        <a @if(request()->route()->uri == 'role')
                            class="nav-link active"
                            @else
                            class="nav-link"
                            @endif
                            href="/role">
                            <div class="sb-nav-link-icon"><i class="fas fa-solid fa-database"></i></div>
                            Data Role
                        </a>
                        <a @if(request()->route()->uri == 'pt')
                            class="nav-link active"
                            @else
                            class="nav-link"
                            @endif
                            href="/pt">
                            <div class="sb-nav-link-icon"><i class="fas fa-solid fa-database"></i></div>
                            Data PT
                        </a>
                        <a @if(request()->route()->uri == 'divisi')
                            class="nav-link active"
                            @else
                            class="nav-link"
                            @endif
                            href="/divisi">
                            <div class="sb-nav-link-icon"><i class="fas fa-solid fa-database"></i></div>
                            Data Divisi
                        </a>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-solid fa-gears"></i></div>
                            Data Surat
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="layout-static.html">Surat Izin</a>
                                <a class="nav-link" href="layout-sidenav-light.html">Surat Izin Cuti</a>
                                <a class="nav-link" href="layout-sidenav-light.html">Surat Izin Lembur</a>
                            </nav>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Login Sebagai:</div>
                    {{Auth::user()->name}}
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content" style="background-color: #F2F2F2">
            <main>
                {{ $slot }}

            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    @include('sweetalert::alert')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{asset('vendor/sb-admin/js/scripts.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{asset('vendor/sb-admin/assets/demo/chart-area-demo.js')}}"></script>
    <script src="{{asset('vendor/sb-admin/assets/demo/chart-bar-demo.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="{{asset('vendor/sb-admin/js/datatables-simple-demo.js')}}"></script>
    @stack('role')
    @stack('pt')
    @stack('divisi')
    @stack('users')
    @stack('surat-izin')
</body>

</html>