<style>
    h6 {
        font-size: 14px;
    }
</style>

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
                <h5 class="text-center">{{ $nama }}</h5>
                <hr>
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
                        <h6>: {{ $tanggal_cuti }}@if($durasi != '1 hari') s/d {{$sampai_tanggal}} @endif
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
                    <div class="col-7 col-lg-8" style="font-size: 14px">
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

@push('data-izin')
<script>
    window.addEventListener('show-view-modal', event =>{
        $('#view').modal('show');
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
</script>
@endpush