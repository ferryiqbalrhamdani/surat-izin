<!-- Modal -->
<div wire:ignore.self class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Role</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:submit.prevent='addRole'>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Role</label>
                        <input type="text" wire:model.blur='name' id="name"
                            class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <span class="text-danger">
                            {{$message}}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer d-felx justify-content-center">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Keluar</button>
                    <button type="submit" class="btn btn-dark">Simpan</button>
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
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Role</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    wire:click='closeHapus'></button>
            </div>
            <div class="modal-body text-center">
                <h6>Apakah anda yakin akan menghapus role <b>{{$name}}</b>?</h6>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Ubah Role</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    wire:click='closeHapus'></button>
            </div>
            <form wire:submit.prevent='update'>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name_edit" class="form-label">Nama Role</label>
                        <input type="text" wire:model.blur='name' id="name_edit"
                            class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <span class="text-danger">
                            {{$message}}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer d-felx justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        wire:click='closeHapus'>Batal</button>
                    <button type="submit" class="btn btn-primary">Ya! Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('role')
<script>
    window.addEventListener('show-delete-modal', event =>{
        $('#hapus').modal('show');
    });
    window.addEventListener('close-delete-modal', event =>{
        $('#hapus').modal('hide');
    });
    window.addEventListener('show-edit-modal', event =>{
        $('#ubah').modal('show');
    });
    window.addEventListener('close-edit-modal', event =>{
        $('#ubah').modal('hide');
    });

    document.addEventListener('livewire:initialized', () =>{
        @this.on('swal',(event) => {
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
</script>
@endpush