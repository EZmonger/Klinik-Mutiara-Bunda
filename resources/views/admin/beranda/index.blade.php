@extends('admin.templates.main')
@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="row">
            {{-- TOMBOL INPUT PASIEN --}}
            <div class="col-md-6">       
                @if ($roleinfo->pasienTranspg != 'view')
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addPasien"><i class="fa fa-plus-circle"></i> Transaksi Pasien</button>
                @endif         
                
            </div>
            {{-- FILTER TANGGAL --}}
            <div class="col-md-6">
                <form class="form-horizontal form-label-left" action="{{route('admin.berandasearch')}}" method="POST" enctype="multipart/form-data">
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
                        {{-- <label></label> --}}
                        <button style="margin-top: 10px" type="submit" name="search" value="cari" class="btn btn-block btn-primary btn-sm"><i class="fa fa-search"></i> Cari</button>
                    </div>
                </div>
                </form>
            </div>    
        </div>
    

    <div class="row pt-4">

        {{-- OBAT TERPAKAI --}}
        <div class="col-md-6 col-sm-3">
            <a href="#lihatObat" id="clickObat" data-datefrom="{{ $tanggalfrom }}" data-dateto="{{ $tanggalto }}" data-toggle="modal">
                <div class="card-body">
                    <div class="row no-gutters align-items-center" 
                    style="border: 1px solid #E4E4E4;
                    background: #fff; min-height: 120px; padding: 20px; border-radius: 15px">
                        <div class="col mr-2">
                            <h3 style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">Obat Terpakai</h3>
                        </div>
                        <div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" 
                            style="padding-right: 20px; font-size: 30px">{{$obatterpakai}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-medkit green fa-2x text-gray-300" style="font-size: 40px"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- TINDAKAN TERPAKAI --}}
        <div class="col-md-6 col-sm-3">
            <a href="#lihatTindakan" id="clickTindakan" data-datefrom="{{ $tanggalfrom }}" data-dateto="{{ $tanggalto }}" data-toggle="modal">
                <div class="card-body">
                    <div class="row no-gutters align-items-center" 
                    style="border: 1px solid #E4E4E4;
                    background: #fff; min-height: 120px; padding: 20px; border-radius: 15px">
                        <div class="col mr-2">
                            <h3 style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">Tindakan</h3>
                        </div>
                        <div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" 
                            style="padding-right: 20px; font-size: 30px">{{$tindakannum}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-tags green fa-2x text-gray-300" style="font-size: 40px"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- TOTAL PASIEN, IF ELSE UNTUK FILTER ROLE --}}
        <div class="col-md-6 col-sm-3">
            @if ($roleinfo->pasienTranspg != 'none')
            <a href="/datapasien/from{{$tanggalfrom}}to{{$tanggalto}}">
                <div class="card-body">
                    <div class="row no-gutters align-items-center" 
                    style="border: 1px solid #E4E4E4;
                    background: #fff; min-height: 120px; padding: 20px; border-radius: 15px">
                        <div class="col mr-2">
                            <h3 style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">Total Pasien</h3>
                        </div>
                        <div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" 
                            style="padding-right: 20px; font-size: 30px">{{$pasiennum}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-users green fa-2x text-gray-300" style="font-size: 40px"></i>
                        </div>
                    </div>
                </div>
            </a>
            @else
            <div class="card-body">
                <div class="row no-gutters align-items-center" 
                style="border: 1px solid #E4E4E4;
                background: #fff; min-height: 120px; padding: 20px; border-radius: 15px">
                    <div class="col mr-2">
                        <h3 style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">Total Pasien</h3>
                    </div>
                    <div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" 
                        style="padding-right: 20px; font-size: 30px">{{$pasiennum}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa fa-users green fa-2x text-gray-300" style="font-size: 40px"></i>
                    </div>
                </div>
            </div>
            @endif
            
        </div>


        {{-- TOTAL PEMBAYARAN, IF ELSE UNTUK FILTER ROLE --}}
        <div class="col-md-6 col-sm-3">
            @if ($roleinfo->paymentTranspg != 'none')
            <a href="/pembayaran/from{{ $tanggalfrom }}to{{$tanggalto}}" >
                <div class="card-body">
                    <div class="row no-gutters align-items-center" 
                    style="border: 1px solid #E4E4E4;
                    background: #fff; min-height: 120px; padding: 20px; border-radius: 15px">
                        <div class="col mr-2">
                            <h3 style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">Total Pendapatan</h3>
                        </div>
                        <div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" 
                            style="padding-right: 20px; font-size: 30px">{{ 'Rp. '.number_format($pendapatan,0,',','.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-database green fa-2x text-gray-300" style="font-size: 40px"></i>
                        </div>
                    </div>
                </div>
            </a>
            @else
            <div class="card-body">
                <div class="row no-gutters align-items-center" 
                style="border: 1px solid #E4E4E4;
                background: #fff; min-height: 120px; padding: 20px; border-radius: 15px">
                    <div class="col mr-2">
                        <h3 style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">Total Pendapatan</h3>
                    </div>
                    <div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" 
                        style="padding-right: 20px; font-size: 30px">{{ 'Rp. '.number_format($pendapatan,0,',','.') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa fa-database green fa-2x text-gray-300" style="font-size: 40px"></i>
                    </div>
                </div>
            </div>
            @endif
            
        </div>

    </div>

    </div>
</div>

{{-- POP UP ADD DATA PASIEN --}}
<div id="addPasien" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i> Transaksi Pasien</h5>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
            </div>
            {{-- FORM INPUT DATA PASIEN --}}
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
                        {{-- HALAMAN 1 --}}
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
                        {{-- <div class="form-group row">
                            <label>Kode Pasien</label>
                            <input type="hidden" class="form-control" id="koderegistrasi" name="koderegistrasi" readonly />
                        </div> --}}
                        <div class="form-group row">
                            <label>Jenis Kelamin</label>
                            <input type="text" class="form-control" id="jeniskelamin" name="jeniskelamin" readonly />
                        </div>
                        <div class="form-group row">
                            <label>Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" readonly />
                        </div>
                        <div class="form-group row">
                            <label>Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tgllahir" name="tgllahir" readonly />
                        </div>
                        <div class="form-group row">
                            <label>No. BPJS</label>
                            <input type="text" class="form-control" id="bpjs" name="bpjs" readonly />
                        </div>
                    </div>
                    <div id="step-2">
                        {{-- HALAMAN 2 --}}
                        <div class="form-group row">
                            <label>Keluhan</label>
                            <textarea class="form-control" @error('keluhan') is-invalid @enderror style="text-transform: uppercase" rows="14" name="keluhan" placeholder="Isi Keluhan Pasien"></textarea>
                            @error("keluhan")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        
                    </div>
                    <div id="step-3">
                        {{-- HALAMAN 3 --}}
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

{{-- POP UP TINDAKAN TERPAKAI --}}
<div id="lihatTindakan" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Tindakan</h5>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
            </div>                                
            <div class="modal-body" id="detailTindakan">
                
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>                    
            </div>                
        </div>
    </div>
</div>

{{-- POP UP OBAT TERPAKAI --}}
<div id="lihatObat" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Obat Terpakai</h5>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
            </div>                                
            <div class="modal-body" id="detailObat">
                
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>                    
            </div>                
        </div>
    </div>
</div>

@endsection

@push('script')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    // INITIALIZE SELECT2 UNTUK DROPDOWN SEARCH
    jQuery(document).ready(function(){
        $('.js-example-basic-single').select2({
            // dropdownParent: $('#addPasien');
        });
    });
</script>

{{-- AMBIL DATA UNTUK POP UP TINDAKAN TERPAKAI DAN OBAT TERPAKAI --}}
<script>
    jQuery(document).ready(function(){
        // UNTUK TINDAKAN TERPAKAI
        $('#clickTindakan').on('click', function(){
            var tanggalfrom = jQuery(this).attr('data-datefrom');
            var tanggalto = jQuery(this).attr('data-dateto');
            // alert(jQuery(this).attr('data-date'));
            $.ajax({
                url:'/index/tindakan',
                type:'post',
                cache: true,
                data: {
                        'tanggalfrom': tanggalfrom,
                        'tanggalto': tanggalto,
                        '_token': '{{ csrf_token() }}'
                    },
                timeout:60000,
                dataType: 'html',
                success:function(html){
                    // alert(html);
                    jQuery('#detailTindakan').html(html);            
                }
            })
        })
        //UNTUK OBAT TERPAKAI
        $('#clickObat').on('click', function(){
            var tanggalfrom = jQuery(this).attr('data-datefrom');
            var tanggalto = jQuery(this).attr('data-dateto');
            $.ajax({
                url:'/index/obat',
                type:'post',
                cache: true,
                data: {
                        'tanggalfrom': tanggalfrom,
                        'tanggalto': tanggalto,
                        '_token': '{{ csrf_token() }}'
                    },
                timeout:60000,
                dataType: 'html',
                success:function(html){
                    // alert(html);
                    jQuery('#detailObat').html(html);            
                }
            })
        })
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

{{-- TIDAK TERPAKAI --}}
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