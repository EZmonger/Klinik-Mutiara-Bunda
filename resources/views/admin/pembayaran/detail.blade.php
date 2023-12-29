<table class="table table-striped">
    <thead>
      <tr>                            
        <th>Kode Produk</th>
        <th>Nama Produk</th>
        <th>Obat/Tindakan</th>
        <th>Qty</th>
        <th>Harga Subtotal</th>
      </tr>
    </thead>
    <tbody>
       
        @forelse ($transDetail as $td)
            @if ($td->idTindakan != null)
                <tr>
                    <td>{{$td->kodetindakan}}</td>
                    <td>{{$td->tindakan}}</td>
                    <td>Tindakan</td>
                    <td>{{$td->quantity}}</td>
                    <td>{{ 'Rp.'.number_format($td->hargaSubtotal,0,',','.') }}</td>
                </tr>
            @else
                <tr>
                    <td>{{$td->kodeobat}}</td>
                    <td>{{$td->obat}}</td>
                    <td>Obat</td>
                    <td>{{$td->quantity}}</td>
                    <td>{{ 'Rp.'.number_format($td->hargaSubtotal,0,',','.') }}</td>
                </tr>
            @endif
        @empty
            <tr>
                <td colspan="7">Tidak Ada Data</td>
            </tr>
        @endforelse
        @if (!$transDetail->isEmpty())
            <tr>
                <td colspan="4">Total</td>
                <td>{{ 'Rp.'.number_format($sumTransDetail,0,',','.') }}</td>
            </tr>
        @endif
    </tbody>
</table>