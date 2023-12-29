@extends('admin.templates.main')
@section('content')
    
<div class="row">
    <div class="col-md-12 col-sm-12">

        <div class="row justify-content-end">
            <div class="col-md-6" style="margin-top: 30px">
                <a class="btn btn-danger btn-sm" href="/pasien" style="color: #fff"><i class="fa fa-chevron-left"></i> Back</a>
            </div>
            <div class="col-md-6">
                <form class="form-horizontal form-label-left" action="/pasien/rekamanmedisadm/{{ $idpasien}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- <input type="hidden" class="form-control" name="idpasien" value="{{ $idpasien }}" readonly> --}}
                    <div class="row" style="margin: 5px">
                        <div class="col-md-5">
                            <label>From</label>
                            <input type="date" class="form-control form-control-sm" name="tanggalFrom" placeholder="dd/mm/yyyy" value="{{ $fromDate }}">
                        </div>
                        <div class="col-md-5">
                            <label>To</label>
                            <input type="date" class="form-control form-control-sm" name="tanggalTo" placeholder="dd/mm/yyyy" value="{{ $toDate }}">
                        </div>
                        <div class="col-md-2 pt-4">
                            {{-- <label></label> --}}
                            <button style="margin-top: 10px" type="submit" name="search" value="cari" class="btn btn-block btn-primary btn-sm"><i class="fa fa-search"></i> Cari</button>
                        </div>
                    </div>
                </form>
            </div>    
        </div>

        <div class="x_panel">
            {{-- <div class="x_title">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addPasien"><i class="fa fa-plus-circle"></i> Tambah Data</button>
            </div> --}}
            <div class="x_content">                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="10px">No</th>
                                        <th>Kode Pasien</th>
                                        <th>Kode Transaksi</th>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Umur</th>
                                        <th>Nama Tenaga Kesehatan</th>
                                        <th>Keluhan</th>
                                        <th>BB (Kg)</th>
                                        <th>Tensi</th>
                                        <th>Suhu (C)</th>
                                        <th>Heart Rate (bpm)</th>
                                        <th>Respiratory Rate</th>
                                        <th>Saturasi Oksigen (%)</th>
                                        <th>Tanggal Berobat</th>
                                        <th>Harga Total</th>
                                        <th>Status</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datapasien as $dp)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $dp->kodepasien }}</td>
                                        <td>{{ $dp->kodeTransaction }}</td>
                                        <td>{{ $dp->namapasien }}</td>
                                        <td>{{ $dp->jeniskelamin }}</td>
                                        <td>{{\Carbon\Carbon::parse($dp->tgllahir)->age}} tahun</td>
                                        <td>{{ $dp->namanakes }}</td>
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
                                            {{ tgl_indo($dp->date) }}
                                        </td>
                                        <td>
                                            {{ 'Rp. '.number_format($dp->hargaTotal,0,',','.') }}
                                        </td>
                                        <td>
                                            {{ $dp->status }}
                                        </td>
                                        <td style="white-space: nowrap;">
                                            @if ($dp->transHId != NULL)
                                                <a class="btn btn-info btn-sm detailP" data-toggle="modal" data-id="{{ $dp->transHId }}" title="Lihat Detail Pembayaran" href="#lihatData"><i class="fa fa-search"></i></a> 
                                                @if ($dp->status == 'Paid')
                                                    <a class="btn btn-primary btn-sm" title="Invoice Pembayaran" target="_blank" href="/pembayaran/invoice/{{ $dp->transHId }}"><i class="fa fa-download"></i></a>
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
    </div>

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

<script>
    jQuery(document).ready(function(){
        $('#datatable tbody').on('click', '.detailP', function(){
            var id = jQuery(this).attr('data-id');
            // jQuery(this).attr('data-id');
            // alert(id);
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