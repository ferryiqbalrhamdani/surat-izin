<div>
    @include('livewire.modal.data.data-cuti-modal')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between">
            <div class="">
                <h1 class="mt-4">Data Cuti</h1>
            </div>
            <div class="mt-4">
                <a class="btn btn-dark position-relative" data-bs-toggle="tooltip" data-bs-placement="left"
                    title="Pemberitahuan">
                    <i class="fa-solid fa-bell"></i>
                    @if(Auth::user()->role_id == 4)
                    @if($countAtasan != NULL)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{$countAtasan }}
                    </span>
                    @endif
                    @elseif(Auth::user()->role_id == 3)
                    @if($countHrd != NULL)

                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{$countHrd }}
                    </span>
                    @endif
                    @endif
                </a>
                <span class="badge rounded-pill bg-danger"></span>
            </div>

        </div>

        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Data Cuti</li>
        </ol>


        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-6">
                                    <h6 class="mt-1">
                                        <i class="fas fa-table me-1"></i>
                                        Tabel Cuti
                                    </h6>
                                </div>
                                <div class="col-12 col-md-8 col-lg-6">
                                    <div class="text-end">
                                        <input type="date" wire:model.live='dari'>
                                        <i class="fa-solid fa-arrow-right"></i>
                                        <input type="date" wire:model.live='sampai'>
                                        @error('sampai')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-lg-3">
                                    <div class="mb-3 mt-1">
                                        Show <select class=" card-hover" aria-label="Small select example"
                                            wire:model.live='perPage'>
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                            <option value="500">500</option>
                                        </select> entries
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6"></div>
                                <div class="col-12 col-lg-3">
                                    <div class="mb-3 shadow-sm ">
                                        <input type="text" class="form-control card-hover" placeholder="Cari"
                                            wire:model.live='search'>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-dark btn-dark dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false" @if ($mySelected==NULL) disabled
                                        @endif>
                                        Action
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if(Auth::user()->role_id == 3)
                                        <li><a style="cursor: pointer" class="dropdown-item text-success"
                                                wire:click='approveSelected'><i class="fa-solid fa-circle-check"></i>
                                                Approve</a></li>
                                        <li><a style="cursor: pointer" class="dropdown-item text-danger"
                                                wire:click='rejectSelected'><i class="fa-solid fa-circle-xmark"></i>
                                                Reject</a></li>
                                        <li><a style="cursor: pointer" class="dropdown-item"
                                                wire:click='resetDataSelected'><i
                                                    class="fa-solid fa-arrow-rotate-left"></i> Reset</a></li>
                                        @elseif(Auth::user()->role_id == 4)
                                        <li><a style="cursor: pointer" class="dropdown-item text-success"
                                                wire:click='approveSelectedAtasan'><i
                                                    class="fa-solid fa-circle-check"></i>
                                                Approve</a></li>
                                        <li><a style="cursor: pointer" class="dropdown-item text-danger"
                                                wire:click='rejectSelectedAtasan'><i
                                                    class="fa-solid fa-circle-xmark"></i>
                                                Reject</a></li>
                                        <li><a style="cursor: pointer" class="dropdown-item"
                                                wire:click='resetDataSelectedAtasan'><i
                                                    class="fa-solid fa-arrow-rotate-left"></i> Reset</a></li>
                                        @endif
                                    </ul>
                                </div>
                                @if($mySelected != NULL)

                                <span> {{count($mySelected)}} data dipilih</span>

                                @endif
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover shadow-sm" style="white-space: nowrap">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col" class="text-center">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="flexCheckDefault" wire:model.live='selectAll'>
                                                    <input type="text" hidden wire:model.live='firstId' value="
                                                                @if(Auth::user()->role_id == 3 && $dataCutiHrd->count() > 0) 
                                                                    {{$dataCutiHrd[0]->id}} 
                                                                @elseif(Auth::user()->role_id == 4 && $dataCuti->count() > 0) 
                                                                    {{$dataCuti[0]->id}} 
                                                                @endif
                                                            ">
                                                </div>
                                            </th>
                                            <th scope="col">
                                                Nama
                                                <span wire:click="sortBy('name')"
                                                    style="cursor: pointer; font-size: 10px">
                                                    <i
                                                        class="fa fa-arrow-up {{$sortField === 'name' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                                    <i
                                                        class="fa fa-arrow-down {{$sortField === 'name' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                                </span>
                                            </th>
                                            <th scope="col">
                                                Keperluan Cuti
                                                <span wire:click="sortBy('keperluan_cuti')"
                                                    style="cursor: pointer; font-size: 10px">
                                                    <i
                                                        class="fa fa-arrow-up {{$sortField === 'keperluan_cuti' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                                    <i
                                                        class="fa fa-arrow-down {{$sortField === 'keperluan_cuti' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                                </span>
                                            </th>
                                            <th scope="col">
                                                Tanggal Cuti
                                                <span wire:click="sortBy('tanggal_cuti')"
                                                    style="cursor: pointer; font-size: 10px">
                                                    <i
                                                        class="fa fa-arrow-up {{$sortField === 'tanggal_cuti' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                                    <i
                                                        class="fa fa-arrow-down {{$sortField === 'tanggal_cuti' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                                </span>
                                            </th>
                                            <th scope="col">
                                                Lama Cuti
                                                <span wire:click="sortBy('durasi')"
                                                    style="cursor: pointer; font-size: 10px">
                                                    <i
                                                        class="fa fa-arrow-up {{$sortField === 'durasi' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                                    <i
                                                        class="fa fa-arrow-down {{$sortField === 'durasi' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                                </span>
                                            </th>
                                            <th scope="col">
                                                Status
                                                <span wire:click="sortBy('status')"
                                                    style="cursor: pointer; font-size: 10px">
                                                    <i
                                                        class="fa fa-arrow-up {{$sortField === 'status' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                                    <i
                                                        class="fa fa-arrow-down {{$sortField === 'status' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                                </span>
                                            </th>
                                            <th scope="col" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(Auth::user()->role_id == 4)
                                        @if ($dataCuti->count() == 0)
                                        <tr>
                                            <td colspan="8" class="text-center">Tidak ada data.</td>
                                        </tr>
                                        @else
                                        @foreach ($dataCuti as $di)
                                        <tr class="">
                                            <td scope="row" class="text-center">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="{{$di->id}}"
                                                        wire:model.live='mySelected'>
                                                </div>
                                            </td>
                                            <td scope="row">
                                                {{$di->name}}
                                            </td>
                                            <td>
                                                {{$di->keperluan_cuti}}
                                            </td>
                                            <td>
                                                {{date('Y-m-d', strtotime($di->tanggal_cuti)) }}
                                            </td>
                                            <td>
                                                {{$di->durasi}}
                                            </td>

                                            <td>
                                                @if ($di->status == 0)
                                                <span class="badge rounded-pill text-bg-warning">proccess</span>
                                                @elseif($di->status == 1)
                                                <span class="badge rounded-pill text-bg-success">approved</span>
                                                @if ($di->status_hrd == 0)
                                                <span class="badge rounded-pill text-bg-warning">proccess by HRD</span>
                                                @elseif($di->status_hrd == 1)
                                                <span class="badge rounded-pill text-bg-success">approved by HRD</span>
                                                @elseif($di->status_hrd == 2)
                                                <span class="badge rounded-pill text-bg-danger">rejected by HRD</span>
                                                @endif
                                                @elseif($di->status == 2)
                                                <span class="badge rounded-pill text-bg-danger">rejected</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-primary"
                                                    wire:click='lihatcuti({{$di->id}})'>
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                                @if(Auth::user()->role_id == 4)
                                                @if($di->status == 0)
                                                <button class="btn btn-sm btn-success "
                                                    wire:click='approveAtasan({{$di->id}})'>
                                                    <i class="fa-solid fa-circle-check"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger"
                                                    wire:click='rejectAtasan({{$di->id}})'>
                                                    <i class="fa-solid fa-circle-xmark"></i>
                                                </button>
                                                @else
                                                <button class="btn btn-sm btn-secondary"
                                                    wire:click='resetAtasan({{$di->id}})' @if($di->status_hrd > 0)
                                                    disabled
                                                    @endif>
                                                    <i class="fa-solid fa-arrow-rotate-left"></i> Reset
                                                </button>
                                                @endif
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        @elseif(Auth::user()->role_id == 3)
                                        @if ($dataCutiHrd->count() == 0)
                                        <tr>
                                            <td colspan="8" class="text-center">Tidak ada data.</td>
                                        </tr>
                                        @else
                                        @foreach ($dataCutiHrd as $dih)
                                        <tr class="">
                                            <td scope="row" class="text-center">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="{{$dih->id}}"
                                                        wire:model.live='mySelected'>
                                                </div>
                                            </td>
                                            <td scope="row">
                                                {{$dih->name}}
                                            </td>
                                            <td>
                                                {{$dih->keperluan_cuti}}
                                            </td>
                                            <td>
                                                {{date('Y-m-d', strtotime($dih->tanggal_cuti)) }}
                                            </td>
                                            <td>
                                                {{$dih->durasi}}
                                            </td>

                                            <td>
                                                @if($dih->status_hrd == 0)
                                                <span class="badge rounded-pill text-bg-warning">proccess</span>
                                                @elseif($dih->status_hrd == 1)
                                                <span class="badge rounded-pill text-bg-success">approved</span>
                                                @elseif($dih->status_hrd == 2)
                                                <span class="badge rounded-pill text-bg-danger">rejected</span>
                                                @endif

                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-primary"
                                                    wire:click='lihatcuti({{$dih->id}})'>
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                                @if($dih->status_hrd == 0)
                                                <button class="btn btn-sm btn-success "
                                                    wire:click='approveHrd({{$dih->id}})'>
                                                    <i class="fa-solid fa-circle-check"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger"
                                                    wire:click='rejectHrd({{$dih->id}})'>
                                                    <i class="fa-solid fa-circle-xmark"></i>
                                                </button>
                                                @else
                                                <button class="btn btn-sm btn-secondary"
                                                    wire:click='resetHrd({{$dih->id}})'>
                                                    <i class="fa-solid fa-arrow-rotate-left"></i> Reset
                                                </button>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            @if(Auth::user()->role_id == 4)
                            <div class="row">
                                <div class="col-12 col-lg-8">
                                    <span>Halaman : {{ $dataCuti->currentPage() }} </span><br />
                                    <span>Jumlah Data : @if($search == '') {{$dataCuti->total()}} @else
                                        {{$dataCuti->count() }}
                                        @endif</span><br />
                                    <span>Data Per Halaman : {{ $dataCuti->perPage()}} </span><br /><br />
                                </div>
                                <div class="col-12 col-lg-4 d-flex justify-content-end">
                                    {{$dataCuti->links()}}

                                </div>
                            </div>
                            @elseif(Auth::user()->role_id == 3)
                            <div class="row">
                                <div class="col-12 col-lg-8">
                                    <span>Halaman : {{ $dataCutiHrd->currentPage() }} </span><br />
                                    <span>Jumlah Data : @if($search == '') {{$dataCutiHrd->total()}} @else
                                        {{$dataCutiHrd->count() }}
                                        @endif</span><br />
                                    <span>Data Per Halaman : {{ $dataCutiHrd->perPage()}} </span><br /><br />
                                </div>
                                <div class="col-12 col-lg-4 d-flex justify-content-end">
                                    {{$dataCutiHrd->links()}}

                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>