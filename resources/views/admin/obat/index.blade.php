@extends('admin.templates.main')
@section('content')
    
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                @if ($roleinfo->obatpg != 'view')
                    {{-- TOMBOL ADD OBAT --}}
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addObat"><i class="fa fa-plus-circle"></i>  Obat</button>
                    {{-- TOMBOL IMPORT OBAT --}}
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#importObat"><i class="fa fa-upload"></i> Import Data Obat</button>
                @endif
                
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            {{-- TABEL OBAT --}}
                            <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="10px">No</th>
                                        <th>Kode Obat</th>
                                        <th>Nama Obat</th>
                                        <th>Satuan</th>
                                        <th>Stock</th>
                                        <th>Harga</th>
                                        @if ($roleinfo->obatpg != 'view')
                                            <th>Opsi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($obat as $ob)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $ob->kodeobat }}</td>
                                        <td>{{ $ob->obat }}</td>
                                        <td>{{ $ob->satuan }}</td>
                                        <td>{{ $ob->stock }}</td>
                                        <td>{{ 'Rp. '.number_format($ob->harga,0,',','.') }}</td>
                                        @if ($roleinfo->obatpg != 'view')
                                            <td style="white-space: nowrap;">
                                                @if ($roleinfo->obatpg == 'editstock')
                                                    <a class="btn btn-warning btn-sm" data-toggle="modal" title="Update Stock Obat" href="#updateStockObat{{ $ob->obatid }}"><i class="fa fa-archive"></i></a> 
                                                @endif
                                                @if ($roleinfo->obatpg == 'editdata')
                                                    <a class="btn btn-success btn-sm" data-toggle="modal" title="Update Data Obat" href="#updateObat{{ $ob->obatid }}"><i class="fa fa-edit"></i></a> 
                                                    <a onclick="return confirm('Anda yakin menghapus Data Obat ini?');" href="/obat/delete/{{ $ob->obatid }}" class="btn btn-danger btn-sm" title="Hapus Data Obat"><i class="fa fa-trash"></i></a>
                                                @endif
                                                @if ($roleinfo->obatpg == 'edit' || $roleinfo->obatpg == 'delete')
                                                    <a class="btn btn-warning btn-sm" data-toggle="modal" title="Update Stock Obat" href="#updateStockObat{{ $ob->obatid }}"><i class="fa fa-archive"></i></a> 
                                                    <a class="btn btn-success btn-sm" data-toggle="modal" title="Update Data Obat" href="#updateObat{{ $ob->obatid }}"><i class="fa fa-edit"></i></a> 
                                                    <a onclick="return confirm('Anda yakin menghapus Data Obat ini?');" href="/obat/delete/{{ $ob->obatid }}" class="btn btn-danger btn-sm" title="Hapus Data Obat"><i class="fa fa-trash"></i></a>
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

    <div id="addObat" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i> Obat</h5>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal form-label-left" action="{{route('obat.add')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <label>Nama Obat</label>
                        <input type="text" @error('obat') is-invalid @enderror style="text-transform: uppercase" class="form-control" id="nameadd" onkeyup="upperNameAdd()" name="obat" required />
                        @error('obat')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label>Satuan</label>
                        <select class="form-control" name="satuan" required>
                            <option selected disabled>-- PILIH SATUAN --</option>
                            @foreach ($satuan as $s)
                                <option value="{{ $s->id }}">{{ $s->satuan }}</option>
                            @endforeach
                        </select>
                        @error('satuan')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label>Stock</label>
                        <input type="number" @error('stock') @enderror class="form-control" name="stock" min="0" required />
                        @error('stock')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label>Harga</label>
                        <input type="number" @error('harga') @enderror class="form-control" name="harga" required />
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

    {{-- POP UP IMPORT OBAT --}}
    <div id="importObat" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Import Data Obat</h5>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal form-label-left" action="{{route('obat.import')}}" method="POST" enctype="multipart/form-data">
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

    {{-- POP UP UPDATE OBAT --}}
    @foreach ($obat as $up)
    <div id="updateObat{{ $up->obatid }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"><i class="fa fa-pencil"></i>  Obat</h5>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal form-label-left" action="{{route('obat.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" name="id" value="{{ $up->obatid }}" readonly>
                <div class="modal-body">
                    <div class="form-group row">
                        <label>Nama Obat</label>
                        <input type="text" @error('obat') is-invalid @enderror style="text-transform: uppercase" class="form-control" id="nameupdate" name="obat" onkeyup="upperNameUpdate()" value="{{ $up->obat }}" />
                        @error('obat')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label>Satuan</label>
                        <select class="form-control" name="satuan" required>
                            <option selected disabled>-- PILIH SATUAN --</option>
                            @foreach ($satuan as $s)
                                <option value="{{ $s->id }}" {{ $up->idSatuan == $s->id ? 'selected' : '' }}>{{ $s->satuan }}</option>
                            @endforeach
                        </select>
                        @error('satuan')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label>Harga</label>
                        <input type="number" @error('stock') is-invalid @enderror class="form-control" name="harga" min="0" value="{{ $up->harga }}" />
                        @error('stock')
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

    {{-- POP UP UPDATE OBAT --}}
    @foreach ($obat as $up)
    <div id="updateStockObat{{ $up->obatid }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"><i class="fa fa-pencil"></i> Stock Obat</h5>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal form-label-left" action="{{route('obat.updateStock')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" name="id" value="{{ $up->obatid }}" readonly>
                <div class="modal-body">
                    <div class="form-group row">
                        <label>Stock</label>
                        <input type="number" @error('stock') is-invalid @enderror class="form-control" min="0" name="stock" value="{{ $up->stock }}" />
                        @error('stock')
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

{{-- FUNCTION NAMA OBAT AUTO UPPERCASE --}}
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