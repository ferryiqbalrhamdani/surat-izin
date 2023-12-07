<div>
    @include('livewire.modal.data-input.izin-cuti-modal')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Izin Cuti</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Izin Cuti</li>
        </ol>
        <div class="row">
            <div class="col-12 col-lg-3 col-md-6 mb-3">
                <a href="/izin-cuti/tambah-data" class="btn btn-lg btn-dark form-control"><i
                        class="fas fa-solid fa-plus"></i> Tambah
                    Data</a>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-6">
                                    <h6 class="mt-1">
                                        <i class="fas fa-table me-1"></i>
                                        Tabel Lembur
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
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover shadow-sm" style="white-space: nowrap">
                                    <thead class="table-dark">
                                        <tr>
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
                                                Sampai Tanggal
                                                <span wire:click="sortBy('sampai_tanggal')"
                                                    style="cursor: pointer; font-size: 10px">
                                                    <i
                                                        class="fa fa-arrow-up {{$sortField === 'sampai_tanggal' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                                    <i
                                                        class="fa fa-arrow-down {{$sortField === 'sampai_tanggal' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
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
                                        @if ($cuti->count() == 0)
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada data.</td>
                                        </tr>
                                        @else

                                        @foreach ($cuti as $c)
                                        <tr class="">
                                            <td scope="row">
                                                {{$c->keperluan_cuti}}
                                            </td>
                                            <td>
                                                {{date('Y-m-d', strtotime($c->tanggal_cuti)) }}
                                            </td>
                                            <td>
                                                {{date('Y-m-d', strtotime($c->sampai_tanggal)) }}
                                            </td>

                                            <td>
                                                {{$c->durasi}}
                                            </td>
                                            <td>
                                                @if(Auth::user()->role_id == 2)
                                                @if($c->status == 0)
                                                <span class="badge rounded-pill text-bg-warning">proccess</span>
                                                @elseif($c->status == 1)
                                                <span class="badge rounded-pill text-bg-success">approved</span>
                                                @if($c->status_hrd == 0)
                                                <span class="badge rounded-pill text-bg-warning">proccess by HRD</span>
                                                @elseif($c->status_hrd == 1)
                                                <span class="badge rounded-pill text-bg-success">approved by HRD</span>
                                                @elseif($c->status_hrd == 2)
                                                <span class="badge rounded-pill text-bg-danger">rejected by HRD</span>
                                                @endif
                                                @elseif($c->status == 2)
                                                <span class="badge rounded-pill text-bg-danger">rejected</span>
                                                @endif
                                                @elseif(Auth::user()->role_id == 4)
                                                @if($c->status_hrd == 0)
                                                <span class="badge rounded-pill text-bg-warning">proccess</span>
                                                @elseif($c->status_hrd == 1)
                                                <span class="badge rounded-pill text-bg-success">success</span>
                                                @elseif($c->status_hrd == 2)
                                                <span class="badge rounded-pill text-bg-danger">failed</span>
                                                @endif
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" title="Lihat detail"
                                                    wire:click='lihatcuti({{$c->id}})'>
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" @if($c->status != 0)
                                                    disabled
                                                    @endif
                                                    wire:click='hapuscuti({{$c->id}})' data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" title="Hapus">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                                <button class="btn btn-sm btn-success" @if($c->status != 0)
                                                    disabled
                                                    @endif
                                                    wire:click='ubahcuti({{$c->id}})' data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" title="Ubah">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif


                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-8">
                                    <span>Halaman : {{ $cuti->currentPage() }} </span><br />
                                    <span>Jumlah Data : @if($search == '') {{$cuti->total()}} @else
                                        {{$cuti->count() }}
                                        @endif</span><br />
                                    <span>Data Per Halaman : {{ $cuti->perPage()}} </span><br /><br />
                                </div>
                                <div class="col-12 col-lg-4 d-flex justify-content-end">
                                    {{$cuti->links()}}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>