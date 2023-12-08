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
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Izin Cuti</h1>
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
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Detail Izin Cuti</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    wire:click='closeView'></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-5 col-lg-4">
                        <h6>Keperluan Cuti</h6>
                    </div>
                    <div class="col-7 col-lg-8">
                        <h6>: {{ $keperluan_cuti }}</h6>
                    </div>
                    @if($keperluan_cuti == 'Cuti Khusus')
                    <div class="col-5 col-lg-4">
                        <h6>Pilihan</h6>
                    </div>
                    <div class="col-7 col-lg-8">
                        <h6>: @if($pilihan != NULL) {{ $pilihan }} @else - @endif</h6>
                    </div>
                    @endif
                    <div class="col-5 col-lg-4">
                        <h6>Tanggal Cuti</h6>
                    </div>
                    <div class="col-7 col-lg-8">
                        <h6>: {{ $tanggal_cuti }}@if($lama_cuti != 'Sehari') s/d {{$sampai_tanggal}} @endif
                        </h6>
                    </div>
                    <div class="col-5 col-lg-4">
                        <h6>Lama Cuti</h6>
                    </div>
                    <div class="col-7 col-lg-8">
                        <h6>: {{$durasi}}
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
                        <h6>: {{ $keterangan_cuti }}
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
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Ubah Izin Cuti {{ $lama_cuti }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    wire:click='closeEdit'></button>
            </div>
            <form wire:submit.prevent='edit'>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-lg-6 col-md-6 col-sm-6">
                            <div class="mb-3">
                                <label for="keperluan_cuti" class="form-label">Keperluan Cuti
                                    <span class="text-danger"><sup>*</sup></span>
                                </label>
                                <select wire:click='resetData'
                                    class="form-select @error('keperluan_cuti') is-invalid @enderror"
                                    id="keperluan_cuti" wire:model.live='keperluan_cuti'
                                    aria-label="Default select example">
                                    <option></option>
                                    <option value="Cuti Pribadi">Cuti Pribadi</option>
                                    <option value="Cuti Khusus">Cuti Khusus</option>
                                </select>
                                @error('keperluan_cuti')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 col-md-6 mb-3">
                            <div class="mb-3">
                                <label for="tanggal_izin" class="form-label">Lama Cuti
                                    <span class="text-danger"><sup>*</sup></span>
                                </label>
                                <div class="row">
                                    <div class="col-4 col-lg-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="lama_cuti"
                                                wire:model.live='lama_cuti' id="sehari" value="Sehari">
                                            <label class="form-check-label" for="sehari">
                                                @if($pilihan != 'Cuti Melahirkan') Sehari @else 3 Bulan @endif
                                            </label>
                                        </div>
                                    </div>
                                    @if($pilihan != 'Cuti Melahirkan')
                                    <div class="col-8 col-lg-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="lama_cuti"
                                                wire:model.live='lama_cuti' id="lebiDariSehari"
                                                value="Lebih dari sehari">
                                            <label class="form-check-label" for="lebiDariSehari">
                                                Lebih dari sehari
                                            </label>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                @error('lama_izin')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        @if($keperluan_cuti == 'Cuti Khusus')
                        <div class="col-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="mb-3">
                                <label for="pilihan" class="form-label">Pilihan
                                    <span class="text-danger"><sup>*</sup></span>
                                </label>
                                <select class="form-select @error('pilihan') is-invalid @enderror" id="pilihan"
                                    wire:model.live='pilihan' aria-label="Default select example">
                                    <option></option>
                                    <option value="Bencana Alam">Bencana Alam</option>
                                    <option value="Menikah">Menikah</option>
                                    <option value="Keluarga Inti">Keluarga Inti</option>
                                    {{-- @if(Auth::user()->jk == 'L') --}}
                                    <option value="Istri Melahirkan">Istri Melahirkan</option>
                                    {{-- @elseif(Auth::user()->jk == 'P') --}}
                                    <option value="Cuti Melahirkan">Cuti Melahirkan</option>
                                    {{-- @endif --}}
                                </select>
                                @error('pilihan')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        @endif
                        <div
                            class="col-12 @if($lama_cuti == 'Lebih dari sehari') col-lg-6 @else col-lg-12 @endif col-md-6 mb-3">
                            <label for="tanggal_cuti" class="form-label">Tanggal Cuti<span
                                    class="text-danger"><sup>*</sup></span></label>
                            <input type="date" id="tanggal_cuti"
                                class="form-control @error('tanggal_cuti') is-invalid @enderror"
                                wire:model.live='tanggal_cuti'>
                            @error('tanggal_cuti')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        @if($lama_cuti == 'Lebih dari sehari')
                        <div class="col-12 col-lg-6 col-md-6 mb-3">
                            <label for="sampai_tanggal" class="form-label">Sampai Tanggal<span
                                    class="text-danger"><sup>*</sup></span></label>
                            <input type="date" id="sampai_tanggal"
                                class="form-control @error('sampai_tanggal') is-invalid @enderror"
                                wire:model.live='sampai_tanggal'>
                            @error('sampai_tanggal')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        @endif
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="keterangan_cuti" class="form-label">Keterangan
                                    <span class="text-danger"><sup>*</sup></span>
                                </label>
                                <textarea class="form-control @error('keterangan_cuti') is-invalid @enderror"
                                    wire:model.blur='keterangan_cuti' id="keterangan_cuti" rows="4"></textarea>
                                @error('keterangan_cuti')
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

@push('izin-cuti')
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