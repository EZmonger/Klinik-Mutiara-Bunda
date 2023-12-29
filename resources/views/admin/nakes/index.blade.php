@extends('admin.templates.main')
@section('content')
    
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                @if ($roleinfo->nakespg != 'view')
                    {{-- TOMBOL ADD MEMBER --}}
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNakes"><i class="fa fa-plus-circle"></i>  Member</button>
                @endif
            </div>
            <div class="x_content">                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            {{-- TABEL NAKES --}}
                            <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="10px">No</th>
                                        <th>Kode Nakes</th>
                                        <th>Nama</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Alamat</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Pekerjaan</th>
                                        <th>Role</th>
                                        @if ($roleinfo->nakespg != 'view')
                                            <th>Opsi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($nakes as $nk)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $nk->kodenakes }}</td>
                                        <td>{{ $nk->nama }}</td>
                                        <td>{{ strtoupper(tgl_indo($nk->tgllahir)) }}</td>
                                        <td>{{ $nk->alamat }}</td>
                                        <td>{{ $nk->jeniskelamin }}</td>
                                        <td>{{ $nk->pekerjaan }}</td>
                                        <td>{{ $nk->role }}</td>
                                        @if ($roleinfo->nakespg != 'view')
                                            <td style="white-space: nowrap;">

                                                @if ($nk->idnakes != $infos->id)
                                                    @if ($nk->idRole != $adminRoleId || $roleinfo->id == $adminRoleId)
                                                        <a class="btn btn-warning btn-sm" data-toggle="modal" title="Reset Password Member" href="#updatePassword{{ $nk->idnakes }}"><i class="fa fa-edit"></i> Password</a> 
                                                        <a class="btn btn-success btn-sm" data-toggle="modal" title="Update Member" href="#updateNakes{{ $nk->idnakes }}"><i class="fa fa-edit"></i></a> 

                                                        @if ($roleinfo->nakespg == 'delete')
                                                            <a onclick="return confirm('Anda yakin menghapus Data Tenaga Kesehatan ini?');" href="/member/delete/{{ $nk->idnakes }}" class="btn btn-danger btn-sm" title="Hapus Data Tenaga Kesehatan"><i class="fa fa-trash"></i></a>
                                                        @endif
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

    {{-- POP UP ADD NAKES --}}
    <div id="addNakes" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i>  Member</h5>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal form-label-left" action="{{route('member.add')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group row">
                                <label>Nama</label>
                                <input type="text" @error('nama') is-invalid @enderror style="text-transform: uppercase" class="form-control" name="nama" required />
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
                        <textarea class="form-control" @error('alamat') is-invalid @enderror style="text-transform: uppercase" rows="2" name="alamat"></textarea>
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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label>Role</label>
                                <select class="form-control" name="role" required>
                                    <option selected disabled>-- PILIH ROLE --</option>
                                    @foreach ($role as $r)
                                        <option value="{{ $r->id }}">{{ $r->role }}</option>
                                    @endforeach
                                    {{-- <option value="ownerNakes">Owner & Tenaga Kesehatan</option> --}}
                                </select>
                                @error("role")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label>Pekerjaan</label>
                                <select class="form-control" name="pekerjaan" required>
                                    <option selected disabled>-- PILIH PEKERJAAN --</option>
                                    @foreach ($pekerjaan as $p)
                                        <option value="{{ $p->id }}">{{ $p->pekerjaan }}</option>
                                    @endforeach
                                    {{-- <option value="ownerNakes">Owner & Tenaga Kesehatan</option> --}}
                                </select>
                                @error("pekerjaan")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label>Username</label>
                        <input type="text" @error('username') is-invalid @enderror style="text-transform: lowercase" class="form-control" id="username" name="username" onkeyup="upperUsername()" required />
                        @error("username")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label>Password</label>
                                <div class="col-sm-12">
                                    <input type="password" @error('password') is-invalid @enderror class="form-control" id="inputPassword1" name="password" required />
                                    <span id="eyebtn1" onclick="showpass1()" class="form-control-feedback right"><i class="fa fa-eye-slash"></i></span>
                                    @error("password")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label>Comfirm Password</label>
                                <div class="col-sm-12">
                                    <input type="password" @error('password_confirmation') is-invalid @enderror class="form-control" id="inputPassword2" name="password_confirmation" required />
                                    <span id="eyebtn2" onclick="showpass2()" class="form-control-feedback right"><i class="fa fa-eye-slash"></i></span>
                                    @error("password_confirmation")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
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

    {{-- POP UP UPDATE NAKES --}}
    @foreach ($nakes as $up)
    <div id="updateNakes{{ $up->idnakes }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"><i class="fa fa-pencil"></i> Member</h5>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal form-label-left" action="{{route('member.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" name="id" value="{{ $up->idnakes }}" readonly>
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
                        <label>Jenis Kelamin</label>
                        <select class="form-control" id="jeniskelamin" name="jeniskelamin">
                            <option value="">-- PILIH JENIS KELAMIN --</option>
                            <option value="LAKI-LAKI" {{ $up->jeniskelamin == 'LAKI-LAKI' ? 'selected' : '' }}>LAKI-LAKI</option>
                            <option value="PEREMPUAN" {{ $up->jeniskelamin == 'PEREMPUAN' ? 'selected' : '' }}>PEREMPUAN</option>
                        </select>
                        @error("jeniskelamin")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label>Alamat</label>
                        <textarea class="form-control" @error('alamat') is-invalid @enderror style="text-transform: uppercase" rows="2" name="alamat">{{ $up->alamat }}</textarea>
                        @error("alamat")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label>Pekerjaan</label>
                        <select class="form-control" name="pekerjaan" required>
                            <option selected>-- PILIH PEKERJAAN --</option>
                            @foreach ($pekerjaan as $p)
                                <option value="{{ $p->id }}" {{ $up->idPekerjaan == $p->id ? 'selected' : '' }}>{{ $p->pekerjaan }}</option>
                            @endforeach
                            {{-- <option value="ownerNakes" {{ $up->role == 'ownerNakes' ? 'selected' : '' }}>Owner & Tenaga Kesehatan</option> --}}
                        </select>
                        @error("pekerjaan")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label>Role</label>
                        <select class="form-control" name="role" required>
                            <option selected disabled>-- PILIH ROLE --</option>
                            @foreach ($role as $r)
                                <option value="{{ $r->id }}" {{ $up->idRole == $r->id ? 'selected' : '' }}>{{ $r->role }}</option>
                            @endforeach
                            {{-- <option value="ownerNakes" {{ $up->role == 'ownerNakes' ? 'selected' : '' }}>Owner & Tenaga Kesehatan</option> --}}
                        </select>
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

    {{-- POP UP RESET PASSWORD --}}
    <div id="updatePassword{{ $up->idnakes }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Reset Password Member</h5>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal form-label-left" action="{{route('member.resetPassword')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" name="id" value="{{ $up->idnakes }}" readonly>
                <div class="modal-body">
                    <div class="form-group row">
                        <label>New Password</label>
                        <div class="col-sm-12">
                            <input type="password" @error('password') is-invalid @enderror class="form-control showPassword1" name="password" required />
                            <span class="form-control-feedback right password-showhide1">
                                <span class="show-password"><i class="fa fa-eye-slash"></i></span>
                                <span class="hide-password" style="display: none"><i class="fa fa-eye"></i></span>
                            </span>
                            @error("password")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label>Confirm Password</label>
                        <div class="col-sm-12">
                            <input type="password" @error('password_confirmation') is-invalid @enderror class="form-control showPassword2" name="password_confirmation" required />
                            <span class="form-control-feedback right password-showhide2">
                                <span class="show-password"><i class="fa fa-eye-slash"></i></span>
                                <span class="hide-password" style="display: none"><i class="fa fa-eye"></i></span>
                            </span>
                            @error("password_confirmation")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
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

{{-- FUNCTION USERNAME AUTO LOWERCASE --}}
<script>
    function upperUsername() {
        let x = document.getElementById("username");
        x.value = x.value.toLowerCase();
    }
</script>

{{-- FUNCTION SHOW PASSWORD --}}
<script>
    jQuery(document).ready(function(){
        $(".password-showhide1 .show-password").click(function() {
	    	$(".showPassword1").attr("type", "text");
	    	$(".password-showhide1 .show-password").hide();
	    	$(".password-showhide1 .hide-password").show();
	    });
	    $(".password-showhide1 .hide-password").click(function() {
	    	$(".showPassword1").attr("type", "password");
	    	$(".password-showhide1 .hide-password").hide();
	    	$(".password-showhide1 .show-password").show();
	    });

        $(".password-showhide2 .show-password").click(function() {
	    	$(".showPassword2").attr("type", "text");
	    	$(".password-showhide2 .show-password").hide();
	    	$(".password-showhide2 .hide-password").show();
	    });
	    $(".password-showhide2 .hide-password").click(function() {
	    	$(".showPassword2").attr("type", "password");
	    	$(".password-showhide2 .hide-password").hide();
	    	$(".password-showhide2 .show-password").show();
	    });
    });
</script>

{{-- FUNCTION SHOW PASSWORD  --}}
<script>
    function showpass1()
    {
        var x = document.getElementById('inputPassword1').type;
        if (x == 'password')
        {
        document.getElementById('inputPassword1').type = 'text';
        document.getElementById('eyebtn1').innerHTML = '<i class="fa fa-eye"></i>';
        }
        else
        {
            document.getElementById('inputPassword1').type = 'password';
            document.getElementById('eyebtn1').innerHTML = '<i class="fa fa-eye-slash"></i>';
        }
    }

    function showpass2()
    {
        var x = document.getElementById('inputPassword2').type;
        if (x == 'password')
        {
        document.getElementById('inputPassword2').type = 'text';
        document.getElementById('eyebtn2').innerHTML = '<i class="fa fa-eye"></i>';
        }
        else
        {
            document.getElementById('inputPassword2').type = 'password';
            document.getElementById('eyebtn2').innerHTML = '<i class="fa fa-eye-slash"></i>';
        }
    }

    
</script>
@endpush