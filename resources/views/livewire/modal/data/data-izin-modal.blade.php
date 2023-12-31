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

<div wire:ignore.self class="modal fade" id="view" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Detail Surat Izin</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    wire:click='closeView'></button>
            </div>
            <div class="modal-body">
                <h5 class="text-center">{{ $nama }}</h5>
                <hr>
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
                        <h6>:
                            {{-- <span class="badge rounded-pill text-bg-primary view" wire:click='lihatPhoto'>lihat
                                foto</span> --}}
                        </h6>
                        <h6>
                            <img src="{{ Storage::url($oldPhoto)}}" style="max-width: 300px; cursor: pointer;"
                                wire:click='lihatPhoto' class="card-img-top">

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

<!-- Download Modal -->
<div wire:ignore.self class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Download Data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:submit.prevent='downloadData'>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="dari_tanggal_download" class="form-label">Dari tanggal</label>
                                    <input type="date" id="dari_tanggal_download"
                                        wire:model.live='dari_tanggal_download'
                                        class="form-control @error('dari_tanggal_download') is-invalid @enderror">
                                    @error('dari_tanggal_download')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="sampai_tanggal_download" class="form-label">Sampai tanggal</label>
                                    <input type="date" id="sampai_tanggal_download"
                                        wire:model.live='sampai_tanggal_download'
                                        class="form-control @error('sampai_tanggal_download') is-invalid @enderror">
                                    @error('sampai_tanggal_download')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-lg-12">
                                <div class="mb-3">
                                    <label for="nama_file" class="form-label">Nama File</label>
                                    <input type="text" wire:model.live='nama_file'
                                        class="form-control @error('nama_file') is-invalid @enderror">
                                    @error('nama_file')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-lg-12">
                                <div class="mb-3">
                                    <label for="format_data" class="form-label">Format Data</label>
                                    <select class="form-select @error('format_data') is-invalid @enderror"
                                        aria-label="Default select example" wire:model.live='format_data'>
                                        <option></option>
                                        <option value="XLS">XLS</option>
                                        <option value="PDF">PDF</option>
                                        <option value="CSV">CSV</option>
                                    </select>
                                    @error('format_data')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark form-control">
                        <i class="fa-solid fa-download"></i> download
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('data-izin')
<script>
    window.addEventListener('show-view-modal', event =>{
        $(document).ready(function(){
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
        $('#view').modal('show');
    });

    window.addEventListener('show-photo-modal', event =>{
        $('#photo').modal('show');
    });
    window.addEventListener('hide-donwload-modal', event =>{
        $('#staticBackdrop').modal('hide');
    });

    document.addEventListener('livewire:initialized', () =>{
        @this.on('approveAtasan',(event) => {
            const data=event
            swal.fire({
                toast: true,
                position: "top",
                icon:data[0]['icon'],
                title:data[0]['title'],
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            })
            })
    });
    document.addEventListener('livewire:initialized', () =>{
        @this.on('rejectAtasan',(event) => {
            const data=event
            swal.fire({
                toast: true,
                position: "top",
                icon:data[0]['icon'],
                title:data[0]['title'],
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            })
            })
    });
    document.addEventListener('livewire:initialized', () =>{
        @this.on('resetAtasan',(event) => {
            const data=event
            swal.fire({
                toast: true,
                position: "top",
                icon:data[0]['icon'],
                title:data[0]['title'],
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            })
            })
    });
    // ------------ hrd -----------
    document.addEventListener('livewire:initialized', () =>{
        @this.on('approveHrd',(event) => {
            const data=event
            swal.fire({
                toast: true,
                position: "top",
                icon:data[0]['icon'],
                title:data[0]['title'],
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            })
            })
    });
    document.addEventListener('livewire:initialized', () =>{
        @this.on('rejectHrd',(event) => {
            const data=event
            swal.fire({
                toast: true,
                position: "top",
                icon:data[0]['icon'],
                title:data[0]['title'],
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            })
            })
    });
    document.addEventListener('livewire:initialized', () =>{
        @this.on('resetHrd',(event) => {
            const data=event
            swal.fire({
                toast: true,
                position: "top",
                icon:data[0]['icon'],
                title:data[0]['title'],
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            })
            })
    });
    document.addEventListener('livewire:initialized', () =>{
        @this.on('notAllowed',(event) => {
            const data=event
            swal.fire({
                toast: true,
                position: "top",
                icon:data[0]['icon'],
                title:data[0]['title'],
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            })
            })
    });
    
    // download
    document.addEventListener('livewire:initialized', () =>{
        @this.on('download',(event) => {
            const data=event
            swal.fire({
                toast: true,
                position: "top",
                icon:data[0]['icon'],
                title:data[0]['title'],
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            })
            })
    });

    $(".page-item").on('click', function(event) {
        Livewire.dispatch('resetMySelected');
    })
</script>
@endpush