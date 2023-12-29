{{-- ISI POP UP DETAIL TINDAKAN TERPAKAI --}}
<table class="table table-striped">
    <thead>
      <tr>                            
        <th>Kode Tindakan</th>
        <th>Nama Tindakan</th>
        <th>Count</th>
      </tr>
    </thead>
    <tbody>
       
        @forelse ($tindakanlist as $t)
            <tr>
                <td>{{$t->kodetindakan}}</td>
                <td>{{$t->tindakan}}</td>
                <td>{{$t->quantity}}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7">Tidak Ada Data</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{-- <div class="row pt-4">
    <div class="col-md-12 col-sm-1">
        <div class="tile-stats p-3">
            @if ($tindakanlist->first() != null)
                <div class="count">Tindakan Terpakai</div>
                @foreach ($tindakanlist as $tl)
                    <h3 class="ml-5">{{$tl->tindakan}}</h5>
                @endforeach
            @else
                <div class="count">Tidak Ada Tindakan Terpakai</div>
            @endif
        </div>
    </div>
</div> --}}

