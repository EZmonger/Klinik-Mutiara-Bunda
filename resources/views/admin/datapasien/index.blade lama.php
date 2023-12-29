@extends('owner.templates.main')
@section('content')
    
<div class="row">

    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addPasien"><i class="fa fa-plus-circle"></i> Tambah Data</button>
            </div>
            <div class="x_content">                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="10px">No</th>
                                        <th>Kode Pasien</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Umur</th>
                                        <th>BB (Kg)</th>
                                        <th>Tensi</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datapasien as $dp)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $dp->kodepasien }}</td>
                                        <td>{{ $ps->nama }}</td>
                                        <td>{{ $ps->alamat }}</td>
                                        <td>{{ tgl_indo($ps->tgllahir) }}</td>                                    
                                        <td>{{ $ps->umur }} tahun</td>
                                        <td>{{ $ps->berat }} Kg</td>
                                        <td>{{ $ps->tensi }}</td>
                                        <td style="white-space: nowrap;"><a class="btn btn-success btn-sm" data-toggle="modal" title="Ubah Data Pasien" href="#updatePasiens{{ $ps->id }}"><i class="fa fa-edit"></i></a> <a onclick="return confirm('Anda yakin menghapus Data Pasien ini?');" href="/deletePasiens/{{ $ps->id }}" class="btn btn-danger btn-sm" title="Hapus Data Pasien"><i class="fa fa-trash"></i></a></td>
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

    <div id="addPasien" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Tambah Data Pasien</h5>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <form id="form" class="form-horizontal form-label-left" action="/addDataps" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    
                    <div id="wizard" class="form_wizard wizard_horizontal">
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
                          <li>
                            <a href="#step-4"></a>
                          </li>
                        </ul>                        
                        <div id="step-1">                                                    

                            <div class="form-group row">
                                <label>Nama</label>
                                <select class="form-control" id="pasiensearch" name="pasiens">
                                    <option value="">-- Pilih Pasien --</option>
                                    @foreach($pasien as $ps)
                                        <option value="{{ $ps->id }}">{{ $ps->nama }} - {{ $ps->kodepasien }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group row">
                                <label>Kode Pasien</label>
                                <input type="text" class="form-control" id="kodepasien" name="kodepasien" readonly />
                            </div>
                            <div class="form-group row">
                                <label>Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" readonly />
                            </div>
                            <div class="form-group row">
                                <label>Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tgllahir" name="tgllahir" readonly />
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label>Berat Badan (Kg)</label>
                                        <input type="text" class="form-control" id="berat" name="berat" readonly />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label>Tensi (ex: 120/80)</label>
                                        <input type="text" class="form-control" id="tensi" name="tensi" readonly />
                                    </div>
                                </div>
                            </div>
  
                        </div>
                        <div id="step-2">
                            <div class="form-group row">
                                <label>Keluhan</label>
                                <textarea class="form-control" rows="14" name="keluhan" placeholder="Isi Keluhan Pasien"></textarea>
                            </div>
                        </div>
                        <div id="step-3">                            
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label>Tindakan</label>
                                    <div class="input-group" id="form">
                                        <select class="form-control" id="tindakan" name="tindakan[]">
                                            <option value="">None</option>
                                            @foreach($tindakan as $td)
                                                <option value="{{ $td->id }}">{{ $td->tindakan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="extra_tindakan"></div>
                                </div>
                            </div>

                            <button type="button" style="float: right;" class="btn btn-default btn-sm mb-1 add_tindakan">Tambah Tindakan <i class="fa fa-plus"></i></button>
                        </div>
                        <div id="step-4">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group" id="divobat">
                                        <div class="col-md-5">
                                            <div class="form-group row">
                                                <label>Obat</label>
                                                <select class="form-control obtsel" id="obatsearch_1" name="obat[]">
                                                    <option value="">None</option>
                                                    @foreach($obat as $ob)
                                                        <option value="{{ $ob->id }}">{{ $ob->obat }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group row">
                                                <label>Stock</label>
                                                <input type="text" class="form-control" id="stock_1" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group row">
                                                <label>Satuan</label>
                                                <input type="text" class="form-control" id="satuan_1" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group row">
                                                <label>Quantity</label>
                                                <input type="number" class="form-control" id="quantity" name="quantity[]" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div id="extra_obat"></div>
                                </div>
                            </div>

                            <button type="button" style="float: right;" class="btn btn-default btn-sm mb-1 add_obat">Tambah Obat <i class="fa fa-plus"></i></button>

                        </div>                    
  
                      </div>


                </div>
                </form>
            </div>
        </div>
    </div>



</div>

@endsection

@push('script')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    jQuery(document).ready(function(){
    jQuery('#pasiensearch').change(function(){
        let pasiens=jQuery(this).val();
        jQuery.ajax({
            url:'/getPasien',
            type:'post',
            data:'pasiens='+pasiens+'&_token={{ csrf_token() }}',
            success:function(result){            
                jQuery('#kodepasien').val(result.kodepasien);
                jQuery('#alamat').val(result.alamat);
                jQuery('#tgllahir').val(result.tgllahir);
                jQuery('#berat').val(result.berat);
                jQuery('#tensi').val(result.tensi);
            }
        })
    })
    });
</script>

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#obatsearch_1').change(function(){
        let obats=jQuery(this).val();
        jQuery.ajax({
            url:'/getObat1',
            type:'post',
            cache: true,
            data: {
                    'obats': obats,
                    '_token': '{{ csrf_token() }}'
                },
            success:function(result){            
                jQuery('#stock_1').val(result.stock);
                jQuery('#satuan_1').val(result.satuan);                
            }
        })
        })    
    });
