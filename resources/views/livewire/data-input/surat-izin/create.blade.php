<div>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Tambah Data</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="/surat-izin" style="text-decoration: none; color: black">Surat
                    Izin</a></li>
            <li class="breadcrumb-item active">Tambah Data</li>
        </ol>
        <div class="row">
            <div class="col">
                <form wire:submit.prevent='addAction'>
                    <div class="card shadow-sm">
                        <div class="card-body">
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
                                        <input class="form-control @error('tanggal_izin') is-invalid @enderror"
                                            type="date" wire:model.live='tanggal_izin' id="tanggal_izin"
                                            class="form-control">
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
                                        <input class="form-control @error('sampai_tanggal') is-invalid @enderror"
                                            type="date" wire:model.live='sampai_tanggal' id="sampai_tanggal"
                                            class="form-control">
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
                                        @if($photo != NULL)
                                        <div class="card shadow-sm mt-3">
                                            <div class="card-header text-center">
                                                <label for="oldPhoto" class="form-label">Upload Foto</label>
                                            </div>
                                            <div class="card-body text-center">
                                                <img src="{{ $photo->temporaryUrl() }}" style="max-width: 300px">
                                            </div>
                                        </div>
                                        @endif
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
                                        <input class="form-control @error('jam_keluar') is-invalid @enderror"
                                            type="time" wire:model.live='jam_keluar' id="jam_keluar"
                                            class="form-control">
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
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mt-3 mb-3 grid gap-3">
                                <button type="submit" class="btn btn-dark"><i class="fas fa-save"></i> Simpan</button>
                                <a href="/surat-izin" class="btn btn-danger">Batal</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>