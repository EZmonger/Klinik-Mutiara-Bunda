@extends('admin.templates.main')
@section('content')
    
{{-- TAMPILAN DATA PROFILE --}}
<div class="row">
@foreach ($profil as $p)
    <div class="col-md-6 col-sm-6" style="margin: auto">
        <div class="x_panel">
            <div class="x_content">                
                <h1>{{ $p->nama }}</h1>
                <h2>Username: {{ $p->username }}</h2>
                <h2>Tanggal Lahir: {{ strtoupper(tgl_indo($p->tgllahir)) }}</h2>
                <h2>Alamat: {{ $p->alamat }}</h2>
                <h2>Jenis Kelamin: {{ $p->jeniskelamin }}</h2>
                <h2>Pekerjaan: {{ $p->pekerjaan }}</h2>
                <h2>Role: {{$p->role}}</h2>

                @if ($roleinfo->profilepg == 'editprof')
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#updateNakes"><i class="fa fa-user"></i> Ubah Profil</button>
                @endif

                @if ($roleinfo->profilepg == 'editpass')
                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#resetPassword"><i class="fa fa-lock"></i> Ubah Password</button>
                @endif

                @if ($roleinfo->profilepg != 'view')
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#updateNakes"><i class="fa fa-user"></i> Ubah Profil</button>
                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#resetPassword"><i class="fa fa-lock"></i> Ubah Password</button>
                @endif
            </div>
            
        </div>
    </div>
@endforeach

{{-- POP UP RESET PASSWORD --}}
<div class="modal fade" id="resetPassword" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">           
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Ubah Password</h5>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
            </div>
            <form action="/ubahSandi" method="post">
                @csrf
                <input type="hidden" name="user_id" value="{{ $infos->id }}">
                <div class="modal-body pl-4">
                    <div class="form-group row">
                        <label for="inputPassword1" class="col-sm-4 col-form-label">Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="inputPassword1" name="password" required>
                            <span id="eyebtn1" onclick="showpass1()" class="form-control-feedback right"><i class="fa fa-eye-slash"></i></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword2" class="col-sm-4 col-form-label">Password Baru</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="inputPassword2" name="new_password" required>
                            <span id="eyebtn2" onclick="showpass2()" class="form-control-feedback right"><i class="fa fa-eye-slash"></i></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-4 col-form-label" style="font-size: 11.5px;">Konfirmasi Password Baru</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="inputPassword3" name="confirm" required>
                            <span id="eyebtn3" onclick="showpass3()" class="form-control-feedback right"><i class="fa fa-eye-slash"></i></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Ubah Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- POP UP PROFILE --}}
@foreach ($profil as $up)
<div id="updateNakes" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Ubah Profile</h5>
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

                    @if ($up->idRole == $adminRoleId)
                        <label>Pekerjaan</label>
                        <select class="form-control" name="pekerjaan">
                            <option value="" selected>-- PILIH ROLE --</option>
                            @foreach ($pekerjaan as $p)
                                <option value="{{ $p->id }}" {{ $up->idPekerjaan == $p->id ? 'selected' : '' }}>{{ $p->pekerjaan }}</option>
                            @endforeach
                            {{-- <option value="ownerNakes" {{ $up->role == 'ownerNakes' ? 'selected' : '' }}>Owner & Tenaga Kesehatan</option> --}}
                        </select>
                    @else
                        <input type="hidden" class="form-control" name="pekerjaan" value="{{ $up->idPekerjaan }}" readonly>
                    @endif
                    
                </div>
                <div class="form-group row">
                    <input type="hidden" class="form-control" name="role" value="{{ $up->idRole }}" readonly>
                    
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
<script>

//FUNCTION SHOWPASSWORD
    //SHOW PASSWORD LAMA
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

    //SHOW PASSWORD BARU
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

    //SHOW PASSWORD CONFIRM
    function showpass3()
    {
        var x = document.getElementById('inputPassword3').type;
        if (x == 'password')
        {
        document.getElementById('inputPassword3').type = 'text';
        document.getElementById('eyebtn3').innerHTML = '<i class="fa fa-eye"></i>';
        }
        else
        {
            document.getElementById('inputPassword3').type = 'password';
            document.getElementById('eyebtn3').innerHTML = '<i class="fa fa-eye-slash"></i>';
        }
    }
</script>
@endpush