@extends('admin.templates.main')
@section('content')
    
<div class="row">

    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                @if ($roleinfo->tindakanpg != 'view')
                    {{-- TOMBOL ADD TINDAKAN --}}
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addTindakan"><i class="fa fa-plus-circle"></i>  Tindakan</button>
                    {{-- TOMBOL IMPORT TINDAKAN --}}
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#importTindakan"><i class="fa fa-upload"></i> Import Data Tindakan</button>
                @endif
                
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            {{-- TOMBOL TABEL TINDAKAN --}}
                            <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="10px">No</th>
                                        <th>Kode Tindakan</th>
                                        <th>Nama Tindakan</th>
                                        <th>Tujuan Tindakan</th>
                                        <th>Harga</th>
                                        @if ($roleinfo->tindakanpg != 'view')
                                            <th>Opsi</th>
                                        @endif                 
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tindakan as $td)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $td->kodetindakan }}</td>
                                        <td>{{ $td->tindakan }}</td>
                                        <td>{{ $td->tujuan }}</td>
                                        <td>{{ 'Rp. '.number_format($td->harga,0,',','.') }}</td>
                                        @if ($roleinfo->tindakanpg != 'view')
                                            <td style="white-space: nowrap;">
                                                <a class="btn btn-success btn-sm" data-toggle="modal" title="Update Tindakan" href="#updateTindakan{{ $td->id }}"><i class="fa fa-edit"></i></a> 
                                                @if ($roleinfo->tindakanpg == 'delete')
                                                    <a onclick="return confirm('Anda yakin menghapus Data Tindakan ini?');" href="/tindakan/delete/{{ $td->id }}" class="btn btn-danger btn-sm" title="Hapus Data Tindakan"><i class="fa fa-trash"></i></a>
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

    {{-- POP UP ADD TINDAKAN --}}
    <div id="addTindakan" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i> Tindakan</h5>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal form-label-left" action="{{route('tindakan.add')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <label>Nama Tindakan</label>
                        <input type="text" @error('tindakan') is-invalid @enderror style="text-transform: uppercase" class="form-control" id="nameadd" name="tindakan" onkeyup="upperNameAdd()" required />
                        @error('tindakan')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group row">
                        <label>Tujuan Tindakan</label>
                        <input type="text" @error('tujuan') is-invalid @enderror style="text-transform: uppercase" class="form-control" name="tujuan" required />
                        @error('tujuan')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label>Harga</label>
                        <input type="number" @error('harga') is-invalid @enderror class="form-control" name="harga" required />
                        @error('harga')
                            <span class="text-danger">{{$message}}</span>
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

    {{-- POP UP IMPORT TINDAKAN --}}
    <div id="importTindakan" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Import Data Tindakan</h5>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal form-label-left" action="{{route('tindakan.import')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <label>Input File Here (.xlsx)</label>
                        <input type="file" @error('excelfile') is-invalid @enderror class="form-control" name="excelfile" required />
                        @error('excelfile')
                            <span class="text-danger">{{$message}}</span>
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

    {{-- POP UP UPDATE TINDAKAN --}}
    @foreach ($tindakan as $up)
    <div id="updateTindakan{{ $up->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"><i class="fa fa-pencil"></i> Tindakan</h5>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal form-label-left" action="{{route('tindakan.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" name="id" value="{{ $up->id }}" readonly>
                <div class="modal-body">
                    <div class="form-group row">
                        <label>Nama Tindakan</label>
                        <input type="text" @error('tindakan') is-invalid @enderror style="text-transform: uppercase" class="form-control" id="nameupdate" name="tindakan" onkeyup="upperNameUpdate()" value="{{ $up->tindakan }}" />
                        @error('tindakan')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label>Tujuan Tindakan</label>
                        <input type="text" @error('tujuan') is-invalid @enderror style="text-transform: uppercase" class="form-control" name="tujuan" value="{{ $up->tujuan }}" />
                        @error('tujuan')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label>Harga</label>
                        <input type="number" @error('harga') is-invalid @enderror class="form-control" name="harga" value="{{ $up->harga }}" />
                        @error('harga')
                            <span class="text-danger">{{$message}}</span>
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

@push('script')

{{-- FUNCTION NAMA TINDAKAN AUTO UPPERCASE --}}
<script>
    function upperNameAdd() {
        let x = document.getElementById("nameadd");
        x.value = x.value.toUpperCase();
    }
    function upperNameUpdate() {
        let x = document.getElementById("nameupdate");
        x.value = x.value.toUpperCase();
    }
</script>
    
@endpush