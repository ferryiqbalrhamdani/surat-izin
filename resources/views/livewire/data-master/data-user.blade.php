<div>
    @include('livewire.modal.data-master.user-modal')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Data User</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Data User</li>
        </ol>
        <div class="row">
            <div class="col-12 col-lg-3 col-md-6 mb-3">
                <button type="button" class="btn btn-lg btn-dark form-control" data-bs-toggle="modal"
                    data-bs-target="#staticBackdrop"><i class="fas fa-solid fa-plus"></i> Tambah
                    Data</button>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Table User
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
                                        <input type="text" class="form-control card-hover" placeholder="Nama User"
                                            wire:model.live='search'>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover shadow-sm" style="white-space: nowrap">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">
                                                Username
                                                <span wire:click="sortBy('username')"
                                                    style="cursor: pointer; font-size: 10px">
                                                    <i
                                                        class="fa fa-arrow-up {{$sortField === 'username' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                                    <i
                                                        class="fa fa-arrow-down {{$sortField === 'username' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                                </span>
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
                                                JK
                                                <span wire:click="sortBy('jk')"
                                                    style="cursor: pointer; font-size: 10px">
                                                    <i
                                                        class="fa fa-arrow-up {{$sortField === 'jk' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                                    <i
                                                        class="fa fa-arrow-down {{$sortField === 'jk' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                                </span>
                                            </th>
                                            <th scope="col">
                                                PT
                                                <span wire:click="sortBy('pt_id')"
                                                    style="cursor: pointer; font-size: 10px">
                                                    <i
                                                        class="fa fa-arrow-up {{$sortField === 'pt_id' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                                    <i
                                                        class="fa fa-arrow-down {{$sortField === 'pt_id' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                                </span>
                                            </th>
                                            <th scope="col">
                                                Divisi
                                                <span wire:click="sortBy('divisi_id')"
                                                    style="cursor: pointer; font-size: 10px">
                                                    <i
                                                        class="fa fa-arrow-up {{$sortField === 'divisi_id' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                                    <i
                                                        class="fa fa-arrow-down {{$sortField === 'divisi_id' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                                </span>
                                            </th>
                                            <th scope="col">
                                                Status Kerja
                                                <span wire:click="sortBy('employee_status')"
                                                    style="cursor: pointer; font-size: 10px">
                                                    <i
                                                        class="fa fa-arrow-up {{$sortField === 'employee_status' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                                    <i
                                                        class="fa fa-arrow-down {{$sortField === 'employee_status' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                                </span>
                                            </th>
                                            <th scope="col">
                                                Role
                                                <span wire:click="sortBy('role_id')"
                                                    style="cursor: pointer; font-size: 10px">
                                                    <i
                                                        class="fa fa-arrow-up {{$sortField === 'role_id' && $sortDirection === 'asc' ? '' : 'text-muted'}} "></i>
                                                    <i
                                                        class="fa fa-arrow-down {{$sortField === 'role_id' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
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
                                        @if ($user->count() == 0)
                                        <tr>
                                            <td colspan="8" class="text-center">Tidak ada data.</td>
                                        </tr>
                                        @else

                                        @foreach ($user as $u)
                                        <tr class="">
                                            <td scope="row"> {{$u->username}}
                                            </td>
                                            <td>
                                                {{$u->name}}
                                            </td>
                                            <td>
                                                {{$u->jk}}
                                            </td>
                                            <td>
                                                {{$u->pt->name}}
                                            </td>
                                            <td>
                                                {{$u->divisi->name}}
                                            </td>
                                            <td>
                                                <span class="badge text-bg-warning">{{$u->employee_status}}</span>
                                            </td>
                                            <td>
                                                <span class="badge text-bg-dark">{{$u->role->name}}</span>
                                            </td>
                                            <td class="text-center">
                                                @if ($u->status == 1)
                                                <span class="badge text-bg-success">aktif</span>

                                                @else
                                                <span class="badge text-bg-danger">tidak aktif</span>

                                                @endif

                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-secondary"
                                                    wire:click='resetUser({{$u->id}})' @if($u->role_id == 1) disabled
                                                    @endif>
                                                    <i class="fa-solid fa-arrow-rotate-left"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" wire:click='hapusUser({{$u->id}})'
                                                    @if($u->role_id == 1) disabled @endif>
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                                <button class="btn btn-sm btn-primary" wire:click='ubahUser({{$u->id}})'
                                                    @if($u->role_id == 1) disabled @endif>
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
                                    <span>Halaman : {{ $user->currentPage() }} </span><br />
                                    <span>Jumlah Data : @if($search == '') {{$user->total()}} @else
                                        {{$user->count() }}
                                        @endif</span><br />
                                    <span>Data Per Halaman : {{ $user->perPage()}} </span><br /><br />
                                </div>
                                <div class="col-12 col-lg-4 d-flex justify-content-end">
                                    {{$user->links()}}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>