</script>

{{-- <script>    
    const obt = document.querySelectorAll(".obtsel")
    obt.forEach(function(e){
        e.addEventListener('change',function(){            
            let obats=jQuery(this).val();
            jQuery.ajax({
            url:'/getObat',
            type:'post',
            data: {
                    'obats': obats,
                    '_token': '{{ csrf_token() }}'
                },
            success:function(result){            
                jQuery('#stock_1').val(result.stock);
                jQuery('#satuan_1').val(result.satuan);                
            }
        })
        })
    })
</script> --}}

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

<script>
    var countre=1;
    const addobt = document.querySelectorAll(".add_obat")
        addobt.forEach(function(e){
            e.addEventListener('click',function(){
            countre+=1
            let element = this.parentElement            
            let newElement = document.createElement('div')
                newElement.classList.add('input-group')
                newElement.innerHTML = '<div class="col-md-5">\
                            <div class="form-group row">\
                                <select class="form-control obtsel" id="obatsearch_'+countre+'" name="obat[]">\
                                    <option value="">None</option>\
                                    @foreach($obat as $ob)\
                                        <option value="{{ $ob->id }}">{{ $ob->obat }}</option>\
                                    @endforeach\
                                </select>\
                            </div>\
                        </div>\
                        <div class="col-md-2">\
                            <div class="form-group row">\
                                <input type="text" class="form-control" id="stock_'+countre+'" readonly />\
                            </div>\
                        </div>\
                        <div class="col-md-2">\
                            <div class="form-group row">\
                                <input type="text" class="form-control" id="satuan_'+countre+'" readonly />\
                            </div>\
                        </div>\
                        <div class="col-md-2">\
                            <div class="form-group row">\
                                <input type="number" class="form-control" id="quantity_'+countre+'" name="quantity[]" required />\
                            </div>\
                        </div>\
                        <div class="col-md-1">\
                            <button type="button" class="btn btn-danger remove_obat">x</button>\
                        </div>'
                    document.getElementById('extra_obat').appendChild(newElement)                                        

                    $(".remove_obat").click(function(event) {
                        event.preventDefault();
                        $(this).parents('.input-group').remove();
                    });

                })
            })        
</script>

@endpush