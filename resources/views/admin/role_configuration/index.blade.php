@extends('admin.templates.main')
@section('content')



<div class="row">

    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                {{-- TOMBOL ADD ROLE --}}
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addRole"><i class="fa fa-plus-circle"></i> Role</button>
            </div>
            <div class="x_content">                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            {{-- TABEL ROLE --}}
                            <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="10px">No</th>
                                        <th>Role</th>
                                        <th>Kode Role</th>
                                        <th>Master Member</th>
                                        <th>Master Pekerjaan</th>
                                        <th>Master Tindakan</th>
                                        <th>Master Satuan Obat</th>
                                        <th>Master Obat</th>
                                        <th>Registrasi Pasien</th>
                                        <th>Pasien Transaction</th>
                                        <th>Payment Transaction</th>
                                        <th>Pengaturan Akun</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($matrix as $m)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td style="font-weight: bold">{{ $m->role }}</td>
                                        <td style="font-weight: bold">{{ $m->koderole }}</td>
                                        <td>
                                            {{-- {{ $m->nakespg }} <br> --}}
                                            
                                            <select class="selectPriv" name="role" data-id="{{ $m->id }}" data-page="nakespg" style="width: 145px" required>
                                                <option value="none"{{ $m->nakespg == 'none' ? 'selected' : '' }}>None</option>
                                                <option value="view"{{ $m->nakespg == 'view' ? 'selected' : '' }}>View Only</option>
                                                {{-- @if ($m->role != 'nakes') --}}
                                                    {{-- <option value="edit"{{ $m->nakespg == 'edit' ? 'selected' : '' }}>View and Edit</option>
                                                    <option value="delete"{{ $m->pekerjaanpg == 'delete' ? 'selected' : '' }}>View, Edit and Delete</option> --}}


                                                <option value="delete"{{ $m->nakespg == 'delete' ? 'selected' : '' }}>View and Edit</option>
                                                {{-- @endif --}}
                                                {{-- <option value="ownerNakes">Owner & Tenaga Kesehatan</option> --}}
                                            </select>
                                        </td>
                                        <td>
                                            {{-- {{ $m->pekerjaanpg }}<br> --}}
                                            <select class="selectPriv" name="role" data-id="{{ $m->id }}" data-page="pekerjaanpg" style="width: 145px" required>
                                                <option value="none"{{ $m->pekerjaanpg == 'none' ? 'selected' : '' }}>None</option>
                                                <option value="view"{{ $m->pekerjaanpg == 'view' ? 'selected' : '' }}>View Only</option>

                                                {{-- <option value="edit"{{ $m->pekerjaanpg == 'edit' ? 'selected' : '' }}>View and Edit</option>
                                                <option value="delete"{{ $m->pekerjaanpg == 'delete' ? 'selected' : '' }}>View, Edit and Delete</option> --}}
                                                
                                                <option value="delete"{{ $m->pekerjaanpg == 'delete' ? 'selected' : '' }}>View and Edit</option>
                                                {{-- <option value="ownerNakes">Owner & Tenaga Kesehatan</option> --}}
                                            </select>
                                        </td>
                                        <td>
                                            {{-- {{ $m->tindakanpg }}<br> --}}
                                            <select class="selectPriv" name="role" data-id="{{ $m->id }}" data-page="tindakanpg" style="width: 145px" required>
                                                <option value="none"{{ $m->tindakanpg == 'none' ? 'selected' : '' }}>None</option>
                                                <option value="view"{{ $m->tindakanpg == 'view' ? 'selected' : '' }}>View Only</option>
                                                
                                                {{-- <option value="edit"{{ $m->tindakanpg == 'edit' ? 'selected' : '' }}>View and Edit</option>
                                                <option value="delete"{{ $m->tindakanpg == 'delete' ? 'selected' : '' }}>View, Edit and Delete</option> --}}

                                                
                                                <option value="delete"{{ $m->tindakanpg == 'delete' ? 'selected' : '' }}>View and Edit</option>
                                                {{-- <option value="ownerNakes">Owner & Tenaga Kesehatan</option> --}}
                                            </select>
                                        </td>
                                        <td>
                                            {{-- {{ $m->satuanpg }}<br> --}}
                                            <select class="selectPriv" name="role" data-id="{{ $m->id }}" data-page="satuanpg" style="width: 145px" required>
                                                <option value="none"{{ $m->satuanpg == 'none' ? 'selected' : '' }}>None</option>
                                                <option value="view"{{ $m->satuanpg == 'view' ? 'selected' : '' }}>View Only</option>

                                                {{-- <option value="edit"{{ $m->satuanpg == 'edit' ? 'selected' : '' }}>View and Edit</option>
                                                <option value="delete"{{ $m->satuanpg == 'delete' ? 'selected' : '' }}>View, Edit and Delete</option> --}}

                                                
                                                <option value="delete"{{ $m->satuanpg == 'delete' ? 'selected' : '' }}>View and Edit</option>
                                                {{-- <option value="editstock"{{ $m->obatpg == 'editstock' ? 'selected' : '' }}>View and Edit Stock Only</option>
                                                <option value="editdata"{{ $m->obatpg == 'editdata' ? 'selected' : '' }}>View and Edit Data Only</option> --}}
                                                {{-- <option value="ownerNakes">Owner & Tenaga Kesehatan</option> --}}
                                            </select>
                                        </td>
                                        <td>
                                            {{-- {{ $m->obatpg }}<br> --}}
                                            <select class="selectPriv" name="role" data-id="{{ $m->id }}" data-page="obatpg" style="width: 145px" required>
                                                <option value="none"{{ $m->obatpg == 'none' ? 'selected' : '' }}>None</option>
                                                <option value="view"{{ $m->obatpg == 'view' ? 'selected' : '' }}>View Only</option>

                                                {{-- <option value="edit"{{ $m->obatpg == 'edit' ? 'selected' : '' }}>View and Edit</option>
                                                <option value="delete"{{ $m->obatpg == 'delete' ? 'selected' : '' }}>View, Edit and Delete</option> --}}

                                                
                                                <option value="delete"{{ $m->obatpg == 'delete' ? 'selected' : '' }}>View and Edit</option>
                                                {{-- <option value="editstock"{{ $m->obatpg == 'editstock' ? 'selected' : '' }}>View and Edit Stock Only</option>
                                                <option value="editdata"{{ $m->obatpg == 'editdata' ? 'selected' : '' }}>View and Edit Data Only</option> --}}
                                                {{-- <option value="ownerNakes">Owner & Tenaga Kesehatan</option> --}}
                                            </select>
                                        </td>
                                        <td>
                                            {{-- {{ $m->regpasienpg }} <br> --}}
                                            <select class="selectPriv" name="role" data-id="{{ $m->id }}" data-page="regpasienpg" style="width: 145px" required>
                                                <option value="none"{{ $m->regpasienpg == 'none' ? 'selected' : '' }}>None</option>
                                                <option value="view"{{ $m->regpasienpg == 'view' ? 'selected' : '' }}>View Only</option>

                                                {{-- <option value="edit"{{ $m->regpasienpg == 'edit' ? 'selected' : '' }}>View and Edit</option>
                                                <option value="delete"{{ $m->regpasienpg == 'delete' ? 'selected' : '' }}>View, Edit and Delete</option> --}}

                                                
                                                <option value="delete"{{ $m->regpasienpg == 'delete' ? 'selected' : '' }}>View and Edit</option>
                                                {{-- <option value="ownerNakes">Owner & Tenaga Kesehatan</option> --}}
                                            </select>
                                        </td>
                                        <td>
                                            {{-- {{ $m->pasienTranspg }} --}}
                                            <select class="selectPriv" name="role" data-id="{{ $m->id }}" data-page="pasienTranspg" style="width: 145px" required>
                                                <option value="none"{{ $m->pasienTranspg == 'none' ? 'selected' : '' }}>None</option>
                                                <option value="view"{{ $m->pasienTranspg == 'view' ? 'selected' : '' }}>View Only</option>

                                                {{-- <option value="edit"{{ $m->pasienTranspg == 'edit' ? 'selected' : '' }}>View and Edit</option>
                                                <option value="delete"{{ $m->pasienTranspg == 'delete' ? 'selected' : '' }}>View, Edit and Delete</option> --}}

                                                
                                                <option value="delete"{{ $m->pasienTranspg == 'delete' ? 'selected' : '' }}>View and Edit</option>
                                                {{-- <option value="ownerNakes">Owner & Tenaga Kesehatan</option> --}}
                                            </select>
                                        </td>
                                        <td>
                                            {{-- {{ $m->paymentTranspg }} --}}
                                            <select class="selectPriv" name="role" data-id="{{ $m->id }}" data-page="paymentTranspg" style="width: 145px" required>
                                                <option value="none"{{ $m->paymentTranspg == 'none' ? 'selected' : '' }}>None</option>
                                                <option value="view"{{ $m->paymentTranspg == 'view' ? 'selected' : '' }}>View Only</option>

                                                {{-- <option value="edit"{{ $m->paymentTranspg == 'edit' ? 'selected' : '' }}>View and Edit</option>
                                                <option value="delete"{{ $m->paymentTranspg == 'delete' ? 'selected' : '' }}>View, Edit and Delete</option> --}}

                                                
                                                <option value="delete"{{ $m->paymentTranspg == 'delete' ? 'selected' : '' }}>View and Edit</option>
                                                {{-- <option value="ownerNakes">Owner & Tenaga Kesehatan</option> --}}
                                            </select>
                                        </td>
                                        <td>
                                            {{-- {{ $m->profilepg }} --}}
                                            <select class="selectPriv" name="role" data-id="{{ $m->id }}" data-page="profilepg" style="width: 145px" required>
                                                <option value="none"{{ $m->profilepg == 'none' ? 'selected' : '' }}>None</option>
                                                <option value="view"{{ $m->profilepg == 'view' ? 'selected' : '' }}>View Only</option>
                                                
                                                {{-- <option value="edit"{{ $m->profilepg == 'edit' ? 'selected' : '' }}>View and Edit</option>
                                                <option value="delete"{{ $m->profilepg == 'delete' ? 'selected' : '' }}>View, Edit and Delete</option> --}}

                                                
                                                <option value="delete"{{ $m->profilepg == 'delete' ? 'selected' : '' }}>View and Edit</option>
                                                {{-- <option value="editprof"{{ $m->profilepg == 'editprof' ? 'selected' : '' }}>View and Edit Profile Only</option>
                                                <option value="editpass"{{ $m->profilepg == 'editpass' ? 'selected' : '' }}>View and Edit Password Only</option> --}}
                                                {{-- <option value="ownerNakes">Owner & Tenaga Kesehatan</option> --}}
                                            </select>
                                        </td>
                                        <td style="white-space: nowrap;">
                                            <a class="btn btn-success btn-sm" data-toggle="modal" title="Update Role" href="#updateRole{{ $m->id }}"><i class="fa fa-edit"></i></a> 
                                            <a onclick="return confirm('Anda yakin menghapus Data Role ini?');" href="/roleconfig/delete/{{ $m->id }}" class="btn btn-danger btn-sm" title="Hapus Data Role"><i class="fa fa-trash"></i></a>
                                                
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- <div class="col-md-12 col-sm-12">
                                <div class="row justify-content-end">
                                    @if (!$matrix->isEmpty())
                                        <a href="/roleconfig/saveconfig" class="btn btn-primary" style="margin: 20px">Save</a>
                                    @endif
                                </div>
                            </div> --}}
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <div class="row justify-content-end">
                                @if (!$matrix->isEmpty())
                                    {{-- SAVE PERUBAHAN ROLE --}}
                                    <a href="/roleconfig/saveconfig" class="btn btn-primary" style="margin: 20px">Save</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- POP UP ADD ROLE --}}
    <div id="addRole" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i> Role</h5>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal form-label-left" action="{{route('role.add')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <label>Role</label>
                        <input type="text" @error('role') is-invalid @enderror style="text-transform: uppercase" class="form-control" name="role" required />
                        @error("role")
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

    {{-- POP UP UPDATE ROLE (GANTI NAMA ROLE) --}}
    @foreach ($matrix as $up)
    <div id="updateRole{{ $up->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"><i class="fa fa-pencil"></i> Role</h5>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal form-label-left" action="{{route('role.edit')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" name="id" value="{{ $up->id }}" readonly>
                <div class="modal-body">
                    
                    <div class="form-group row">
                        <label>Role</label>
                        <input type="text" @error('role') is-invalid @enderror style="text-transform: uppercase" value="{{ $up->role }}" class="form-control" name="role" required />
                        @error("role")
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
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

{{-- FIX TABEL SCROLL KESAMPING --}}
<script>
    jQuery(document).ready(function(){
        $('#datatable').DataTable({
            destroy: true,
            fixedHeader: false,
            scrollX: true,
            scrollCollapse: true,
            scrollY: 600,
            "sScrollXInner": "110%",
        });
    });
    
</script>

{{-- GANTI PRIVILEDGE ROLE  --}}
<script>
    jQuery(document).ready(function(){
        $('#datatable tbody').on('change', '.selectPriv', function(){
            var id = jQuery(this).attr('data-id');
            var value = jQuery(this).val();
            var page = jQuery(this).attr('data-page');
            // var 
            // jQuery(this).attr('data-id');
            // alert(value);
            $.ajax({
                url:'/roleconfig/ubahconfig',
                type:'post',
                cache: true,
                data: {
                        'id': id,
                        'priv': value,
                        'page': page,
                        '_token': '{{ csrf_token() }}'
                    },
                timeout:60000,
                success:function(){
                             
                }
            })
        })    
    });
</script>
@endpush
