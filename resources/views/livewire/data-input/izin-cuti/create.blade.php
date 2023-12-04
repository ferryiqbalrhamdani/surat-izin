<div>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Tambah Data</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="/izin-cuti" style="text-decoration: none; color: black">Izin
                    Cuti</a></li>
            <li class="breadcrumb-item active">Tambah Data</li>
        </ol>
        <div class="row">
            <div class="col">
                <form wire:submit.prevent='addAction'>
                    <div class="card shadow-sm">
                        <div class="card-body">
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
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mt-3 mb-3 grid gap-3">
                                <button type="submit" class="btn btn-dark"><i class="fas fa-save"></i> Simpan</button>
                                <a href="/izin-cuti" class="btn btn-danger">Batal</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>