@extends('admin.templates.main')
@section('content')
    
<div class="row">
    <div class="col-md-12 col-sm-12">

        <div class="row justify-content-end">
            <div class="col-md-6">
                {{-- FILTER TANGGAL --}}
                <form class="form-horizontal form-label-left" action="{{route('pembayaran.search')}}" method="POST">
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
            <div class="x_content">                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            {{-- TABEL PEMBAYARAN  --}}
                            <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="10px">No</th>
                                        <th>Kode Transaksi</th>
                                        <th>Kode Pasien</th>
                                        <th>Nama Pasien</th>
                                        <th>Nama Tenaga Kesehatan</th>
                                        <th>Keluhan</th>
                                        <th>Tanggal</th>
                                        <th>Harga</th>
                                        <th>Status</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transaction as $tr)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $tr->kodeTransaction }}</td>
                                        <td>{{ $tr->kodepasien }}</td>
                                        <td>{{ $tr->namaPasien }}</td>
                                        <td>{{ $tr->namaNakes }}</td>
                                        <td>{{ $tr->keluhan }}</td>
                                        <td>{{ tgl_indo($tr->date) }}</td>
                                        <td>{{ 'Rp. '.number_format($tr->hargaTotal,0,',','.') }}</td>
                                        <td>{{ $tr->status }}</td>
                                        <td style="white-space: nowrap;">
                                            <a class="btn btn-info btn-sm detailP" data-toggle="modal" data-id="{{ $tr->id }}" title="Lihat Detail Pembayaran" href="#lihatData"><i class="fa fa-search"></i></a> 
                                            <a class="btn btn-primary btn-sm" title="Invoice Pembayaran" target="_blank" href="/pembayaran/invoice/{{ $tr->id }}"><i class="fa fa-download"></i></a> 
                                            @if ($roleinfo->paymentTranspg != 'view')
                                                @if ($tr->status == 'Paid')
                                                    @if ($roleinfo->paymentTranspg == 'delete')
                                                    @endif
                                                @else
                                                    <a class="btn btn-success btn-sm" title="Paid" href="/pembayaran/payment/{{ $tr->id }}"><i class="fa fa-money"></i></a> 
                                                @endif
                                                @if ($roleinfo->paymentTranspg == 'delete' || $tr->status == 'Unpaid')
                                                    <a onclick="return confirm('Anda yakin menghapus Data Pembayaran ini?');" href="/pembayaran/delete/{{ $tr->id }}" class="btn btn-danger btn-sm" title="Hapus Data Pembayaran"><i class="fa fa-trash"></i></a>
                                                @endif
                                                
                                            @endif
                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body" style="display: flex">
            <div style="width: 65%">
                {{-- DOWNLOAD EXCEL  --}}
                <a href="/downloadExcel/from{{ $tanggalfrom }}to{{ $tanggalto }}" class="btn btn-primary"><i class="fa fa-download"></i> Download Excel</a>
            </div>
            {{-- TOTAL PEMBAYARAN KESELURUHAN --}}
            <div style="width: 30%; text-align: right">
                <div 
                style="color: white; 
                background-color: #10B981; 
                padding: 8px; 
                width: fit-content;
                border-radius: 25px;
                font-size: 16px">
                    Total: Rp.{{number_format($sumPembayaran)}}
                </div>
            </div>
        </div>
    </div>

    {{-- POP UP DETAIL PEMBAYARAN (MEMANGGIL DETAIL.BLADE.PHP DENGAN JQUERY DIBAWAH) --}}
    <div id="lihatData" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Detail Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>                                
                <div class="modal-body" id="detailPembayaran">
                    
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>                    
                </div>                
            </div>
        </div>
    </div>



</div>

@endsection

@push('script')
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

{{-- FUNCTION DATATABLE  --}}
<script>
    jQuery(document).ready(function(){
        $('#datatable').DataTable({
            destroy: true,
            // fixedHeader: false,
            // scrollX: true,
            // scrollCollapse: true,
            // scrollY: 600,
            // "sScrollXInner": "110%",
            "initComplete": function (settings, json) {  
                $("#datatable").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
            },
        });
    });
    
</script>

{{-- FUNCTION MEMANGGIL DETAIL.BLADE.PHP UNTUK POP UP DETAIL PEMBAYARAN --}}
<script>
    jQuery(document).ready(function(){
        $('#datatable tbody').on('click', '.detailP', function(){
            var id = jQuery(this).attr('data-id');
            $.ajax({
                url:'/pembayaran/detail',
                type:'post',
                cache: true,
                data: {
                        'id': id,
                        '_token': '{{ csrf_token() }}'
                    },
                timeout:60000,
                dataType: 'html',
                success:function(html){
                    // alert(html);
                    jQuery('#detailPembayaran').html(html);            
                }
            })
        })    
    });
</script>
@endpush
