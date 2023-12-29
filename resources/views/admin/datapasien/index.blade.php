@extends('admin.templates.main')
@section('content')
    
<div class="row">
    <div class="col-md-12 col-sm-12">

        <div class="row justify-content-end">
            <div class="col-md-6">
                {{-- FILTER TANGGAL --}}
                <form class="form-horizontal form-label-left" action="{{route('datapasien.search')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row" style="margin: 5px">
                        <div class="col-md-5">
                            <label>From</label>
                            <input type="date" class="form-control form-control-sm" name="tanggalFrom" placeholder="dd/mm/yyyy" value="{{ $tanggalfrom }}" required>
                        </div>
                        <div class="col-md-5">
                            <label>To</label>
                            <input type="date" class="form-control form-control-sm" name="tanggalTo" placeholder="dd/mm/yyyy" value="{{ $tanggalto }}" required>
                        </div>
                        <div class="col-md-2 pt-4">
                            <button style="margin-top: 10px" type="submit" name="search" value="cari" class="btn btn-block btn-primary btn-sm"><i class="fa fa-search"></i> Cari</button>
                        </div>
                    </div>
                </form>
            </div>    
        </div>

        <div class="x_panel">
            <div class="x_title">
                @if ($roleinfo->pasienTranspg != 'view')
                    {{-- TOMBOL ADD DATA PASIEN --}}
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addPasien"><i class="fa fa-plus-circle"></i>  Transaksi Pasien</button>
                @endif
            </div>
            <div class="x_content">                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            {{-- TABEL DATA PASIEN  --}}
                            <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="10px">No</th>
                                        <th>Kode Pasien</th>
                                        <th>Kode Registrasi</th>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Umur</th>
                                        <th>Keluhan</th>
                                        <th>BB (Kg)</th>
                                        <th>Tensi</th>
                                        <th>Suhu (C)</th>
                                        <th>Heart Rate (bpm)</th>
                                        <th>Respiratory Rate</th>
                                        <th>Saturasi Oksigen (%)</th>
                                        <th>Tanggal Berobat</th>
                                        @if ($roleinfo->pasienTranspg != 'view' || $roleinfo->paymentTranspg != 'view')
                                            <th>Opsi</th>
                                        @endif
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datapasien as $dp)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $dp->kodepasien }}</td>
                                        <td>{{ $dp->koderegistrasi }}</td>
                                        <td>{{ $dp->namapasien }}</td>
                                        <td>{{ $dp->jeniskelamin }}</td>
                                        <td>{{\Carbon\Carbon::parse($dp->tgllahir)->age}} TAHUN</td>
                                        <td>{{ $dp->keluhan }}</td>
                                        <td>
                                            @if ($dp->berat == null)
                                                -
                                            @else
                                                {{ $dp->berat }} Kg
                                            @endif
                                        </td>
                                        <td>
                                            @if ($dp->tensi == null)
                                                -
                                            @else
                                                {{ $dp->tensi }}
                                            @endif
                                            
                                        </td>
                                        <td>
                                            @if ($dp->suhu == null)
                                                -
                                            @else
                                                {{ $dp->suhu }} C
                                            @endif
                                            
                                        </td>
                                        <td>
                                            @if ($dp->heartRate == null)
                                                -
                                            @else
                                                {{ $dp->heartRate }} bpm
                                            @endif
                                        </td>
                                        <td>
                                            @if ($dp->resRate == null)
                                                -
                                            @else
                                                {{ $dp->resRate }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($dp->saturasiOx == null)
                                                -
                                            @else
                                                {{ $dp->saturasiOx }} %
                                            @endif
                                        </td>
                                        <td>
                                            {{ strtoupper(tgl_indo($dp->date)) }}
                                        </td>
                                        @if ($roleinfo->pasienTranspg != 'view' || $roleinfo->paymentTranspg != 'view')
                                            <td style="white-space: nowrap;">
                                                @if ($roleinfo->paymentTranspg != 'view')
                                                    @if ($dp->transId == null)
                                                        <a class="btn btn-primary btn-sm" title="Input Tindakan Dan Obat" href="/datapasien/inputtindakanobat/{{ $dp->id }}"><i class="fa fa-medkit"></i></a>
                                                    @endif                                                    
                                                @endif
                                                 @if ($roleinfo->pasienTranspg != 'view')
                                                    <a class="btn btn-success btn-sm" data-toggle="modal" title="Update Transaction Pasien" href="#updatePasien{{ $dp->id }}"><i class="fa fa-edit"></i></a> 
                                                    @if ($roleinfo->pasienTranspg == 'delete')
                                                        <a onclick="return confirm('Anda yakin menghapus Data Pasien ini?');" href="/datapasien/delete/{{ $dp->id }}" class="btn btn-danger btn-sm" title="Hapus Data Pasien"><i class="fa fa-trash"></i></a>
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

    {{-- POP UP ADD PASIEN  --}}
    <div id="addPasien" class="modal fade" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i> Transaction Pasien</h5>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal form-label-left" action="{{route('datapasien.add')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form_wizard wizard_horizontal wiz">
                        <ul class="wizard_steps" hidden>
                          <li>
                            <a href="#step-1"></a>
                          </li>
                          <li>
                            <a href="#step-2"></a>
                          </li>
                          <li>
                            <a href="#step-3"></a>
                          </li>
                          
                        </ul>                        
                        <div id="step-1">
                            
                            <div class="form-group row">
                                <label>Nama</label>
                                <select class="js-example-basic-single form-control" data-width="100%" id="pasiensearch" name="pasiens">
                                    <option value="">-- PILIH PASIEN --</option>
                                    @foreach($pasien as $ps)
                                        <option value="{{ $ps->id }}">{{ $ps->nama }} - {{ $ps->koderegistrasi }}</option>
                                    @endforeach
                                </select>
                                @error("pasiens")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label>Jenis Kelamin</label>
                                <input type="text" class="form-control" id="jeniskelamin" name="jeniskelamin" disabled />
                            </div>
                            <div class="form-group row">
                                <label>Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" disabled />
                            </div>
                            <div class="form-group row">
                                <label>Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tgllahir" name="tgllahir" disabled />
                            </div>
                            <div class="form-group row">
                                <label>No. BPJS</label>
                                <input type="text" class="form-control" id="bpjs" name="bpjs" disabled />
                            </div>
  
                        </div>
                        <div id="step-2">
                            <div class="form-group row">
                                <label>Keluhan</label>
                                <textarea class="form-control" @error('keluhan') is-invalid @enderror style="text-transform: uppercase" rows="14" name="keluhan" placeholder="Isi Keluhan Pasien"></textarea>
                                @error("keluhan")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div id="step-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label>Berat Badan (Kg)</label>
                                        <input type="number" class="form-control" id="berat" name="berat" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label>Tensi (ex: 120/80)</label>
                                        <input type="text" class="form-control" id="tensi" name="tensi" />
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label>Temperature (Celcius)</label>
                                        <input type="number" class="form-control" id="suhu" name="suhu" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label>Heart Rate (ex: 100-170)(bpm)</label>
                                        <input type="text" class="form-control" id="hrate" name="hrate" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label>Respiratory Rate (ex: 30 - 40)</label>
                                        <input type="text" class="form-control" id="resrate" name="resrate" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label>Saturasi Oksigen (Oximeter, ex: 95-100)(%)</label>
                                        <input type="text" class="form-control" id="satox" name="satox" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- POP UP UPDATE DATA PASIEN  --}}
    @foreach ($datapasien as $up)
    <div id="updatePasien{{$up->id}}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"><i class="fa fa-pencil"></i> Transaksi Pasien</h5>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal form-label-left" action="{{route('datapasien.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" name="id" value="{{ $up->id }}" readonly>
                <div class="modal-body">
                    <div class="form_wizard wizard_horizontal wiz">
                        <ul class="wizard_steps" hidden>
                          <li>
                            <a href="#step-1"></a>
                          </li>
                          <li>
                            <a href="#step-2"></a>
                          </li>
                          
                        </ul>                        
                        
                        <div id="step-1">
                            <div class="form-group row">
                                <label>Keluhan</label>
                                <textarea class="form-control" @error('keluhan') is-invalid @enderror style="text-transform: uppercase" rows="14" name="keluhan" placeholder="Isi Keluhan Pasien">{{$up->keluhan}}</textarea>
                                @error("keluhan")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div id="step-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label>Berat Badan (Kg)</label>
                                        <input type="number" class="form-control" id="berat" name="berat" value="{{$up->berat}}" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label>Tensi (ex: 120/80)</label>
                                        <input type="text" class="form-control" id="tensi" name="tensi" value="{{$up->tensi}}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label>Temperature (Celcius)</label>
                                        <input type="number" class="form-control" id="suhu" name="suhu" value="{{$up->suhu}}" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label>Heart Rate (ex: 100-170)(bpm)</label>
                                        <input type="text" class="form-control" id="hrate" name="hrate" value="{{$up->heartRate}}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label>Respiratory Rate (ex: 30 - 40)</label>
                                        <input type="text" class="form-control" id="resrate" name="resrate" value="{{$up->resRate}}" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label>Saturasi Oksigen (Oximeter, ex: 95-100)(%)</label>
                                        <input type="text" class="form-control" id="satox" name="satox" value="{{$up->saturasiOx}}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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

{{-- FUNCTION FIX BUG TABLE --}}
<script>
    jQuery(document).ready(function(){
        $('#datatable').DataTable({
            destroy: true,
            "initComplete": function (settings, json) {  
                $("#datatable").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
            },
        });
    });
    
</script>

{{-- FUNCTION SELECT2 (UNTUK DROP DOWN SELECT SEARCH) --}}
<script>
    jQuery(document).ready(function(){
        $('.js-example-basic-single').select2();
    });
</script>

{{-- AUTO INPUT DATA-DATA PASIEN SETELAH PILIH PASIEN DI DROP DOWN INPUT PASIEN --}}
<script>
    jQuery(document).ready(function(){
    jQuery('#pasiensearch').change(function(){
        let pasiens=jQuery(this).val();
        jQuery.ajax({
            url:'/getPasien',
            type:'post',
            data:'pasiens='+pasiens+'&_token={{ csrf_token() }}',
            success:function(result){            
                jQuery('#koderegistrasi').val(result.koderegistrasi);
                jQuery('#alamat').val(result.alamat);
                jQuery('#tgllahir').val(result.tgllahir);
                jQuery('#jeniskelamin').val(result.jeniskelamin);
                jQuery('#bpjs').val(result.bpjs);
            }
        })
    })
    });
</script>

{{-- TIDAK TERPAKAI  --}}
<script type="text/javascript">
    jQuery(document).ready(function(){

        var x = 1;
        jQuery("#add_obat").click(function(){
            x++;
            // alert(x);
            jQuery("#inputObat").append(
                '<tr>'+
                    '<td style="width: 50%; padding-right: 20px; padding-bottom: 10px">'+
                        '<select class="form-control obtsel obat" id="obatcari'+x+'" name="obat[]" data-stock="stock'+x+'">'+
                            '<option value="">None</option>'+
                            '@foreach($obat as $ob)'+
                                '<option value="{{ $ob->id }}" data-stk="{{$ob->stock}}">{{ $ob->obat }}</option>'+
                            '@endforeach'+
                        '</select>'+
                    '</td>'+
                    '<td style="width: 20%; padding-right: 20px; padding-bottom: 10px">'+
                        '<input type="number" class="form-control" id="stock'+x+'" disabled />'+
                    '</td>'+
                    '<td style="width: 15%; padding-right: 20px; padding-bottom: 10px">'+
                        '<input type="number" class="form-control" id="quantity" min="0" name="quantity[]" />'+
                    '</td>'+
                    '<td>'+
                        '<button type="button" class="btn btn-outline-danger remove_obat">x</button>'+
                    '</td>'+
                '</tr>'
            );
        })
        
        $("#inputObat").on('change', '.obat', function(){
            var $select = $(this)
            var $stock = $('#'+$select.attr('id')+' option:selected').data('stk')
            // alert($stock);
            if($select.val() == ""){
                $('#'+$select.data('stock')).val("");
            }
            else{
                // alert('#'+$select.data('stock'));
                $('#'+$select.data('stock')).val($stock);
            }
        });

        $("#inputObat").on('click', '.remove_obat', function(){
            $(this).parents('tr').remove();
        });
    });
</script>

{{-- TIDAK TERPAKAI --}}
<script>
    const add = document.querySelectorAll(".add_tindakan")
    add.forEach(function(e){
        e.addEventListener('click',function(){
            let element = this.parentElement            
            let newElement = document.createElement('div')
                newElement.classList.add('input-group')
                newElement.innerHTML = '<select class="form-control" id="tindakan" name="tindakan[]"><option value="">None</option>@foreach($tindakan as $td)<option value="{{ $td->id }}">{{ $td->tindakan }}</option>@endforeach</select><button type="button" class="btn btn-outline-danger remove_tindakan">Hapus</button>'
            document.getElementById('extra_tindakan').appendChild(newElement)

            $(".remove_tindakan").click(function(event) {
                event.preventDefault();
                $(this).parents('.input-group').remove();
            });
        })
    })
</script>

{{-- FIX URUTAN TOMBOL DI POP UP INPUT DATAPASIEN --}}
<script>
    $(function() {
        $('.wiz').smartWizard();

        // $('.wiz2').smartWizard();

        $('.buttonNext').addClass('btn btn-success');
        $('.buttonPrevious').addClass('btn btn-primary');
        $('.buttonFinish').addClass('btn btn-warning');
    });
</script>
@endpush