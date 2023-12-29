@extends('admin.templates.main')
@section('content')
    
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                @if ($roleinfo->satuanpg != 'view')
                    {{-- TOMBOL ADD SATUAN --}}
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addSatuan"><i class="fa fa-plus-circle"></i>  Satuan</button>
                @endif
                
            </div>
            <div class="x_content">                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            {{-- TABEL SATUAN --}}
                            <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="10px">No</th>
                                        <th>Kode Satuan</th>
                                        <th>Satuan</th>
                                        @if ($roleinfo->satuanpg != 'view')
                                            <th>Opsi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($satuan as $s)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $s->kodesatuan }}</td>
                                        <td>{{ $s->satuan }}</td>
                                        @if ($roleinfo->satuanpg != 'view')
                                            <td style="white-space: nowrap;">
                                                <a class="btn btn-success btn-sm" data-toggle="modal" title="Update Satuan" href="#updateSatuan{{ $s->id }}"><i class="fa fa-edit"></i></a> 
                                                @if ($roleinfo->satuanpg == 'delete')
                                                    <a onclick="return confirm('Anda yakin menghapus Data Satuan ini?');" href="/satuan/delete/{{ $s->id }}" class="btn btn-danger btn-sm" title="Hapus Data Satuan"><i class="fa fa-trash"></i></a>
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

    {{-- POP UP ADD SATUAN  --}}
    <div id="addSatuan" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i>  Satuan</h5>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal form-label-left" action="{{route('satuan.add')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <label>Satuan</label>
                        <input type="text" @error('satuan') is-invalid @enderror style="text-transform: uppercase" class="form-control" id="nameadd" onkeyup="upperNameAdd()" name="satuan" required />
                        @error("satuan")
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

    {{-- POP UP UPDATE SATUAN  --}}
    @foreach ($satuan as $up)
    <div id="updateSatuan{{ $up->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"><i class="fa fa-pencil"></i> Satuan</h5>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal form-label-left" action="{{route('satuan.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" name="id" value="{{ $up->id }}" readonly>
                <div class="modal-body">
                    
                    <div class="form-group row">
                        <label>Satuan</label>
                        <input type="text" @error('satuan') is-invalid @enderror style="text-transform: uppercase" value="{{ $up->satuan }}" class="form-control" id="nameupdate" onkeyup="upperNameUpdate()" name="satuan" required />
                        @error("satuan")
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

@push('script')

{{-- FUNCTION NAMA SATUAN AUTO UPPERCASE --}}
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