{{-- ISI POP UP DETAIL OBAT TERPAKAI --}}
<table class="table table-striped">
    <thead>
      <tr>                            
        <th>Kode Obat</th>
        <th>Nama Obat</th>
        <th>Quantity</th>
      </tr>
    </thead>
    <tbody>
        @forelse ($obatlist as $o)
            <tr>
                <td>{{$o->kodeobat}}</td>
                <td>{{$o->obat}}</td>
                <td>{{$o->quantity}}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7">Tidak Ada Data</td>
            </tr>
        @endforelse
    </tbody>
</table>

