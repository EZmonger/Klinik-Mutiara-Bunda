@extends('admin.templates.main')
@section('content')
    
<div class="row">
    <div class="col-md-12 col-sm-12">

        <div class="row justify-content-end">
            <div class="col-md-3">
                {{-- FILTER TANGGAL  --}}
                <form class="form-horizontal form-label-left" action="{{route('pasien.search')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <input type="date" class="form-control form-control-sm" name="tanggal" placeholder="dd/mm/yyyy" value="{{ $tanggalsearch }}" required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" name="search" value="cari" class="btn btn-block btn-primary btn-sm"><i class="fa fa-search"></i> Cari</button>
                    </div>
                </div>
                </form>
            </div>    
        </div>

        <div class="x_panel">
            <div class="x_title">
                @if ($roleinfo->regpasienpg != 'view')
                    {{-- TOMBOL REGISTRASI PASIEN --}}
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addPasien"> Registrasi Pasien</button>
                @endif
                
            </div>
            <div class="x_content">                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            {{-- TABEL PASIEN TEREGISTRASI  --}}
                            <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="10px">No</th>
                                        <th>Kode Registrasi</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>                               
                                        <th>Jenis Kelamin</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Umur</th>
                                        <th>No. BPJS</th>
                                        @if (($roleinfo->pasienTranspg != 'none' && $roleinfo->paymentTranspg != 'none') || $roleinfo->regpasienpg != 'view')
                                            <th>Opsi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pasien as $ps)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $ps->koderegistrasi }}</td>
                                        <td>{{ $ps->nama }}</td>
                                        <td>{{ $ps->alamat }}</td>
                                        <td>{{ $ps->jeniskelamin }}</td>
                                        <td>{{ strtoupper(tgl_indo($ps->tgllahir)) }}</td>                                    
                                        <td>{{\Carbon\Carbon::parse($ps->tgllahir)->age}} TAHUN</td>
                                        <td>{{ $ps->bpjs}}</td>
                                        @if (($roleinfo->pasienTranspg != 'none' && $roleinfo->paymentTranspg != 'none') || $roleinfo->regpasienpg != 'view')
                                            <td style="white-space: nowrap;">
                                                @if ($roleinfo->pasienTranspg != 'none' && $roleinfo->paymentTranspg != 'none')
                                                    <a class="btn btn-primary btn-sm" title="Cek Rekaman Medis" href="/pasien/rekamanmedisadm/{{$ps->id}}"><i class="fa fa-archive"></i></a> 
                                                @endif
                                                @if ($roleinfo->regpasienpg != 'view')
                                                    <a class="btn btn-success btn-sm" data-toggle="modal" title="Update Pasien" href="#updatePasiens{{ $ps->id }}"><i class="fa fa-edit"></i></a> 
                                                    @if ($roleinfo->regpasienpg == 'delete')
                                                        <a onclick="return confirm('Anda yakin menghapus Data Pasien ini?');" href="/pasien/delete/{{ $ps->id }}" class="btn btn-danger btn-sm" title="Hapus Data Pasien"><i class="fa fa-trash"></i></a>
                                                    @endif
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- POP UP REGISTRASI PASIEN --}}
    <div id="addPasien" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Registrasi Pasien</h5>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal form-label-left" action="{{route('pasien.add')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">                                                                                          
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group row">
                                <label>Nama</label>
                                <input type="text" @error('nama') is-invalid @enderror class="form-control" style="text-transform: uppercase" name="nama" required />
                                @error("nama")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label>Tanggal Lahir</label>
                                <input type="date" @error('tgllahir') is-invalid @enderror class="form-control" name="tgllahir" required />
                                @error("tgllahir")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label>Alamat</label>
                        <input type="text" @error('alamat') is-invalid @enderror style="text-transform: uppercase" class="form-control" name="alamat" required />
                        @error("alamat")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label>Jenis Kelamin</label>
                        <select class="form-control" id="jeniskelamin" name="jeniskelamin">
                            <option value="">-- PILIH JENIS KELAMIN --</option>
                            <option value="LAKI-LAKI">LAKI-LAKI</option>
                            <option value="PEREMPUAN">PEREMPUAN</option>
                        </select>
                        @error("jeniskelamin")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div> 
                    <div class="form-group row">
                        <label>No. BPJS (Jika Ada)</label>
                        <input type="text" @error('bpjs') is-invalid @enderror class="form-control" name="bpjs" />
                        @error("bpjs")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>

            </div>
        </div>
    </div>

    {{-- POP UP UPDATE PASIEN TEREGISTER --}}
    @foreach ($pasien as $up)
    <div id="updatePasiens{{ $up->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"><i class="fa fa-pencil"></i> Pasien</h5>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal form-label-left" action="{{route('pasien.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" name="id" value="{{ $up->id }}" readonly>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group row">
                                <label>Nama</label>
                                <input type="text" @error('nama') is-invalid @enderror style="text-transform: uppercase" class="form-control" name="nama" value="{{ $up->nama }}" required />
                                @error("nama")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label>Tanggal Lahir</label>
                                <input type="date" @error('tgllahir') is-invalid @enderror class="form-control" name="tgllahir" value="{{ $up->tgllahir }}" required />
                                @error("tgllahir")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label>Alamat</label>
                        <input type="text" @error('alamat') is-invalid @enderror style="text-transform: uppercase" class="form-control" name="alamat" value="{{ $up->alamat }}" required />
                        @error("alamat")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>   
                    <div class="form-group row">
                        <label>Jenis Kelamin</label>
                        <select class="form-control" id="jeniskelamin" name="jeniskelamin">
                            <option value="">-- PILIH JENIS KELAMIN --</option>
                            <option value="LAKI-LAKI" {{ $up->jeniskelamin	 == 'LAKI-LAKI' ? 'selected' : ''}}>LAKI-LAKI</option>
                            <option value="PEREMPUAN" {{ $up->jeniskelamin	 == 'PEREMPUAN' ? 'selected' : ''}}>PEREMPUAN</option>
                        </select>
                        @error("jeniskelamin")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div> 
                    <div class="form-group row">
                        <label>No. BPJS (Jika Ada)</label>
                        <input type="text" @error('bpjs') is-invalid @enderror class="form-control" name="bpjs" value="{{ $up->bpjs }}" />
                        @error("bpjs")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection