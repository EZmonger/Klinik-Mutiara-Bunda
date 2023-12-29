<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>{{ $title }}</title>  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.4/dist/bootstrap-table.min.css">

  <style>@page { size: A4 }</style>
</head>
<body class="A4" style="font-family: Arial, Helvetica, sans-serif">
  <section class="sheet padding-10mm">
    
    <h2 style="text-align: center; margin-bottom: 0;">{{ $title }}</h2>
    <h2 style="text-align: center; margin-bottom: 0;">{{ $title2 }}</h2>
    <h5 style="text-align: center; margin-bottom: 0; margin-top: 5px;">{{ $alamat }}</h5>
    <h5 style="text-align: center; margin-top: 5px;">{{ $kabkota }}</h5>
    
    <hr style="height:4px;border-width:0;color:gray;background-color:gray">

    <h5 style="text-align: right;">Tanggal: {{ tgl_indo($transaction->date) }}</h5>
    <h5 style="text-align: right;">Invoice: {{ $transaction->kodeTransaction }}</h5>
    <h5 style="text-align: right;">Tenaga Kesehatan: {{ $transaction->namaNakes }}</h5>
    
    <h5 style="text-align: left;">{{ $transaction->kodepasien }}</h5>
    <h5 style="text-align: left;">{{ $transaction->namaPasien }}</h5>
    <h5 style="text-align: left;">Keluhan: {{ $transaction->keluhan }}</h5>

    <table class="table table-striped mt-4" style="width:100%;">
      <thead>
        <tr>                                      
          <th class="text-center">Kode Produk</th>
          <th class="text-center">Nama Produk</th>
          <th class="text-center">Obat/Tindakan</th>
          <th class="text-center">Harga</th>
          <th class="text-center">Qty</th>
          <th class="text-center">Harga Subtotal</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($transDetail as $td)
            @if ($td->idTindakan != null)
                <tr>
                  <td class="text-center">{{$td->kodetindakan}}</td>
                  <td>{{$td->tindakan}}</td>
                  <td class="text-center">Tindakan</td>
                  <td class="text-center">{{$td->hargaTindakan}}</td>
                  <td class="text-center">{{$td->quantity}}</td>
                  <td class="text-center">{{ 'Rp.'.number_format($td->hargaSubtotal,0,',','.') }}</td>
                </tr>
            @else
                <tr>
                  <td class="text-center">{{$td->kodeobat}}</td>
                  <td>{{$td->obat}}</td>
                  <td class="text-center">Obat</td>
                  <td class="text-center">{{$td->hargaObat}}</td>
                  <td class="text-center">{{$td->quantity}}</td>
                  <td class="text-center">{{ 'Rp.'.number_format($td->hargaSubtotal,0,',','.') }}</td>
                </tr>
            @endif
        @empty
            <tr>
              <td colspan="7">Tidak Ada Data</td>
            </tr>
        @endforelse
        

        <tr>
          <td colspan="5" class="text-center">Total</td>
          <td class="text-center">{{ 'Rp.'.number_format($transTotal,0,',','.') }}</td>
        </tr>

      </tbody>

    </table>

    <div class="mt-5">&nbsp;</div>

    <h5 class="mt-3" style="text-align: left;">Keterangan</h5>
    <h5 style="text-align: left;">Lakukan pembayaran ke nomor rekening:</h5>
    <h5 style="text-align: left;">{{ $rekening }}</h5>
    <h5 style="text-align: left;">{{ $an_rekening }}</h5>
    
  </section>


  <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/bootstrap-table@1.21.4/dist/bootstrap-table.min.js"></script>
</body>
</html>