<div>
    @include('livewire.modal.data-input.surat-izin-modal')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Surat Izin</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Surat Izin</li>
        </ol>
        <div class="row">
            <div class="col-12 col-lg-3 col-md-6 mb-3">
                <a href="/surat-izin/tambah-data" class="btn btn-lg btn-dark form-control"><i
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
                                        Tabel Surat Izin
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
                                                Keperluan Izin
                                                <span wire:click="sortBy('keperluan_izin')"
                                                    style="cursor: pointer; font-size: 10px">
                                                    <i
                                                        class="fa fa-arrow-up {{$sortField === 'keperluan_izin' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                                    <i
                                                        class="fa fa-arrow-down {{$sortField === 'keperluan_izin' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                                </span>
                                            </th>
                                            <th scope="col">
                                                Tanggal Izin
                                                <span wire:click="sortBy('tanggal_izin')"
                                                    style="cursor: pointer; font-size: 10px">
                                                    <i
                                                        class="fa fa-arrow-up {{$sortField === 'tanggal_izin' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                                    <i
                                                        class="fa fa-arrow-down {{$sortField === 'tanggal_izin' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                                </span>
                                            </th>
                                            <th scope="col">
                                                Lama Izin
                                                <span wire:click="sortBy('durasi_izin')"
                                                    style="cursor: pointer; font-size: 10px">
                                                    <i
                                                        class="fa fa-arrow-up {{$sortField === 'durasi_izin' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                                    <i
                                                        class="fa fa-arrow-down {{$sortField === 'durasi_izin' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                                </span>
                                            </th>
                                            <th scope="col">
                                                Jam Mulai
                                                <span wire:click="sortBy('jam_masuk')"
                                                    style="cursor: pointer; font-size: 10px">
                                                    <i
                                                        class="fa fa-arrow-up {{$sortField === 'jam_masuk' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                                    <i
                                                        class="fa fa-arrow-down {{$sortField === 'jam_masuk' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                                </span>
                                            </th>
                                            <th scope="col">
                                                Jam Akhir
                                                <span wire:click="sortBy('jam_keluar')"
                                                    style="cursor: pointer; font-size: 10px">
                                                    <i
                                                        class="fa fa-arrow-up {{$sortField === 'jam_keluar' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                                    <i
                                                        class="fa fa-arrow-down {{$sortField === 'jam_keluar' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
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
                                        @if ($suratIzin->count() == 0)
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada data.</td>
                                        </tr>
                                        @else

                                        @foreach ($suratIzin as $si)
                                        <tr class="">
                                            <td scope="row">
                                                {{$si->keperluan_izin }}
                                            </td>
                                            <td>
                                                {{date('Y-m-d', strtotime($si->tanggal_izin)) }}
                                            </td>
                                            <td>
                                                {{$si->durasi_izin}} hari
                                            </td>
                                            <td>
                                                @if($si->jam_masuk != null)
                                                {{date('H:i', strtotime($si->jam_masuk)) }}
                                                @else
                                                -
                                                @endif
                                            </td>
                                            <td>
                                                @if($si->jam_keluar != null)
                                                {{date('H:i', strtotime($si->jam_keluar)) }}
                                                @else
                                                -
                                                @endif
                                            </td>
                                            <td>
                                                @if(Auth::user()->role_id == 2)
                                                @if($si->status == 0)
                                                <span class="badge rounded-pill text-bg-warning">proccess</span>
                                                @elseif($si->status == 1)
                                                <span class="badge rounded-pill text-bg-success">approved</span>
                                                @if($si->status_hrd == 0)
                                                <span class="badge rounded-pill text-bg-warning">proccess by HRD</span>
                                                @elseif($si->status_hrd == 1)
                                                <span class="badge rounded-pill text-bg-success">approved by HRD</span>
                                                @elseif($si->status_hrd == 2)
                                                <span class="badge rounded-pill text-bg-danger">rejected by HRD</span>
                                                @endif
                                                @elseif($si->status == 2)
                                                <span class="badge rounded-pill text-bg-danger">rejected</span>
                                                @endif
                                                @elseif(Auth::user()->role_id == 3)
                                                @if($si->status_hrd == 0)
                                                <span class="badge rounded-pill text-bg-warning">proccess</span>
                                                @elseif($si->status_hrd == 1)
                                                <span class="badge rounded-pill text-bg-success">success</span>
                                                @elseif($si->status_hrd == 2)
                                                <span class="badge rounded-pill text-bg-danger">failed</span>
                                                @endif
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-primary"
                                                    wire:click='lihatSuratIzin({{$si->id}})'>
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" @if($si->status != 0)
                                                    disabled
                                                    @endif
                                                    wire:click='hapusSuratIzin({{$si->id}})'>
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                                <button class="btn btn-sm btn-success" @if($si->status != 0)
                                                    disabled
                                                    @endif
                                                    wire:click='ubahSuratIzin({{$si->id}})'>
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
                                    <span>Halaman : {{ $suratIzin->currentPage() }} </span><br />
                                    <span>Jumlah Data : @if($search == '') {{$suratIzin->total()}} @else
                                        {{$suratIzin->count() }}
                                        @endif</span><br />
                                    <span>Data Per Halaman : {{ $suratIzin->perPage()}} </span><br /><br />
                                </div>
                                <div class="col-12 col-lg-4 d-flex justify-content-end">
                                    {{$suratIzin->links()}}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>