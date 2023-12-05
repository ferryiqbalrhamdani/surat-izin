<style>
    h6 {
        font-size: 14px;
    }
</style>

<div wire:ignore.self class="modal fade" id="view" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered @if(Auth::user()->role_id == 3) modal-lg @endif">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Detail Izin Lembur</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    wire:click='closeView'></button>
            </div>
            <div class="modal-body">
                <h5 class="text-center">{{ $nama }}</h5>
                <hr>
                <div class="row">
                    <div class="col-5 col-lg-4">
                        <h6>Tanggal Lembur</h6>
                    </div>
                    <div class="col-7 col-lg-8">
                        <h6>: {{ $tanggal_lembur }}</h6>
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
                    <div class="col-7 col-lg-8" style="font-size: 12px">
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
                        <h6>: {{ $keterangan }}
                        </h6>
                    </div>
                </div>
                @if(Auth::user()->role_id == 3)
                <div class="table-responsive mt-3" style="font-size: 14px;">
                    @if(date('G', strtotime($lama_lembur)) <= 5) <p style="font-size: 12px; margin-bottom: 0px"><sup
                            class="text-danger">*</sup> Upah Lembur Perjam:
                        Rp 15.000</p>
                        @endif
                        <table class="table table-bordered table-hover shadow-sm" style="white-space: nowrap">
                            <thead class="table-dark">
                                <th scope="col">
                                    Uang Makan
                                </th>
                                <th scope="col">
                                    Upah Lembur
                                </th>
                                <th scope="col">
                                    Total
                                </th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        @if($uang_makan > 0)
                                        Rp {{number_format($uang_makan, 0, ',','.')}}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>
                                        @if(date('G', strtotime($lama_lembur)) <= 5) Rp
                                            {{number_format($upah_lembur_perjam * date('G', strtotime($lama_lembur)),
                                            0, ',' ,'.')}} @else - @endif </td>
                                    <td>
                                        @if($upah_lembur > 0)
                                        Rp {{number_format($upah_lembur, 0, ',','.')}}
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                </div>
                @endif
            </div>
            <div class="modal-footer d-felx justify-content-center">
                <button type="button" class="btn btn-secondary form-control" data-bs-dismiss="modal"
                    wire:click='closeView'>Kembali</button>
            </div>
        </div>
    </div>
</div>

@push('data-lembur')
<script>
    window.addEventListener('show-view-modal', event =>{
        $('#view').modal('show');
    });

    document.addEventListener('livewire:initialized', () =>{
        @this.on('approveAtasan',(event) => {
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
        @this.on('rejectAtasan',(event) => {
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
        @this.on('resetAtasan',(event) => {
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
    // ------------ hrd -----------
    document.addEventListener('livewire:initialized', () =>{
        @this.on('approveHrd',(event) => {
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
        @this.on('rejectHrd',(event) => {
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
        @this.on('resetHrd',(event) => {
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