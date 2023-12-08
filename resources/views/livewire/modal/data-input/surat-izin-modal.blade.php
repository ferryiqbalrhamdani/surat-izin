<style>
    h6 {
        font-size: 14px;
    }

    .view {
        cursor: pointer;
    }

    .view:hover {
        background-color: #1560d1 !important;
    }
</style>

<div wire:ignore.self class="modal fade" id="hapus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Surat Izin</h1>
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
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Detail Surat Izin</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    wire:click='closeView'></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4 col-lg-3">
                        <h6>Keperluan</h6>
                    </div>
                    <div class="col-8 col-lg-9">
                        <h6>: {{ $keperluan_izin }}</h6>
                    </div>

                    <div class="col-4 col-lg-3">
                        <h6>Tanggal Izin</h6>
                    </div>
                    <div class="col-8 col-lg-9">
                        <h6>: {{ $tanggal_izin }}@if($lama_izin != 'Sehari') s/d {{$sampai_tanggal}} @endif
                        </h6>
                    </div>
                    <div class="col-4 col-lg-3">
                        <h6>Lama Izin</h6>
                    </div>
                    <div class="col-8 col-lg-9">
                        <h6>: @if($jam_masuk != NULL && $jam_keluar != NULL)
                            @if($jam > 0 && $menit > 0)
                            {{$jam}} jam {{$menit}} menit
                            @elseif($jam > 0 && $menit <= 0) {{$jam}} jam @elseif($jam <=0 && $menit>0)
                                {{$menit}} menit
                                @else
                                {{ $lama_izin }}
                                @endif
                                @else
                                {{ $lama_izin }}
                                @endif
                                @if($lama_izin != 'Sehari')
                                <span class="badge text-bg-primary">
                                    {{$durasi_izin}}
                                </span>
                                @endif
                        </h6>
                    </div>
                    <div class="col-4 col-lg-3">
                        <h6>Jam Mulai</h6>
                    </div>
                    <div class="col-8 col-lg-9">
                        <h6>: {{ $jam_masuk }}
                        </h6>
                    </div>
                    <div class="col-4 col-lg-3">
                        <h6>Jam Akhir</h6>
                    </div>
                    <div class="col-8 col-lg-9">
                        <h6>: {{ $jam_keluar }}
                        </h6>
                    </div>

                    <div class="col-4 col-lg-3">
                        <h6>Status</h6>
                    </div>
                    <div class="col-8 col-lg-9">
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
                    <div class="col-4 col-lg-3">
                        <h6>Keterangan</h6>
                    </div>
                    <div class="col-8 col-lg-9">
                        <h6>: {{ $keterangan }}
                        </h6>
                    </div>
                    @if($keperluan_izin == 'Izin Tidak Masuk Kerja')
                    <div class="col-4 col-lg-3">
                        <h6>Bukti Foto</h6>
                    </div>
                    <div class="col-8 col-lg-9">
                        @if($oldPhoto != NULL)
                        @if($oldPhoto)
                        <h6>: <span class="badge rounded-pill text-bg-primary view" wire:click='lihatPhoto'>lihat
                                foto</span>
                        </h6>
                        @endif
                        @else
                        <h6>
                            : -
                        </h6>
                        {{-- <h6 style="cursor: pointer">
                            <img src="{{ Storage::url($photo)}}" style="max-width: 300px;">
                        </h6> --}}
                        @endif
                    </div>
                    @endif
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
            <form wire:submit.prevent='edit'>
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Ubah Surat Izin</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click='closeEdit'></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label for="keperluan_izin" class="form-label">Keperluan Izin
                                    <span class="text-danger"><sup>*</sup></span>
                                </label>
                                <select wire:click='resetData'
                                    class="form-select @error('keperluan_izin') is-invalid @enderror"
                                    id="keperluan_izin" wire:model.live='keperluan_izin'
                                    aria-label="Default select example">
                                    <option></option>
                                    <option value="Izin Datang Terlambat">Izin Datang Terlambat</option>
                                    <option value="Izin Tidak Masuk Kerja">Izin Tidak Masuk Kerja</option>
                                    <option value="Izin Meninggalkan Kantor">Izin Meninggalkan Kantor</option>
                                    <option value="Tugas Meninggalkan Kantor">Tugas Meninggalkan Kantor</option>
                                </select>
                                @error('keperluan_izin')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        @if($keperluan_izin == 'Tugas Meninggalkan Kantor' ||
                        $keperluan_izin == 'Izin Tidak Masuk Kerja')
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label for="tanggal_izin" class="form-label">Lama Izin
                                    <span class="text-danger"><sup>*</sup></span>
                                </label>
                                <div class="row">
                                    <div class="col-4 col-lg-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="lama_izin"
                                                wire:model.live='lama_izin' id="sehari" value="Sehari" checked>
                                            <label class="form-check-label" for="sehari">
                                                Sehari
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-8 col-lg-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="lama_izin"
                                                wire:model.live='lama_izin' id="lebiDariSehari"
                                                value="Lebih dari sehari">
                                            <label class="form-check-label" for="lebiDariSehari">
                                                Lebih dari sehari
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @error('lama_izin')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        @endif


                        <div
                            class="col-12 @if($keperluan_izin == 'Tugas Meninggalkan Kantor' || $keperluan_izin == 'Izin Tidak Masuk Kerja')  @if($lama_izin == 'Sehari') col-lg-12 @elseif($lama_izin == 'Lebih dari sehari') col-lg-6 @endif @else col-lg-6 @endif">
                            <div class="mb-3">
                                <label for="tanggal_izin" class="form-label">Tanggal Izin
                                    <span class="text-danger"><sup>*</sup></span>
                                </label>
                                <input class="form-control @error('tanggal_izin') is-invalid @enderror" type="date"
                                    wire:model.live='tanggal_izin' id="tanggal_izin" class="form-control">
                                @error('tanggal_izin')
                                <span class="text-danger">{{$message}}</span>
                                @enderror

                            </div>
                        </div>
                        @if($lama_izin == 'Lebih dari sehari')
                        <div class="col-12  col-lg-6">
                            <div class="mb-3">
                                <label for="sampai_tanggal" class="form-label">Sampai Tanggal
                                    <span class="text-danger"><sup>*</sup></span>
                                </label>
                                <input class="form-control @error('sampai_tanggal') is-invalid @enderror" type="date"
                                    wire:model.live='sampai_tanggal' id="sampai_tanggal" class="form-control">
                                @error('sampai_tanggal')
                                <span class="text-danger">{{$message}}</span>
                                @enderror

                            </div>
                        </div>
                        @endif

                        @if($keperluan_izin == 'Izin Tidak Masuk Kerja')
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="photo" class="form-label">Bukti Foto
                                </label>
                                <input type="file" wire:model="photo"
                                    class="form-control @error('photo') is-invalid @enderror">
                                <div wire:loading wire:target="photo">Uploading...</div>
                                @error('photo')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                                <div class="row">
                                    @if($oldPhoto != NULL)
                                    @if($oldPhoto)
                                    <div class="col-12 col-lg-6 mt-3">
                                        <div class="card shadow-sm">
                                            <div class="card-header text-center">
                                                <label for="oldPhoto" class="form-label">Foto lama</label>
                                            </div>
                                            <div class="card-body text-center">
                                                <img src="{{ Storage::url($oldPhoto)}}" style="max-width: 300px">
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($photo)
                                    <div class="col-12 col-lg-6 mt-3">
                                        <div class="card shadow-sm">
                                            <div class="card-header text-center">
                                                <label for="oldPhoto" class="form-label">Foto baru</label>
                                            </div>
                                            <div class="card-body text-center">
                                                <img src="{{ $photo->temporaryUrl() }}" style="max-width: 300px">
                                            </div>
                                        </div>
                                    </div>

                                    @endif
                                    @else
                                    @if($photo != NULL)
                                    <div class="col-12 col-lg-12 mt-3">
                                        <div class="card shadow-sm">
                                            <div class="card-header text-center">
                                                <label for="oldPhoto" class="form-label">Foto baru</label>
                                            </div>
                                            <div class="card-body text-center">
                                                <img src="{{ $photo->temporaryUrl() }}" style="max-width: 300px">
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endif
                                </div>

                            </div>
                        </div>
                        @endif

                        @if($keperluan_izin != 'Izin Tidak Masuk Kerja')
                        @if ($lama_izin == 'Sehari')

                        <div
                            class="col-12 @if ($keperluan_izin != 'Izin Datang Terlambat') col-lg-6 @else col-lg-12 @endif">
                            <div class="mb-3">
                                <label for="jam_masuk" class="form-label">Jam Mulai
                                    <span class="text-danger"><sup>*</sup></span>
                                </label>
                                <input class="form-control @error('jam_masuk') is-invalid @enderror" type="time"
                                    wire:model.live='jam_masuk' id="jam_masuk" class="form-control">
                                @error('jam_masuk')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        @if ($keperluan_izin != 'Izin Datang Terlambat')

                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label for="jam_keluar" class="form-label">Jam Akhir
                                    <span class="text-danger"><sup>*</sup></span>
                                </label>
                                <input class="form-control @error('jam_keluar') is-invalid @enderror" type="time"
                                    wire:model.live='jam_keluar' id="jam_keluar" class="form-control">
                                @error('jam_keluar')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        @endif
                        @endif
                        @endif
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

<div wire:ignore.self class="modal fade" id="photo" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-xl-down modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body ">
                <div class="text-center">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover shadow-sm" style="white-space: nowrap">
                            <tbody>
                                <tr>
                                    <td>
                                        <img src="{{ Storage::url($oldPhoto)}}" style="max-width: 750px">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary form-control" data-bs-dismiss="modal">Kembali</button>
            </div>
        </div>
    </div>
</div>

@push('surat-izin')
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
    window.addEventListener('show-photo-modal', event =>{
        $('#photo').modal('show');
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