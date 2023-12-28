<style>
    h6 {
        font-size: 14px;
    }
</style>

<div wire:ignore.self class="modal fade" id="hapus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Izin Lembur</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    wire:click='closeHapus'></button>
            </div>
            <div class="modal-body text-center">
                <h6>Apakah anda yakin akan menghapus?</h6>
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

<div wire:ignore.self class="modal fade" id="view" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Detail Izin Lembur</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    wire:click='closeView'></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-5 col-lg-4">
                        <h6>Tanggal Lembur</h6>
                    </div>
                    <div class="col-7 col-lg-8">
                        <h6>: {{ $tanggal_lembur }}</h6>
                    </div>
                    <div class="col-5 col-lg-4">
                        <h6>Hari Libur</h6>
                    </div>
                    <div class="col-7 col-lg-8">
                        <h6>: {{ $hari_libur }}</h6>
                    </div>
                    <div class="col-5 col-lg-4">
                        <h6>Jam Mulai</h6>
                    </div>
                    <div class="col-7 col-lg-8">
                        <h6>: @if($jam_mulai != null)
                            {{date('H:i', strtotime($jam_mulai)) }}
                            @else
                            -
                            @endif
                        </h6>
                    </div>
                    <div class="col-5 col-lg-4">
                        <h6>Jam Akhir</h6>
                    </div>
                    <div class="col-7 col-lg-8">
                        <h6>: @if($jam_selesai != null)
                            {{date('H:i', strtotime($jam_selesai)) }}
                            @else
                            -
                            @endif
                        </h6>
                    </div>
                    <div class="col-5 col-lg-4">
                        <h6>Lama Lembur</h6>
                    </div>
                    <div class="col-7 col-lg-8">
                        <h6>: @if($lama_lembur != null)
                            {{date('G', strtotime($lama_lembur)) }} jam
                            @else
                            -
                            @endif
                        </h6>
                    </div>
                    <div class="col-5 col-lg-4">
                        <h6>Status</h6>
                    </div>
                    <div class="col-7 col-lg-8">
                        <h6>
                            :
                            @if ($status == 0)
                            <span class="badge rounded-pill text-bg-warning">proccess</span>
                            @elseif($status == 1)
                            <span class="badge rounded-pill text-bg-success">approved</span>
                            @if ($status_hrd == 0)
                            <span class="badge rounded-pill text-bg-warning">proccess by HRD</span>
                            @elseif($status_hrd == 1)
                            <span class="badge rounded-pill text-bg-success">approved by HRD</span>
                            @elseif($status_hrd == 2)
                            <span class="badge rounded-pill text-bg-danger">rejected by HRD</span>
                            @endif
                            @elseif($status == 2)
                            <span class="badge rounded-pill text-bg-danger">rejected</span>
                            @endif

                        </h6>
                    </div>
                    <div class="col-5 col-lg-4">
                        <h6>Keterangan</h6>
                    </div>
                    <div class="col-7 col-lg-8">
                        <h6>: {{ $keterangan }}
                        </h6>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-felx justify-content-center">
                <button type="button" class="btn btn-secondary form-control" data-bs-dismiss="modal"
                    wire:click='closeView'>Kembali</button>
            </div>
        </div>
    </div>
</div>

<div wire:ignore.self class="modal fade" id="ubah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Ubah Izin Lembur</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    wire:click='closeEdit'></button>
            </div>
            <form wire:submit.prevent='edit'>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-lg-6 col-md-6 col-sm-12 mb-3">
                            <label for="tanggal_lembur" class="form-label">Tanggal Lembur<span
                                    class="text-danger"><sup>*</sup></span></label>
                            <input type="date" id="tanggal_lembur"
                                class="form-control @error('tanggal_lembur') is-invalid @enderror"
                                wire:model.live='tanggal_lembur'>
                            @error('tanggal_lembur')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-12 col-lg-6 col-md-6 col-sm-12 mb-3">
                            <label for="hari_libur" class="form-label">Hari Libur<span
                                    class="text-danger"><sup>*</sup></span></label>
                            <div class="row">
                                <div class="col-12 col-lg-6 col-sm-6">
                                    <div class="form-check">
                                        <input class="form-check-input" name="flexRadioDefault"
                                            wire:model.live='hari_libur' type="radio" value="Iya" id="iya">
                                        <label class="form-check-label" for="iya">
                                            Iya
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-sm-6">
                                    <div class="form-check">
                                        <input class="form-check-input" name="flexRadioDefault"
                                            wire:model.live='hari_libur' type="radio" value="Tidak" id="tidak">
                                        <label class="form-check-label" for="tidak">
                                            Tidak
                                        </label>
                                    </div>
                                </div>
                            </div>


                            @error('hari_libur')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-12 col-lg-6 col-md-6 mb-3">
                            <label for="jam_mulai" class="form-label">Jam Mulai<span
                                    class="text-danger"><sup>*</sup></span></label>
                            <input type="time" id="jam_mulai"
                                class="form-control @error('jam_mulai') is-invalid @enderror"
                                wire:model.live='jam_mulai'>
                            @error('jam_mulai')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-12 col-lg-6 col-md-6 mb-3">
                            <label for="jam_selesai" class="form-label">Jam Selesai<span
                                    class="text-danger"><sup>*</sup></span></label>
                            <input type="time" id="jam_selesai"
                                class="form-control @error('jam_selesai') is-invalid @enderror"
                                wire:model.live='jam_selesai'>
                            @error('jam_selesai')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan
                                    <span class="text-danger"><sup>*</sup></span>
                                </label>
                                <textarea class="form-control @error('keterangan') is-invalid @enderror"
                                    wire:model.blur='keterangan' id="keterangan" rows="4"></textarea>
                                @error('keterangan')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
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

@push('izin-lembur')
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
    window.addEventListener('show-view-modal', event =>{
        $('#view').modal('show');
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