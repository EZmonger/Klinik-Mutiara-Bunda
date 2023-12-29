@extends('admin.templates.main')
@section('content')
    
<div class="row">
    {{-- {{ alertbs_form($errors) }} --}}
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                @if ($roleinfo->pekerjaanpg != 'view')
                    {{-- TOMBOL ADD PEKERJAAN --}}
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addPekerjaan"><i class="fa fa-plus-circle"></i>  Pekerjaan</button>
                @endif
                
            </div>
            <div class="x_content">                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            {{-- TABEL PEKERJAAN --}}
                            <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="10px">No</th>
                                        <th>Kode Pekerjaan</th>
                                        <th>Pekerjaan</th>
                                        @if ($roleinfo->pekerjaanpg != 'view')
                                            <th>Opsi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pekerjaan as $p)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $p->kodepekerjaan }}</td>
                                        <td>{{ $p->pekerjaan }}</td>
                                        @if ($roleinfo->pekerjaanpg != 'view')
                                            <td style="white-space: nowrap;">
                                                <a class="btn btn-success btn-sm" data-toggle="modal" title="Update Pekerjaan" href="#updatePekerjaan{{ $p->id }}"><i class="fa fa-edit"></i></a> 
                                                @if ($roleinfo->pekerjaanpg == 'delete')
                                                    <a onclick="return confirm('Anda yakin menghapus Data Pekerjaan ini?');" href="/pekerjaan/delete/{{ $p->id }}" class="btn btn-danger btn-sm" title="Hapus Data Pekerjaan"><i class="fa fa-trash"></i></a>
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

    {{-- POP UP ADD PEKERJAAN --}}
    <div id="addPekerjaan" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i> Pekerjaan</h5>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal form-label-left" action="{{route('pekerjaan.add')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <label>Pekerjaan</label>
                        <input type="text" @error('pekerjaan') is-invalid @enderror style="text-transform: uppercase" class="form-control" name="pekerjaan" required />
                        @error("pekerjaan")
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

    {{-- POP UP EDIT PEKERJAAN --}}
    @foreach ($pekerjaan as $up)
    <div id="updatePekerjaan{{ $up->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"><i class="fa fa-pencil"></i> Pekerjaan</h5>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal form-label-left" action="{{route('pekerjaan.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" name="id" value="{{ $up->id }}" readonly>
                <div class="modal-body">
                    
                    <div class="form-group row">
                        <label>Pekerjaan</label>
                        <input type="text" @error('pekerjaan') is-invalid @enderror style="text-transform: uppercase" value="{{ $up->pekerjaan }}" class="form-control" name="pekerjaan" required />
                        @error("pekerjaan")
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