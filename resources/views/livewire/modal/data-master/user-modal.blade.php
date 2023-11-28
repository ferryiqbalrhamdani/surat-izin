<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->

<div wire:ignore.self class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" style="color: black">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent='addUser'>
                    <div class="container">

                        <div class="form-outline mb-4">
                            <label class="form-label" for="username">Username<span class="text-danger">*</span></label>
                            <input type="text" id="username"
                                class="form-control form-control card-hover card-shadow @error('username') is-invalid @enderror"
                                wire:model.live='username'>
                            <div>@error('username') <span class="text-danger"> {{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="form-outline">
                            <label class="form-label" for="password">Password<span class="text-danger">*</span></label>
                            <input @if($showpassword==false) type="password" @else type="text" @endif id="password"
                                wire:model.live='password'
                                class="form-control form-control card-hover card-shadow @error('password') is-invalid @enderror" />
                        </div>

                        <!-- Checkbox -->
                        <div class="form-check d-flex justify-content-start ">
                            <input class="form-check-input" type="checkbox" value="" id="form1Example3"
                                wire:click='openPas()' /><span style="margin-right: 10px"></span>
                            <label class="form-check-label" for="form1Example3"> Tampilkan password </label>
                        </div>

                        <div class="mb-4">@error('password') <span class="text-danger"> {{ $message }}</span> @enderror
                        </div>

                        <div class="form-outline mb-4">
                            <label class="form-label" for="name">Nama<span class="text-danger">*</span></label>
                            <input type="text" id="name"
                                class="form-control form-control card-hover card-shadow @error('name') is-invalid @enderror"
                                wire:model.live='name'>
                            <div>@error('name') <span class="text-danger"> {{ $message }}</span> @enderror</div>
                        </div>
                        <div class="form-outline mb-4">
                            <label for="" class="form-label">Jenis Kelamin<span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-check ">
                                        <input class="form-check-input " type="radio" value="L" name="jk"
                                            wire:model.live='jk' id="jk1" checked>
                                        <label class="form-check-label " for="jk1">
                                            Laki-laki
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="P" name="jk"
                                            wire:model.live='jk' id="jk2">
                                        <label class="form-check-label" for="jk2">
                                            Perempuan
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div>@error('jk') <span class="text-danger"> {{ $message }}</span> @enderror</div>
                        </div>
                        <div class="form-outline mb-4">
                            <label for="pt_id">PT<span class="text-danger">*</span></label>
                            <select class="form-select card-hover @error('pt_id') is-invalid @enderror" id="pt_id"
                                wire:model.live='pt_id'>
                                <option></option>
                                @foreach ($pt as $p)
                                <option value="{{$p->id}}">{{$p->name}}</option>
                                @endforeach
                            </select>
                            <div>
                                @error('pt_id') <span class="text-danger"> {{ $message }}</span> @enderror
                            </div>

                        </div>
                        <div class="form-outline mb-4">
                            <label for="divisi_id">Divisi<span class="text-danger">*</span></label>
                            <select class="form-select card-hover @error('divisi_id') is-invalid @enderror"
                                id="divisi_id" wire:model.live='divisi_id'>
                                <option></option>
                                @foreach ($divisi as $d)
                                <option value="{{$d->id}}">{{$d->name}}</option>
                                @endforeach
                            </select>
                            <div>
                                @error('divisi_id') <span class="text-danger"> {{ $message }}</span> @enderror
                            </div>

                        </div>
                        <div class="form-outline mb-4">
                            <label for="role_id">Role User<span class="text-danger">*</span></label>
                            <select class="form-select card-hover @error('role_id') is-invalid @enderror" id="role"
                                wire:model.live='role_id'>
                                <option></option>
                                @foreach ($role as $r)
                                <option value="{{$r->id}}">{{$r->name}}</option>
                                @endforeach
                            </select>
                            <div>
                                @error('role_id') <span class="text-danger"> {{ $message }}</span> @enderror
                            </div>

                        </div>

                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-dark form-control"><i class="fas fa-save"></i> Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div wire:ignore.self class="modal fade" id="hapus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    wire:click='closeHapus'></button>
            </div>
            <div class="modal-body text-center">
                <h6>Apakah anda yakin akan menghapus <b>{{$name}}</b>?</h6>
            </div>
            <div class="modal-footer d-felx justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    wire:click='closeHapus'>Batal</button>
                <form wire:submit.prevent='destroy'>
                    <button type="submit" class="btn btn-danger">Ya! Hapus.</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div wire:ignore.self class="modal fade" id="ubah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" style="color: black">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Ubah User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click='closeUbah'
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent='edit'>
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="username">Username<span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="username"
                                        class="form-control form-control card-hover card-shadow @error('username') is-invalid @enderror"
                                        wire:model.live='username'>
                                    <div>@error('username') <span class="text-danger"> {{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="name">Nama<span class="text-danger">*</span></label>
                                    <input type="text" id="name"
                                        class="form-control form-control card-hover card-shadow @error('name') is-invalid @enderror"
                                        wire:model.live='name'>
                                    <div>@error('name') <span class="text-danger"> {{ $message }}</span> @enderror</div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-outline mb-4">
                                    <label for="" class="form-label">Jenis Kelamin<span
                                            class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-check ">
                                                <input class="form-check-input " type="radio" value="L" name="jk"
                                                    wire:model.live='jk' id="jk1" checked>
                                                <label class="form-check-label " for="jk1">
                                                    Laki-laki
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" value="P" name="jk"
                                                    wire:model.live='jk' id="jk2">
                                                <label class="form-check-label" for="jk2">
                                                    Perempuan
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div>@error('jk') <span class="text-danger"> {{ $message }}</span> @enderror</div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-outline mb-4">
                                    <label for="pt_id">PT<span class="text-danger">*</span></label>
                                    <select class="form-select card-hover @error('pt_id') is-invalid @enderror"
                                        id="pt_id" wire:model.live='pt_id'>
                                        <option></option>
                                        @foreach ($pt as $p)
                                        <option value="{{$p->id}}">{{$p->name}}</option>
                                        @endforeach
                                    </select>
                                    <div>
                                        @error('pt_id') <span class="text-danger"> {{ $message }}</span> @enderror
                                    </div>

                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-outline mb-4">
                                    <label for="divisi_id">Divisi<span class="text-danger">*</span></label>
                                    <select class="form-select card-hover @error('divisi_id') is-invalid @enderror"
                                        id="divisi_id" wire:model.live='divisi_id'>
                                        <option></option>
                                        @foreach ($divisi as $d)
                                        <option value="{{$d->id}}">{{$d->name}}</option>
                                        @endforeach
                                    </select>
                                    <div>
                                        @error('divisi_id') <span class="text-danger"> {{ $message }}</span> @enderror
                                    </div>

                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-outline mb-4">
                                    <label for="role_id">Role User<span class="text-danger">*</span></label>
                                    <select class="form-select card-hover @error('role_id') is-invalid @enderror"
                                        id="role" wire:model.live='role_id'>
                                        <option></option>
                                        @foreach ($role as $r)
                                        <option value="{{$r->id}}">{{$r->name}}</option>
                                        @endforeach
                                    </select>
                                    <div>
                                        @error('role_id') <span class="text-danger"> {{ $message }}</span> @enderror
                                    </div>

                                </div>
                            </div>
                            <div class="col-12 col-lg-12">
                                <div class="form-outline mb-4">
                                    <label for="status">Status Akun<span class="text-danger">*</span></label>
                                    <select class="form-select card-hover @error('status') is-invalid @enderror"
                                        id="role" wire:model.live='status'>
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
                                    <div>
                                        @error('status') <span class="text-danger"> {{ $message }}</span> @enderror
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-dark form-control"><i class="fas fa-save"></i> Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div wire:ignore.self class="modal fade" id="reset" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Reset User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    wire:click='closeHapus'></button>
            </div>
            <div class="modal-body text-center">
                <h6>Apakah anda yakin akan mereset password <b>{{$name}}</b>?</h6>
            </div>
            <div class="modal-footer d-felx justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    wire:click='closeHapus'>Batal</button>
                <form wire:submit.prevent='resetAction'>
                    <button type="submit" class="btn btn-danger">Ya! Reset.</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('users')
<script>
    //------------------------- delete --------------------
    window.addEventListener('show-delete-modal', event =>{
        $('#hapus').modal('show');
    });
    window.addEventListener('close-delete-modal', event =>{
        $('#hapus').modal('hide');
    });

    document.addEventListener('livewire:initialized', () =>{
        @this.on('delete',(event) => {
            const data=event
            swal.fire({
                toast: true,
                position: "top-end",
                icon:data[0]['icon'],
                title:data[0]['title'],
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            })
            })
    });

    // --------------- ubah -----------------------
    window.addEventListener('show-update-modal', event =>{
        $('#ubah').modal('show');
    });
    window.addEventListener('close-update-modal', event =>{
        $('#ubah').modal('hide');
    });
    document.addEventListener('livewire:initialized', () =>{
        @this.on('update',(event) => {
            const data=event
            swal.fire({
                toast: true,
                position: "top-end",
                icon:data[0]['icon'],
                title:data[0]['title'],
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            })
            })
    });

    // -------------------- reset ----------------------
    window.addEventListener('show-reset-modal', event =>{
        $('#reset').modal('show');
    });
    window.addEventListener('close-reset-modal', event =>{
        $('#reset').modal('hide');
    });
    document.addEventListener('livewire:initialized', () =>{
        @this.on('reset',(event) => {
            const data=event
            swal.fire({
                toast: true,
                position: "top-end",
                icon:data[0]['icon'],
                title:data[0]['title'],
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            })
            })
    });
</script>
@endpush