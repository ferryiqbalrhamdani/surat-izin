<div>
    @include('livewire.modal.data-input.izin-lembur-modal')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Izin Lembur</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Izin Lembur</li>
        </ol>
        <div class="row">
            <div class="col-12 col-lg-3 col-md-6 mb-3">
                <a href="/izin-lembur/tambah-data" class="btn btn-lg btn-dark form-control"><i
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
                                                Tanggal Lembur
                                                <span wire:click="sortBy('tanggal_lembur')"
                                                    style="cursor: pointer; font-size: 10px">
                                                    <i
                                                        class="fa fa-arrow-up {{$sortField === 'tanggal_lembur' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                                    <i
                                                        class="fa fa-arrow-down {{$sortField === 'tanggal_lembur' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                                </span>
                                            </th>
                                            <th scope="col">
                                                Jam Mulai
                                                <span wire:click="sortBy('jam_mulai')"
                                                    style="cursor: pointer; font-size: 10px">
                                                    <i
                                                        class="fa fa-arrow-up {{$sortField === 'jam_mulai' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                                    <i
                                                        class="fa fa-arrow-down {{$sortField === 'jam_mulai' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                                </span>
                                            </th>
                                            <th scope="col">
                                                Jam Selesai
                                                <span wire:click="sortBy('jam_akhir')"
                                                    style="cursor: pointer; font-size: 10px">
                                                    <i
                                                        class="fa fa-arrow-up {{$sortField === 'jam_akhir' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                                    <i
                                                        class="fa fa-arrow-down {{$sortField === 'jam_akhir' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                                </span>
                                            </th>
                                            <th scope="col">
                                                Lama Lembur
                                                <span wire:click="sortBy('lama_lembur')"
                                                    style="cursor: pointer; font-size: 10px">
                                                    <i
                                                        class="fa fa-arrow-up {{$sortField === 'lama_lembur' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                                    <i
                                                        class="fa fa-arrow-down {{$sortField === 'lama_lembur' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
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
                                        @if ($lembur->count() == 0)
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada data.</td>
                                        </tr>
                                        @else

                                        @foreach ($lembur as $l)
                                        <tr class="">
                                            <td scope="row">
                                                {{date('Y-m-d', strtotime($l->tanggal_lembur)) }}
                                            </td>
                                            <td>
                                                @if($l->jam_mulai != null)
                                                {{date('H:i', strtotime($l->jam_mulai)) }}
                                                @else
                                                -
                                                @endif
                                            </td>
                                            <td>
                                                @if($l->jam_akhir != null)
                                                {{date('H:i', strtotime($l->jam_akhir)) }}
                                                @else
                                                -
                                                @endif
                                            </td>
                                            <td>
                                                @if($l->lama_lembur != null)
                                                {{date('G', strtotime($l->lama_lembur)) }} jam
                                                @else
                                                -
                                                @endif
                                            </td>
                                            <td>
                                                @if(Auth::user()->role_id == 2)
                                                @if($l->status == 0)
                                                <span class="badge rounded-pill text-bg-warning">proccess</span>
                                                @elseif($l->status == 1)
                                                <span class="badge rounded-pill text-bg-success">approved</span>
                                                @if($l->status_hrd == 0)
                                                <span class="badge rounded-pill text-bg-warning">proccess by HRD</span>
                                                @elseif($l->status_hrd == 1)
                                                <span class="badge rounded-pill text-bg-success">approved by HRD</span>
                                                @elseif($l->status_hrd == 2)
                                                <span class="badge rounded-pill text-bg-danger">rejected by HRD</span>
                                                @endif
                                                @elseif($l->status == 2)
                                                <span class="badge rounded-pill text-bg-danger">rejected</span>
                                                @endif
                                                @elseif(Auth::user()->role_id == 3)
                                                @if($l->status_hrd == 0)
                                                <span class="badge rounded-pill text-bg-warning">proccess</span>
                                                @elseif($l->status_hrd == 1)
                                                <span class="badge rounded-pill text-bg-success">success</span>
                                                @elseif($l->status_hrd == 2)
                                                <span class="badge rounded-pill text-bg-danger">failed</span>
                                                @endif
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" title="Lihat detail"
                                                    wire:click='lihatLembur({{$l->id}})'>
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" @if($l->status != 0)
                                                    disabled
                                                    @endif
                                                    wire:click='hapusLembur({{$l->id}})' data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" title="Hapus">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                                <button class="btn btn-sm btn-success" @if($l->status != 0)
                                                    disabled
                                                    @endif
                                                    wire:click='ubahLembur({{$l->id}})' data-bs-toggle="tooltip"
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
                                    <span>Halaman : {{ $lembur->currentPage() }} </span><br />
                                    <span>Jumlah Data : @if($search == '') {{$lembur->total()}} @else
                                        {{$lembur->count() }}
                                        @endif</span><br />
                                    <span>Data Per Halaman : {{ $lembur->perPage()}} </span><br /><br />
                                </div>
                                <div class="col-12 col-lg-4 d-flex justify-content-end">
                                    {{$lembur->links()}}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>