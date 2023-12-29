@extends('admin.templates.main')
@section('content')

{{-- HALAMAN INPUT TINDAKAN OBAT --}}
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <a class="btn btn-danger btn-sm" href="/datapasien" style="color: #fff"><i class="fa fa-chevron-left"></i> Back</a>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box">
                        <form action="/datapasien/addtindakanobat" method="post">
                            @csrf
                            <input type="hidden" class="form-control" name="id" value="{{ $id }}" readonly>
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
                                        <div class="col-md-12">
                                            <table id="inputTindakan">
                                                <tr>
                                                    <th style="font-weight: normal; padding-bottom: 10px">Tindaan</th>
                                                    <th style="font-weight: normal; padding-bottom: 10px">Quantity</th>
                                                    <th></th>
                                                </tr>
                                                <tr>
                                                    <td style="width: 70%; padding-right: 20px; padding-bottom: 10px">
                                                        <select class="js-example-basic-single form-control obtsel" data-width="100%" id="tindakancari1" name="tindakan[]">
                                                            <option value="">None</option>
                                                            @foreach($tindakan as $td)
                                                                <option value="{{ $td->id }}">{{ $td->tindakan }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td style="width: 15%; padding-right: 20px; padding-bottom: 10px">
                                                        <input type="number" class="form-control" id="quantity" min="0" name="quantityTindakan[]" />
                                                    </td>
                                                    <td>
                                                        
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <button type="button" id="add_tindakan" style="float: right;" class="btn btn-default btn-sm mb-1">Tambah Tindakan <i class="fa fa-plus"></i></button>
                                </div>
                                <div id="step-2">
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <table id="inputObat">
                                                <tr>
                                                    <th style="font-weight: normal; padding-bottom: 10px">Obat</th>
                                                    <th style="font-weight: normal; padding-bottom: 10px">Stock</th>
                                                    <th style="font-weight: normal; padding-bottom: 10px">Quantity</th>
                                                    <th></th>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%; padding-right: 20px; padding-bottom: 10px">
                                                        <select class="js-example-basic-single form-control obtsel obat" data-width="100%" id="obatcari1" name="obat[]" data-stock="stock1">
                                                            <option value="">None</option>
                                                            @foreach($obat as $ob)
                                                                <option value="{{ $ob->id }}" data-stk="{{$ob->stock}}">{{ $ob->obat }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td style="width: 20%; padding-right: 20px; padding-bottom: 10px">
                                                        <input type="" class="form-control" id="stock1" disabled />
                                                    </td>
                                                    <td style="width: 15%; padding-right: 20px; padding-bottom: 10px">
                                                        <input type="number" class="form-control" id="quantity" min="0" name="quantityObat[]" />
                                                    </td>
                                                    <td>
                                                        
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <button type="button" id="add_obat" style="float: right;" class="btn btn-default btn-sm mb-1">Tambah Obat <i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        
    </div>
</div>
@endsection

@push('script')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

{{-- FUNCTION INITIALIZE SELECT2 --}}
<script>
    jQuery(document).ready(function(){
        $('.js-example-basic-single').select2();
    });
</script>

{{-- FUNCTION ADD NEW ROW INPUT TINDAKAN --}}
<script>
    jQuery(document).ready(function(){
        var y = 1;
        // alert(y)
        jQuery("#add_tindakan").click(function(){
            y++;
            // alert(y);
            jQuery("#inputTindakan").append(
                '<tr>'+
                    '<td style="width: 70%; padding-right: 20px; padding-bottom: 10px">'+
                        '<select class="js-example-basic-single form-control obtsel" data-width="100%" id="tindakancari'+y+'" name="tindakan[]">'+
                            '<option value="">None</option>'+
                            '@foreach($tindakan as $td)'+
                                '<option value="{{ $td->id }}">{{ $td->tindakan }}</option>'+
                            '@endforeach'+
                        '</select>'+
                    '</td>'+
                    '<td style="width: 15%; padding-right: 20px; padding-bottom: 10px">'+
                        '<input type="number" class="form-control" id="quantity" min="0" name="quantityTindakan[]" />'+
                    '</td>'+
                    '<td>'+
                        '<button type="button" class="btn btn-outline-danger remove_tindakan">x</button>'+
                    '</td>'+
                '</tr>'
            );
            $('.js-example-basic-single').select2();
        })
        

        $("#inputTindakan").on('click', '.remove_tindakan', function(){
            $(this).parents('tr').remove();
        });
    });
</script>

{{-- FUNCTION ADD NEW ROW INPUT OBAT  --}}
<script type="text/javascript">
    jQuery(document).ready(function(){

        var x = 1;
        jQuery("#add_obat").click(function(){
            x++;
            // alert(x);
            jQuery("#inputObat").append(
                '<tr>'+
                    '<td style="width: 50%; padding-right: 20px; padding-bottom: 10px">'+
                        '<select class="js-example-basic-single form-control obtsel obat" id="obatcari'+x+'" name="obat[]" data-stock="stock'+x+'">'+
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
                        '<input type="number" class="form-control" id="quantity" min="0" name="quantityObat[]" />'+
                    '</td>'+
                    '<td>'+
                        '<button type="button" class="btn btn-outline-danger remove_obat">x</button>'+
                    '</td>'+
                '</tr>'
            );
            $('.js-example-basic-single').select2();
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