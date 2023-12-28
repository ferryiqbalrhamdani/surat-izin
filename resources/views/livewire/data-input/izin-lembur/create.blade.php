<div>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Tambah Data</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="/izin-lembur" style="text-decoration: none; color: black">Izin
                    Lembur</a></li>
            <li class="breadcrumb-item active">Tambah Data</li>
        </ol>
        <div class="row">
            <div class="col">
                <form wire:submit.prevent='addAction'>
                    <div class="card shadow-sm">
                        <div class="card-body">
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
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mt-3 mb-3 grid gap-3">
                                <button type="submit" class="btn btn-dark"><i class="fas fa-save"></i> Simpan</button>
                                <a href="/izin-lembur" class="btn btn-danger">Batal</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>