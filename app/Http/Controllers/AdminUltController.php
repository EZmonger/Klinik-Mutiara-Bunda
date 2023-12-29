<?php

namespace App\Http\Controllers;

use App\Exports\TransactionExport;
use App\Models\Datapasien;
use App\Models\Matrix;
use App\Models\Nakes;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Pekerjaan;
use App\Models\Role;
use App\Models\Tindakan;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class AdminUltController extends Controller
{
    public function __construct()
    {
        $adminInfo = Nakes::where('id', session('loggedId'))->first();        
        if(!$adminInfo){            
            $this->logout();
        }
    }

    public function index(Request $request)
    {
        
        //MENGAMBIL INFO USER  
        $adminInfo = Nakes::where('id', session('loggedId'))->first();
        //MENGAMBIL ID ADMIN
        $adminRoleId = Role::where('role', 'ADMIN')->pluck('id')->first();
        //MENGAMBIL DETAIL ROLE USER UNTUK MENENTUKAN APAKAH FITUR2 DITAMPILKAN
        $roleInfo = Role::where('id', session('loggedRole'))->first();

        // VALIDASI FILTER HALAMAN
        if($request->search == 'cari')
        {
            //MENTRANSLATE INPUT FILTER
            $this->validate($request, [            
                'tanggalFrom'      => 'required',
                'tanggalTo'      => 'required',
            ]);
            $fromDate = $request->tanggalFrom.' 00:00:00';
            $toDate = $request->tanggalTo.' 23:59:59';
            
            //MENGAMBIL NILAI OBAT TERPAKAI, TINDAKAN TERPAKAI, JUMLAH PASIEN, 
            // DAN JUMLAH PENDAPATAN DI DASHBOARD
            $obatterpakai = TransactionDetail::where('created_at', '>=', $fromDate)
            ->where('created_at', '<=', $toDate)->where('idObat', '!=' , null)->sum('quantity');
            
            $tindakannum = TransactionDetail::where('created_at', '>=', $fromDate)
            ->where('created_at', '<=', $toDate)->where('idTindakan', '!=' , null)->sum('quantity');
            
            $pasiennum = Datapasien::where('created_at', '>=', $fromDate)
            ->where('created_at', '<=', $toDate)->count();

            $pendapatan = Transaction::where('status', 'Paid')
            ->where('created_at', '>=', $fromDate)
            ->where('created_at', '<=', $toDate)->sum('hargaTotal');


            //UNTUK INPUT YANG MEMBUTUHKANNYA
            $pasien = Pasien::all();
            $tindakan = Tindakan::all();
            $obat = Obat::all();
            
            return view('admin.beranda.index', [
                'title' => 'Beranda',
                'infos' => $adminInfo,
                'adminRoleId' => $adminRoleId,
                'roleinfo' => $roleInfo,
                'pasiennum' => $pasiennum,
                'tindakannum' => $tindakannum,
                'obat' => $obat,
                'obatterpakai' => $obatterpakai,
                'tindakan' => $tindakan,
                'pasien' => $pasien,
                'pendapatan' => $pendapatan,
                'tanggalfrom' => $fromDate,
                'tanggalto' => $toDate,
            ]);
            
        }else{
            //MENSETTING FILTER BERDASARKAN HARI INI (SETTING DEFAULT)
            $tanggalfrom = Carbon::today();
            $tanggalto = Carbon::today();

            $fromDate = $tanggalfrom->format('Y-m-d').' 00:00:00';
            $toDate = $tanggalto->format('Y-m-d').' 23:59:59';
            

            //MENGAMBIL NILAI OBAT TERPAKAI, TINDAKAN TERPAKAI, JUMLAH PASIEN, 
            // DAN JUMLAH PENDAPATAN DI DASHBOARD
            $obatterpakai = TransactionDetail::where('created_at', '>=', $fromDate)
            ->where('created_at', '<=', $toDate)->where('idObat', '!=' , null)->sum('quantity');
            
            $tindakannum = TransactionDetail::where('created_at', '>=', $fromDate)
            ->where('created_at', '<=', $toDate)->where('idTindakan', '!=' , null)->sum('quantity');
            
            $pasiennum = Datapasien::where('created_at', '>=', $fromDate)
            ->where('created_at', '<=', $toDate)->count();
            
            $pendapatan = Transaction::where('status', 'Paid')
            ->where('created_at', '>=', $fromDate)
            ->where('created_at', '<=', $toDate)->sum('hargaTotal');
            

            //UNTUK INPUT YANG MEMBUTUHKANNYA
            $pasien = Pasien::all();
            $tindakan = Tindakan::all();
            $obat = Obat::all();
            
            return view('admin.beranda.index', [
                'title' => 'Beranda',
                'infos' => $adminInfo,
                'adminRoleId' => $adminRoleId,
                'roleinfo' => $roleInfo,
                'pasien' => $pasien,
                'tindakan' => $tindakan,
                'obat' => $obat,
                'obatterpakai' => $obatterpakai,
                'tindakannum' => $tindakannum,
                'pasiennum' => $pasiennum,
                'pendapatan' => $pendapatan,
                'tanggalfrom' => $fromDate,
                'tanggalto' => $toDate,
            ]);
        }
    }

    public function indexTindakan(Request $request){
        // MENAMPILKAN DETAIL TINDAKAN TERPAKAI DI DASHBOARD 
        $tindakanlist = TransactionDetail::join('tindakans', 'transactiondetail.idTindakan', '=', 'tindakans.id')
        ->select('kodetindakan', 'tindakan', DB::raw('sum(quantity) as quantity'))
        ->where('transactiondetail.created_at', '>=', $request->get('tanggalfrom'))
        ->where('transactiondetail.created_at', '<=', $request->get('tanggalto'))
        ->groupBy('kodetindakan', 'tindakan')
        ->get();

        return view('admin.beranda.tindakan_num', ['tindakanlist' => $tindakanlist]);

    }

    public function indexObat(Request $request){
        // MENAMPILKAN DETAIL OBAT TERPAKAI DI DASHBOARD 
        $obatlist = TransactionDetail::join('obats', 'transactiondetail.idObat', '=', 'obats.id')
        ->select('kodeobat', 'obat', DB::raw('sum(quantity) as quantity'))
        ->where('transactiondetail.created_at', '>=', $request->get('tanggalfrom'))
        ->where('transactiondetail.created_at', '<=', $request->get('tanggalto'))
        ->groupBy('kodeobat', 'obat')
        ->get();

        return view('admin.beranda.obat_num', ['obatlist' => $obatlist]);
    }

    public function pasiens(Request $request)
    {
        $adminInfo = Nakes::where('id', session('loggedId'))->first();
        $adminRoleId = Role::where('role', 'ADMIN')->pluck('id')->first();
        $roleInfo = Role::where('id', session('loggedRole'))->first();

        if($request->search == 'cari' || $request->fromDashboard == 'fromDashboard')
        {
            if($request->search == 'cari'){
                $this->validate($request, [            
                    'tanggal'      => 'required',
                ]);
            }
            $pasien = Pasien::whereDate('created_at', $request->tanggal)
            ->orderBy('created_at', 'DESC')->get();            
            
            return view('admin.pasien.index', [
                'title' => 'Registrasi Pasien',
                'infos' => $adminInfo,
                'adminRoleId' => $adminRoleId,
                'roleinfo' => $roleInfo,
                'pasien' => $pasien,
                'tanggalsearch' => $request->tanggal
            ]);
            
        }else{

            $pasien = Pasien::orderBy('created_at', 'DESC')->get();
            return view('admin.pasien.index', [
                'title' => 'Registrasi Pasien',
                'infos' => $adminInfo,
                'adminRoleId' => $adminRoleId,
                'roleinfo' => $roleInfo,
                'pasien' => $pasien,
                'tanggalsearch' => Carbon::today()
            ]);
        }
    }

    public function insertpasiens(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'          => 'required',
            'alamat'        => 'required',
            'tgllahir'      => 'required',
            'jeniskelamin'  => 'required',
            'bpjs'          => 'nullable|min:13|max:13'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('fail', 'Data Pasien Gagal Diregistrasi');
        }
        
        $date = date('Y-m-d'); 
        $date2 = date('dmy');      
        $created_at = Pasien::latest()->pluck('created_at')->first();
        // dd($date, $created_at);
        $tanggal = date('Y-m-d', strtotime($created_at));
        // dd($date, $tanggal);
        if($date == $tanggal)
        {
            // dd('test');
            $no = Pasien::latest()->pluck('nomor')->first();
            $nomor = str::padLeft($no+1, 2, '0');

            $data = [
                'koderegistrasi'    => "REG-".$date2. '-' . $nomor,
                'nomor'             => $nomor,
                'nama'              => strtoupper($request->nama),
                'tgllahir'          => $request->tgllahir,
                'alamat'            => strtoupper($request->alamat),
                'jeniskelamin'      => $request->jeniskelamin,
                'bpjs'              => $request->bpjs,
            ];
    
            Pasien::create($data);
            return back()->with('success', 'Pasien Berhasil Diregistrasi');

        }elseif($date > $tanggal)
        {
            // dd('tes');
            $no = '00';         
            $nomor = str::padLeft($no+1, 2, '0');

            $data = [
                'koderegistrasi'    => "REG-".$date2. '-' . $nomor,
                'nomor'             => $nomor,
                'nama'              => strtoupper($request->nama),
                'tgllahir'          => $request->tgllahir,
                'alamat'            => strtoupper($request->alamat),
                'jeniskelamin'      => $request->jeniskelamin,
                'bpjs'              => $request->bpjs,
            ];
    
            Pasien::create($data);
            return back()->with('success', 'Pasien Berhasil Diregistrasi');            
        }                
    }

    public function updatepasiens(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'          => 'required',
            'alamat'        => 'required',
            'tgllahir'      => 'required',
            'jeniskelamin'  => 'required',
            'bpjs'          => 'nullable|min:13|max:13'

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('fail', 'Data Pasien Gagal Diupdate');
        }

        $id = $request->id;

        $data = [            
            'nama'              => strtoupper($request->nama),
            'tgllahir'          => $request->tgllahir,
            'alamat'            => strtoupper($request->alamat),
            'jeniskelamin'      => $request->jeniskelamin,
            'bpjs'              => $request->bpjs,
        ];

        $update = Pasien::where('id', $id)->update($data);
        if ($update) {
            return back()->with('update', 'Data Pasien Berhasil Diupdate');
        }
    }

    public function deletepasiens($id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->delete();        
        return back()->with('delete', 'Data Pasien Berhasil Dihapus');
    }

    public function getPasien(Request $request)
    {
        $result = [];
        $pasiens = $request->post('pasiens');
        $pasien = Pasien::where('id', $pasiens)->get();
        foreach ($pasien as $ps) {
            // $result['kodepasien'] = $ps->kodepasien;
            // $result['alamat'] = $ps->alamat;
            // $result['tgllahir'] = $ps->tgllahir;
            // $result['berat'] = $ps->berat;
            // $result['tensi'] = $ps->tensi;
            $result = [
                'koderegistrasi'    => $ps->koderegistrasi,
                'alamat'        => $ps->alamat,
                'tgllahir'      => $ps->tgllahir,
                'jeniskelamin'  => $ps->jeniskelamin,
                'bpjs'          => $ps->bpjs,
            ];
        }
        return response()->json($result);
    }

    
    public function getObat(Request $request)
    {
        $result = [];
        $obats = $request->post('obats');
        $obat = Obat::where('id', $obats)->get();
        foreach ($obat as $ob) {
            $result['stock'] = $ob->stock;
            $result['satuan'] = $ob->satuan;            
        }
        return response()->json($result);
    } 

    public function datapasiens(Request $request)
    {
        $adminInfo = Nakes::where('id', session('loggedId'))->first();
        $adminRoleId = Role::where('role', 'ADMIN')->pluck('id')->first();
        $roleInfo = Role::where('id', session('loggedRole'))->first();

        if($request->search == 'cari')
        {
            $this->validate($request, [      
                'tanggalFrom'      => 'required',
                'tanggalTo'      => 'required',
                // 'tanggal'      => 'required',
            ]);
                               
            $fromDate = $request->tanggalFrom.' 00:00:00';
            $toDate = $request->tanggalTo.' 23:59:59';
            // dd($fromDate, $toDate);
            $datapasien = Datapasien::join('pasiens', 'datapasiens.idPasien', '=', 'pasiens.id')
            ->join('nakes', 'datapasiens.idNakes', '=', 'nakes.id')
            ->join('transactionheader', 'datapasiens.id', '=', 'transactionheader.idDataPasien', 'left outer')
            ->select('datapasiens.id as id', 'kodepasien', 'koderegistrasi', 'pasiens.nama as namapasien', 
            'pasiens.tgllahir', 'pasiens.jeniskelamin', 'keluhan', 'datapasiens.created_at as date', 
            'berat', 'tensi', 'suhu', 'heartRate', 'resRate', 'saturasiOx', 'transactionheader.id as transId')
            // ->whereDate('datapasiens.created_at', $request->tanggal)
            // ->where('datapasiens.deleted_at', null)
            ->where('datapasiens.created_at', '>=', $fromDate)
            ->where('datapasiens.created_at', '<=', $toDate)
            ->orderBy('datapasiens.created_at', 'DESC')
            ->get();

            // dd($datapasien);
            $pasien = Pasien::all();
            $tindakan = Tindakan::all();
            $obat = Obat::all();

            return view('admin.datapasien.index', [
                'title' => 'Data Pasien',
                'infos' => $adminInfo,
                'adminRoleId' => $adminRoleId,
                'roleinfo' => $roleInfo,
                'pasien' => $pasien,
                'datapasien' => $datapasien,
                'tindakan' => $tindakan,
                'obat' => $obat,
                'tanggalfrom' => $fromDate,
                'tanggalto' => $toDate
            ]);
            
        }else{

            $tanggalfrom = Carbon::today();
            $tanggalto = Carbon::today();

            $fromDate = $tanggalfrom->format('Y-m-d').' 00:00:00';
            $toDate = $tanggalto->format('Y-m-d').' 23:59:59';

            $datapasien = Datapasien::join('pasiens', 'datapasiens.idPasien', '=', 'pasiens.id')
            ->join('nakes', 'datapasiens.idNakes', '=', 'nakes.id')
            ->join('transactionheader', 'datapasiens.id', '=', 'transactionheader.idDataPasien', 'left outer')
            ->select('datapasiens.id as id', 'kodepasien', 'koderegistrasi', 'pasiens.nama as namapasien', 'keluhan', 
            'pasiens.tgllahir', 'pasiens.jeniskelamin', 'keluhan', 'datapasiens.created_at as date', 
            'berat', 'tensi', 'suhu', 'heartRate', 'resRate', 'saturasiOx', 'transactionheader.id as transId')
            // ->whereDate('datapasiens.created_at', Carbon::today())
            // ->where('datapasiens.deleted_at', null)
            ->where('datapasiens.created_at', '>=', $fromDate)
            ->where('datapasiens.created_at', '<=', $toDate)
            ->orderBy('datapasiens.created_at', 'DESC')
            ->get();

            // dd($datapasien);
            $pasien = Pasien::all();
            $tindakan = Tindakan::all();
            $obat = Obat::all();

            return view('admin.datapasien.index', [
                'title' => 'Data Pasien',
                'infos' => $adminInfo,
                'adminRoleId' => $adminRoleId,
                'roleinfo' => $roleInfo,
                'pasien' => $pasien,
                'datapasien' => $datapasien,
                'tindakan' => $tindakan,
                'obat' => $obat,
                'tanggalfrom' => $fromDate,
                'tanggalto' => $toDate
            ]);
        }
    }

    public function datapasiensDashboard($tanggalfrom, $tanggalto){
        $adminInfo = Nakes::where('id', session('loggedId'))->first();
        $adminRoleId = Role::where('role', 'ADMIN')->pluck('id')->first();
        $roleInfo = Role::where('id', session('loggedRole'))->first();
        $fromDate = $tanggalfrom;
        $toDate = $tanggalto;

        $datapasien = Datapasien::join('pasiens', 'datapasiens.idPasien', '=', 'pasiens.id')
        ->join('nakes', 'datapasiens.idNakes', '=', 'nakes.id')
        ->select('datapasiens.id as id', 'kodepasien', 'koderegistrasi', 'pasiens.nama as namapasien', 'keluhan', 
        'pasiens.tgllahir', 'pasiens.jeniskelamin', 'keluhan', 'datapasiens.created_at as date', 
        'berat', 'tensi', 'suhu', 'heartRate', 'resRate', 'saturasiOx')
        ->where('datapasiens.created_at', '>=', $fromDate)
        ->where('datapasiens.created_at', '<=', $toDate)
        ->orderBy('datapasiens.created_at', 'DESC')->get();

        // dd($datapasien);
        $pasien = Pasien::all();
        $tindakan = Tindakan::all();
        $obat = Obat::all();
        return view('admin.datapasien.index', [
            'title' => 'Data Pasien',
            'infos' => $adminInfo,
            'adminRoleId' => $adminRoleId,
            'roleinfo' => $roleInfo,
            'pasien' => $pasien,
            'datapasien' => $datapasien,
            'tindakan' => $tindakan,
            'obat' => $obat,
            'tanggalfrom' => $fromDate,
            'tanggalto' => $toDate
        ]);
    }

    public function insertdataps(Request $request)
    {
        $adminInfo = Nakes::where('id', session('loggedId'))->first();
        // dd($adminInfo->id);

        $validator = Validator::make($request->all(), [
            'pasiens'       => 'required',
            'keluhan'       => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('fail', 'Data Transaksi Pasien Gagal Disimpan');
        }
        

        //noodle

        $date = date('Y-m-d');  
        $date2 = date('dmy');
        // dd(date('dmy h:i:s'));
        // $created_at = Transaction::latest()->pluck('created_at')->first();
        // $tanggal = date('dmy', strtotime($created_at));
        $maxdate = Datapasien::max('created_at');
        // dd(Datapasien::max('created_at'));
        $tanggal = date('Y-m-d', strtotime($maxdate));
        // dd($date == $tanggal);
        if ($date == $tanggal) {
            // dd(date('Y-m-d', strtotime($maxdate)));
            $no = Datapasien::whereDate('created_at', $tanggal)->max('nomor');
            // dd($no);
            $nomor = str::padLeft($no+1, 2, '0');

            $datapasien = [
                'idPasien'          => $request->get('pasiens'),
                'idNakes'           => $adminInfo->id,
                'kodepasien'        => "PSN-".$date2.'-'.$nomor,
                'nomor'             => $nomor,
                'keluhan'           => strtoupper($request->get('keluhan')),
                'berat'             => $request->get('berat'),
                'tensi'             => $request->get('tensi'),
                'suhu'              => $request->get('suhu'),
                'heartRate'         => $request->get('hrate'),
                'resRate'           => $request->get('resrate'),
                'saturasiOx'        => $request->get('satox'),
            ];
            $dataPasienId = Datapasien::insertGetId($datapasien);
    
            return back()->with('success', 'Data Transaksi Pasien Berhasil Disimpan');
        }
        elseif ($date > $tanggal) {
            $no = '00';         
            $nomor = str::padLeft($no+1, 2, '0');

            $datapasien = [
                'idPasien'          => $request->get('pasiens'),
                'idNakes'           => $adminInfo->id,
                'kodepasien'        => "PSN-".$date2.'-'.$nomor,
                'nomor'             => $nomor,
                'keluhan'           => strtoupper($request->get('keluhan')),
                'berat'             => $request->get('berat'),
                'tensi'             => $request->get('tensi'),
                'suhu'              => $request->get('suhu'),
                'heartRate'         => $request->get('hrate'),
                'resRate'           => $request->get('resrate'),
                'saturasiOx'        => $request->get('satox'),
            ];
            $dataPasienId = Datapasien::insertGetId($datapasien);
    
            return back()->with('success', 'Data Transaksi Pasien Berhasil Disimpan');
        }
        
    }

    public function inputtindakanobatmenu($id){
        $adminInfo = Nakes::where('id', session('loggedId'))->first();
        $adminRoleId = Role::where('role', 'ADMIN')->pluck('id')->first();
        $roleInfo = Role::where('id', session(('loggedRole')))->first();
        
        

        $tindakan = Tindakan::all();
        $obat = Obat::all();
        
        return view('admin.datapasien.input_tindakan_obat', [
            'title'     => 'Input Tindakan Obat',
            'id'        => $id,
            'infos'     => $adminInfo,
            'adminRoleId' => $adminRoleId,
            'roleinfo' => $roleInfo,
            'tindakan'  => $tindakan,
            'obat'      => $obat,
        ]);
    }

    public function inputtindakanobat(Request $request){
        $adminInfo = Nakes::where('id', session('loggedId'))->first();
        $adminRoleId = Role::where('role', 'ADMIN')->pluck('id')->first();
        $roleInfo = Role::where('id', session('loggedRole'))->first();

        $id                 = $request->get('id');
        $obat               = $request->get('obat');
        $quantityObat       = $request->get('quantityObat');
        $tindakan           = $request->get('tindakan');
        $quantityTindakan   = $request->get('quantityTindakan');

        

        $datastock = array_combine($obat, $quantityObat);        
        foreach ($datastock as $idobat => $pengurangan) {       
            if($idobat != ""){
                $obatst = Obat::where('id', $idobat)->first();
                if ($obatst->stock < $pengurangan) {
                    return back()->with('error', 'Stock Obat '.$obatst->obat.' tidak mencukupi');
                }else{
                    $obatst->decrement('stock', $pengurangan);
                }
            }     
        }

        $date = date('Y-m-d');  
        $date2 = date('dmy');
        
        $maxdate = Transaction::max('date');
        $tanggal = date('Y-m-d', strtotime($maxdate));
        
        if($date == $tanggal){
            $no = Transaction::where('date', $maxdate)->max('no');
            
            $nomor = str::padLeft($no+1, 2, '0');
            $transaction = [
                'kodeTransaction'   => "TRSC-".$date2. '-' . $nomor,
                'no'                => $nomor,
                'idDataPasien'      => $id,
                'status'            => 'Unpaid'
            ];
        }
        elseif($date > $tanggal){
            $no = '00';         
            $nomor = str::padLeft($no+1, 2, '0');
            $transaction = [
                'kodeTransaction'   => "TRSC-".$date2. '-' . $nomor,
                'no'                => $nomor,
                'idDataPasien'      => $id,
                'status'            => 'Unpaid'
            ];
        }
        $transactionId = Transaction::insertGetId($transaction);
        
        $hargaTotal = 0;
        $qtyTindakan = [];
        foreach ($quantityTindakan as $qt) {            
            $qtyTindakan[] = $qt;
        }
        for($i = 0; $i<count($tindakan);$i++){
            if($tindakan[$i] != null){
                $hargaTindakan = Tindakan::where('id', $tindakan[$i])->pluck('harga')->first();
                $hargaSubtotal = $qtyTindakan[$i] * $hargaTindakan;
                $hargaTotal += $hargaSubtotal;
                TransactionDetail::insert([
                    'idTransactionH'=> $transactionId,
                    'idTindakan'    => $tindakan[$i],
                    'quantity'      => $qtyTindakan[$i],
                    'hargaSubtotal' => $hargaSubtotal,
                ]);
            }
        }
        
        $qtyObat = [];
        foreach ($quantityObat as $qt) {            
            $qtyObat[] = $qt;
        }
        for ($i = 0; $i<count($obat);$i++) {
            if($obat[$i] != null){
                $hargaObat = Obat::where('id', $obat[$i])->pluck('harga')->first();
                $hargaSubtotal = $qtyObat[$i] * $hargaObat;
                $hargaTotal += $hargaSubtotal;
                TransactionDetail::insert([
                    'idTransactionH'=> $transactionId,
                    'idObat'        => $obat[$i],
                    'quantity'      => $qtyObat[$i],
                    'hargaSubtotal' => $hargaSubtotal,
                ]);
            }
        }

        Transaction::where('id', $transactionId)->update([
            'hargaTotal' => $hargaTotal,
        ]);        

        return redirect('/datapasien')->with('success', 'Data Transaksi Berhasil Disimpan');
    }

    public function updatedataps(Request $request){

        $validator = Validator::make($request->all(), [
            'keluhan'       => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('fail', 'Data Pasien Gagal Disimpan');
        }

        $id = $request->id;

        $datapasien = [
            'keluhan'           => strtoupper($request->get('keluhan')),
            'berat'             => $request->get('berat'),
            'tensi'             => $request->get('tensi'),
            'suhu'              => $request->get('suhu'),
            'heartRate'         => $request->get('hrate'),
            'resRate'           => $request->get('resrate'),
            'saturasiOx'        => $request->get('satox'),
        ];

        $update = Datapasien::where('id', $id)->update($datapasien);
        if ($update) {
            return back()->with('update', 'Data Pasien Berhasil Diupdate');
        }
    }

    public function deletedataps($id)
    {
        $th = Transaction::where('idDataPasien', $id);
        $transactstatus = $th->pluck('status')->first();
        $transactId = $th->pluck('id')->first();
        if ($transactstatus == 'Unpaid') {
            $pt = TransactionDetail::where('idTransactionH', $transactId)->whereNotNull('idObat');
            while ($pt->first() != null) {

                $idobat = $pt->pluck('idObat')->first();
                $quantity = $pt->pluck('quantity')->first();
                Obat::where('id', $idobat)->increment('stock', $quantity);
                $pt->first()->delete();
            }
        }

        $datap = Datapasien::findOrFail($id);
        $datap->delete();
        return back()->with('delete', 'Data Pasien Berhasil Dihapus');
    }

    public function pembayaran(Request $request)
    {
        $adminInfo = Nakes::where('id', session('loggedId'))->first();
        $adminRoleId = Role::where('role', 'ADMIN')->pluck('id')->first();
        $roleInfo = Role::where('id', session('loggedRole'))->first();
        // dd($roleInfo->paymentTranspg);
        // dd($request);
        if($request->search == 'cari')
        {
            $this->validate($request, [            
                'tanggalFrom'      => 'required',
                'tanggalTo'      => 'required',
            ]);

            // dd($request->tanggalFrom, $request->tanggalTo);
            $fromDate = $request->tanggalFrom.' 00:00:00';
            $toDate = $request->tanggalTo.' 23:59:59';
            // dd($request->tanggalFrom);
            $transaction = Transaction::join('datapasiens', 'transactionheader.idDataPasien', '=', 'datapasiens.id')
            ->join('pasiens', 'datapasiens.idPasien', '=', 'pasiens.id')
            ->join('nakes', 'datapasiens.idNakes', '=', 'nakes.id')
            ->where('transactionheader.created_at', '>=', $fromDate)
            ->where('transactionheader.created_at', '<=', $toDate)
            ->select('transactionheader.id as id',
            'kodeTransaction', 'kodepasien',
            'nakes.nama as namaNakes', 
            'pasiens.nama as namaPasien',
            'datapasiens.keluhan',
            'transactionheader.created_at as date',
            'hargaTotal',
            'transactionheader.status')
            ->orderBy('transactionheader.created_at', 'DESC')
            ->get();
            
            $sumTransaction = Transaction::where('transactionheader.status', 'Paid')
            ->where('transactionheader.created_at', '>=', $fromDate)
            ->where('transactionheader.created_at', '<=', $toDate)
            ->sum('hargaTotal');
            
            return view('admin.pembayaran.index', [
                'title'      => 'Data Pembayaran',
                'infos'      => $adminInfo,
                'adminRoleId' => $adminRoleId,
                'roleinfo' => $roleInfo,
                'transaction' => $transaction,
                'tanggalfrom' => $fromDate,
                'tanggalto' => $toDate,
                'sumPembayaran' => $sumTransaction
            ]);
            
        }else{
            $tanggalfrom = Carbon::today();
            $tanggalto = Carbon::today();

            $fromDate = $tanggalfrom->format('Y-m-d').' 00:00:00';
            $toDate = $tanggalto->format('Y-m-d').' 23:59:59';

            $transaction = Transaction::join('datapasiens', 'transactionheader.idDataPasien', '=', 'datapasiens.id')
            ->join('pasiens', 'datapasiens.idPasien', '=', 'pasiens.id')
            ->join('nakes', 'datapasiens.idNakes', '=', 'nakes.id')
            ->where('transactionheader.created_at', '>=', $fromDate)
            ->where('transactionheader.created_at', '<=', $toDate)
            ->select('transactionheader.id as id', 
            'kodeTransaction', 'kodepasien',
            'nakes.nama as namaNakes', 
            'pasiens.nama as namaPasien',
            'datapasiens.keluhan',
            'transactionheader.created_at as date',
            'hargaTotal',
            'transactionheader.status')
            ->orderBy('transactionheader.created_at', 'DESC')
            ->get();

            // dd($transaction);

            $sumTransaction = Transaction::where('transactionheader.status', 'Paid')
            ->where('transactionheader.created_at', '>=', $fromDate)
            ->where('transactionheader.created_at', '<=', $toDate)
            ->sum('hargaTotal');


            return view('admin.pembayaran.index', [
                'title'      => 'Data Pembayaran',
                'infos'      => $adminInfo,
                'adminRoleId' => $adminRoleId,
                'roleinfo' => $roleInfo,
                'transaction' => $transaction,
                'tanggalfrom' => $fromDate,
                'tanggalto' => $toDate,
                'sumPembayaran' => $sumTransaction
            ]);
        }

    }

    public function payment($id){
        $transactionStatus = Transaction::where('id', $id)->pluck('status')->first();
        // dd($transactionStatus);
        if($transactionStatus == 'Paid'){
            Transaction::where('id', $id)->update([
                'status' => 'Unpaid'
            ]);

            return back()->with('update', 'Pembayaran Berhasil Dibatalkan');
        }
        else{
            
            Transaction::where('id', $id)->update([
                'status' => 'Paid'
            ]);

            return back()->with('update', 'Pembayaran Berhasil');
        }
    }

    public function downloadExcel($fromDate, $toDate){
        $file = new TransactionExport($fromDate, $toDate);

        return Excel::download($file, 'transaction.xlsx');
    }

    public function pembayaranDashboard($tanggalfrom, $tanggalto){
        $adminInfo = Nakes::where('id', session('loggedId'))->first();
        $adminRoleId = Role::where('role', 'ADMIN')->pluck('id')->first();
        $roleInfo = Role::where('id', session('loggedRole'))->first();
        
        $fromDate = $tanggalfrom;
        $toDate = $tanggalto;
        
        

        $transaction = Transaction::join('datapasiens', 'transactionheader.idDataPasien', '=', 'datapasiens.id')
        ->join('pasiens', 'datapasiens.idPasien', '=', 'pasiens.id')
        ->join('nakes', 'datapasiens.idNakes', '=', 'nakes.id')
        ->where('transactionheader.created_at', '>=', $fromDate)
        ->where('transactionheader.created_at', '<=', $toDate)
        ->select('transactionheader.id as id',
        'kodeTransaction', 'kodepasien',
        'nakes.nama as namaNakes', 
        'pasiens.nama as namaPasien',
        'keluhan',
        'transactionheader.created_at as date',
        'hargaTotal',
        'transactionheader.status')
        ->orderBy('transactionheader.created_at', 'DESC')
        ->get();
        
        $sumTransaction = Transaction::where('transactionheader.status', 'Paid')
        ->where('transactionheader.created_at', '>=', $fromDate)
        ->where('transactionheader.created_at', '<=', $toDate)
        ->sum('hargaTotal');
        
        return view('admin.pembayaran.index', [
            'title'      => 'Data Pembayaran',
            'infos'      => $adminInfo,
            'adminRoleId' => $adminRoleId,
            'roleinfo' => $roleInfo,
            'transaction' => $transaction,
            'tanggalfrom' => $fromDate,
            'tanggalto' => $toDate,
            'sumPembayaran' => $sumTransaction
        ]);
    }

    public function pembayaran_detail(Request $request){
        $transDetail = TransactionDetail::join('obats', 'transactiondetail.idObat', '=', 'obats.id', 'left outer')
        ->join('tindakans', 'transactiondetail.idTindakan', '=', 'tindakans.id', 'left outer')
        ->where('idTransactionH', '=', $request->get('id'))
        ->get();

        $sumTransDetail = TransactionDetail::where('idTransactionH', '=', $request->get('id'))->sum('hargaSubtotal');

        // dd($transDetail, $sumTransDetail);

        $data = [
            'transDetail'       => $transDetail,
            'sumTransDetail'    => $sumTransDetail,
        ];
        // dd("test");
        return view('admin.pembayaran.detail', $data);
        
    }

    public function invoice($id)
    {
        $transaction = Transaction::join('datapasiens', 'transactionheader.idDataPasien', '=', 'datapasiens.id')
        ->join('pasiens', 'datapasiens.idPasien', '=', 'pasiens.id')
        ->join('nakes', 'datapasiens.idNakes', '=', 'nakes.id')
        ->where('transactionheader.id', $id)
        ->select('transactionheader.created_at as date', 'datapasiens.kodepasien', 
        'transactionheader.kodeTransaction', 'pasiens.nama as namaPasien', 'nakes.nama as namaNakes', 
        'pasiens.alamat', 'datapasiens.keluhan', 'transactionheader.hargaTotal')
        ->first();

        $transDetail = TransactionDetail::join('tindakans', 'transactiondetail.idTindakan', '=', 'tindakans.id', 'left outer')
        ->join('obats', 'transactiondetail.idObat', '=', 'obats.id', 'left outer')
        ->where('idTransactionH', $id)
        ->select('tindakans.kodetindakan', 'tindakans.tindakan', 'tindakans.harga as hargaTindakan',
        'obats.kodeobat', 'obats.obat', 'obats.harga as hargaObat',
        'transactiondetail.idTindakan', 'transactiondetail.quantity', 'transactiondetail.hargaSubtotal')
        ->get();

        $transTotal = TransactionDetail::join('tindakans', 'transactiondetail.idTindakan', '=', 'tindakans.id', 'left outer')
        ->join('obats', 'transactiondetail.idObat', '=', 'obats.id', 'left outer')
        ->where('idTransactionH', $id)->sum('hargaSubtotal');
  
        $data = [
            'title'      => 'INVOICE',
            'title2'      => 'KLINIK MUTIARA BUNDA',
            'alamat'     => 'Jl. Soekarno-Hatta, No.150',
            'kabkota'    => 'Kec. Benai, Kab. Kuantan Singingi, Riau',
            'rekening'   => 'BCA xxxxxxxxxx',
            'an_rekening'=> 'a.n xxxxxxxxxx',
            'transaction'=> $transaction,
            'transDetail'=> $transDetail,
            'transTotal' => $transTotal
            // 'pembayaran' => $pembayaran,
            // 'tindakan'   => $tindakan,
            // 'obat'       => $obat            
        ]; 
                    
        return view('admin.invoice.index', $data);
    }

    public function deletePembayaran($id)
    {
        // $datapasienId = Transaction::where('id', $id)->pluck('idDataPasien')->first();
        
        // dd(Transaction::where('id', $id)->pluck('status')->first());
        $transactstatus = Transaction::where('id', $id)->pluck('status')->first();
        if ($transactstatus == 'Unpaid') {
            $pt = TransactionDetail::where('idTransactionH', $id)->whereNotNull('idObat');
            while ($pt->first() != null) {

                $idobat = $pt->pluck('idObat')->first();
                $quantity = $pt->pluck('quantity')->first();
                Obat::where('id', $idobat)->increment('stock', $quantity);
                $pt->first()->delete();
            }
        }
        
        
        // Datapasien::where('id', $datapasienId)->delete();
        Transaction::where('id', $id)->delete();

        // $kodepasien = Pembayaran::where('kodetrans', $id)->get('kodepasien');        

        // Datapasien::where('kodepasien', $kodepasien)->delete();
        // Pasienobat::where('kodepasien', $kodepasien)->delete();
        // Pasientindakan::where('kodepasien', $kodepasien)->delete();
        // Pembayaran::where('kodetrans', $id)->delete();

        return back()->with('delete', 'Data Pembayaran Berhasil Dihapus');
    }

    public function tenakes()
    {
        $adminInfo = Nakes::where('id', session('loggedId'))->first();
        $adminRoleId = Role::where('role', 'ADMIN')->pluck('id')->first();
        $roleInfo = Role::where('id', session('loggedRole'))->first();

        $nakes = Nakes::join('pekerjaans', 'nakes.idPekerjaan', '=', 'pekerjaans.id', 'left outer')
        ->join('roles', 'nakes.idRole', '=', 'roles.id')
        ->select('nakes.id as idnakes', 'username', 'kodenakes', 'nama', 'tgllahir', 'alamat', 'jeniskelamin',
        'pekerjaan', 'role', 'idPekerjaan', 'idRole')
        ->get();

        if (session('loggedRole') == $adminRoleId) {
            $role = Role::all();
        }
        else{
            $role = Role::where('id', '!=', $adminRoleId)->get();
        }
        $pekerjaan = Pekerjaan::all();

        return view('admin.nakes.index', [
            'title'     => 'Member',
            'infos'     => $adminInfo,
            'adminRoleId' => $adminRoleId,
            'roleinfo' => $roleInfo,
            'nakes'     => $nakes,
            'pekerjaan' => $pekerjaan,
            'role' => $role
        ]);
    }

    public function insertnakes(Request $request)
    {
        // dd($request->username);
        $validator = Validator::make($request->all(), [
            'nama'          => 'required',
            'tgllahir'      => 'required',
            'alamat'        => 'required',
            'jeniskelamin'  => 'required',
            'role'          => 'required',
            // 'pekerjaan'     => 'required',
            'username'      => 'required|unique:nakes,username',
            'password'      => 'required|min:5|max:255|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('fail', 'Data Member Gagal Disimpan');
        }
        // dd('pass');
        $no = Nakes::max('nomor');
        $nomor = str::padLeft($no+1, 3, '0');

        $password = Hash::make($request->password);

        $data = [
            'kodenakes'     => "TKS-".$nomor,
            'nomor'         => $nomor,
            'nama'          => strtoupper($request->nama),
            'tgllahir'      => $request->tgllahir,
            'alamat'        => strtoupper($request->alamat),
            'jeniskelamin'  => $request->jeniskelamin,
            'idPekerjaan'   => $request->pekerjaan,
            'idRole'        => $request->role,
            'username'      => $request->username,
            'password'      => $password,
        ];
        // dd($data);
        Nakes::create($data);
        return back()->with('success', 'Data Member Berhasil Disimpan');
    }

    public function updatenakes(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'      => 'required',
            'tgllahir'  => 'required',
            'alamat'    => 'required',
            // 'pekerjaan' => 'required',            
            'role'      => 'required',
            'jeniskelamin'  => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('fail', 'Data Tenaga Kesehatan Gagal Diupdate');
        }
        // dd($request->pekerjaan);
        $id = $request->id;

        $data = [
            'nama'              => strtoupper($request->nama),
            'tgllahir'          => $request->tgllahir,
            'alamat'            => strtoupper($request->alamat),
            'idPekerjaan'       => $request->pekerjaan,
            'idRole'              => $request->role,
            'jeniskelamin'      => $request->jeniskelamin
        ];
        // dd($id);
        $update = Nakes::where('id', $id)->update($data);
        // dd($update);
        if ($update) {
            return back()->with('update', 'Data Tenaga Kesehatan Berhasil Diupdate');
        }
    }

    public function updatepasswordnakes(Request $request)
    {
        // UNTUK MELAKUKAN RESET PASSWORD 
        $id = $request->id;


        $data = [
            'password'  => Hash::make($request->password)
        ];

        $update = Nakes::where('id', $id)->update($data);
        if ($update) {
            return back()->with('update', 'Password Berhasil Diupdate');
        }
    }

    public function deletenakes($id)
    {
        $nakes = Nakes::findOrFail($id);
        $nakes->delete();        
        return back()->with('delete', 'Data Tenaga Kesehatan Berhasil Dihapus');
    }

    public function rekamanmedis($id, Request $request)
    {
        $adminInfo = Nakes::where('id', session('loggedId'))->first();
        $adminRoleId = Role::where('role', 'ADMIN')->pluck('id')->first();
        $roleInfo = Role::where('id', session('loggedRole'))->first();

        if ($request->search == 'cari') {
            $this->validate($request, [            
                'tanggalFrom'      => 'required',
                'tanggalTo'      => 'required',
            ]);

            $fromDate = $request->tanggalFrom.' 00:00:00';
            $toDate = $request->tanggalTo.' 23:59:59';

            // MENGAMBIL DATA PASIEN DENGAN TRANSACTION HEADER SEBAGAI REKAMAN MEDIS 
            $datapasien = Datapasien::join('pasiens', 'datapasiens.idPasien', '=', 'pasiens.id')
            ->join('nakes', 'datapasiens.idNakes', '=', 'nakes.id')
            ->join('transactionheader', 'datapasiens.id', '=', 'transactionheader.idDataPasien', 'left outer')
            ->select('datapasiens.id as id', 'transactionheader.id as transHId', 'kodepasien', 
            'pasiens.nama as namapasien', 'kodeTransaction', 'nakes.nama as namanakes', 
            'pasiens.tgllahir', 'pasiens.jeniskelamin', 'keluhan', 'datapasiens.created_at as date', 
            'berat', 'tensi', 'suhu', 'heartRate', 'resRate', 'saturasiOx',
            'hargaTotal', 'transactionheader.status')
            ->where('pasiens.id', $id)
            ->where('datapasiens.created_at', '>=', $fromDate)
            ->where('datapasiens.created_at', '<=', $toDate)
            ->orderBy('datapasiens.created_at', 'DESC')
            ->get();

            $namaPasien = Pasien::where('id', $id)->pluck('nama')->first();

            return view('admin.pasien.medicrecord', [
                'title' => 'Rekaman Medis '.$namaPasien,
                'infos' => $adminInfo,
                'adminRoleId' => $adminRoleId,
                'roleinfo' => $roleInfo,
                'idpasien' => $id,
                'datapasien' => $datapasien,
                'fromDate' => $fromDate,
                'toDate' => $toDate
            ]);
        }
        else {
            $tanggalfrom = Carbon::today();
            $tanggalto = Carbon::today();

            $fromDate = $tanggalfrom->format('Y-m-d').' 23:59:59';
            $toDate = $tanggalto->format('Y-m-d').' 23:59:59';

            // MENGAMBIL DATA PASIEN DENGAN TRANSACTION HEADER SEBAGAI REKAMAN MEDIS 
            $datapasien = Datapasien::join('pasiens', 'datapasiens.idPasien', '=', 'pasiens.id')
            ->join('nakes', 'datapasiens.idNakes', '=', 'nakes.id')
            ->join('transactionheader', 'datapasiens.id', '=', 'transactionheader.idDataPasien', 'left outer')
            ->select('datapasiens.id as id', 'transactionheader.id as transHId', 'kodepasien', 
            'pasiens.nama as namapasien', 'kodeTransaction', 'nakes.nama as namanakes', 
            'pasiens.tgllahir', 'pasiens.jeniskelamin', 'keluhan', 'datapasiens.created_at as date', 
            'berat', 'tensi', 'suhu', 'heartRate', 'resRate', 'saturasiOx',
            'hargaTotal', 'transactionheader.status')
            ->where('pasiens.id', $id)
            ->orderBy('datapasiens.created_at', 'DESC')
            ->get();
            
            $namaPasien = Pasien::where('id', $id)->pluck('nama')->first();
            return view('admin.pasien.medicrecord', [
                'title' => 'Rekaman Medis '.$namaPasien,
                'infos' => $adminInfo,
                'adminRoleId' => $adminRoleId,
                'roleinfo' => $roleInfo,
                'idpasien' => $id,
                'datapasien' => $datapasien,
                'fromDate' => null,
                'toDate' => $toDate
            ]);
        }
    }

    public function pekerjaan()
    {
        $adminInfo = Nakes::where('id', session('loggedId'))->first();
        $adminRoleId = Role::where('role', 'ADMIN')->pluck('id')->first();
        $roleInfo = Role::where('id', session('loggedRole'))->first();

        $pekerjaan = Pekerjaan::all();
        return view('admin.pekerjaan.index', [
            'title' => 'Pasien',
            'infos' => $adminInfo,
            'adminRoleId' => $adminRoleId,
            'roleinfo' => $roleInfo,
            'pekerjaan' => $pekerjaan,
        ]);
    }

    public function addpekerjaan(Request $request){
        $validator = Validator::make($request->all(), [
            'pekerjaan' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('fail', 'Data Pekerjaan Gagal Disimpan');
        }

        $no = Pekerjaan::max('nomor');
        $nomor = str::padLeft($no+1, 2, '0');

        $data = [
            'kodepekerjaan' => "JOB-".$nomor,
            'nomor'         => $nomor,
            'pekerjaan'     => strtoupper($request->pekerjaan),
        ];

        Pekerjaan::create($data);
        return back()->with('success', 'Data Pekerjaan Berhasil Disimpan');
    }

    public function updatepekerjaan(Request $request){
        $validator = Validator::make($request->all(), [
            'pekerjaan' => 'required',            
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('fail', 'Data Pekerjaan Gagal Diupdate');
        }

        $id = $request->id;

        $data = [
            'pekerjaan'         => strtoupper($request->pekerjaan),
        ];

        $update = Pekerjaan::where('id', $id)->update($data);
        if ($update) {
            return back()->with('update', 'Data Pekerjaan Berhasil Diupdate');
        }
    }

    public function deletepekerjaan($id){
        $pekerjaan = Pekerjaan::findOrFail($id);
        $pekerjaan->delete();        
        return back()->with('delete', 'Data Pekerjaan Berhasil Dihapus');
    }

    public function profil()
    {
        $adminInfo = Nakes::where('id', session('loggedId'))->first();
        $adminRoleId = Role::where('role', 'ADMIN')->pluck('id')->first();
        $roleInfo = Role::where('id', session('loggedRole'))->first();

        $profil = Nakes::join('pekerjaans', 'nakes.idPekerjaan', '=', 'pekerjaans.id', 'left outer')
        ->join('roles', 'nakes.idRole', '=', 'roles.id')
        ->select('nakes.id as idnakes', 'nakes.nama', 'username', 'tgllahir', 'alamat', 'jeniskelamin', 'idPekerjaan',
        'pekerjaans.pekerjaan', 'role', 'idRole')
        ->where('nakes.id', session('loggedId'))->get();        


        
        $pekerjaan = Pekerjaan::all();
        return view('admin.profil.index', [
            'title' => 'Pengaturan Akun',
            'infos' => $adminInfo,
            'adminRoleId' => $adminRoleId,
            'roleinfo' => $roleInfo,
            'profil' => $profil,
            'pekerjaan' => $pekerjaan
        ]);
    }

    public function ubahPassword(Request $request)
    {
        $id = $request->user_id;
        // dd($request->user_id);
        $data = Nakes::where('id', $id)->first();

        // $request->password !== $data->password
        if (!Hash::check($request->password, $data->password)) {
            return back()->with('fail', 'Password salah!');
        }
        if ($request->confirm !== $request->new_password) {
            return back()->with('fail', 'Konfirmasi password salah!');
        }
        $newpassword = Hash::make($request->new_password);
        Nakes::where('id', $id)->update([
            'password' => $newpassword
        ]);
        
        return back()->with('update', 'Password Berhasil Diupdate');
    }

    public function roleConf(){
        $adminInfo = Nakes::where('id', session('loggedId'))->first();
        $adminRoleId = Role::where('role', 'ADMIN')->pluck('id')->first();
        $roleInfo = Role::where('id', session('loggedRole'))->first();
        
        $matrix = Role::where('id', '!=', 1)->get();
        
        return view('admin.role_configuration.index', [
            'title' => 'Konfigurasi Role',
            'infos' => $adminInfo,
            'adminRoleId' => $adminRoleId,
            'roleinfo' => $roleInfo,
            'matrix' => $matrix
        ]);
    }

    public function addRole(Request $request){
        $validator = Validator::make($request->all(), [
            'role'          => 'required|unique:roles',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('fail', 'Data Role Gagal Disimpan');
        }
        // dd($request->role);
        if ($request->role == 'ADMIN' || $request->role == 'ADMIN') {
            return redirect()->back()->withErrors($validator)->with('fail', 'Prohibited to Create Admin Role');
        }

        $no = Role::max('nomor');
        $nomor = str::padLeft($no+1, 2, '0');

        $data = [
            'koderole'          => "ROLE-".$nomor,
            'nomor'             => $nomor,
            'role'              => strtoupper($request->role),
            'pekerjaanpg'       => 'none', 
            'nakespg'           => 'none',
            'satuanpg'          => 'none',
            'tindakanpg'        => 'none',
            'obatpg'            => 'none',
            'regpasienpg'       => 'none',
            'pasienTranspg'     => 'none',
            'paymentTranspg'    => 'none',
            'profilepg'         => 'none',
        ];

        Role::create($data);
        return back()->with('success', 'Data Role Berhasil Disimpan');
    }

    public function updateRole(Request $request){
        $validator = Validator::make($request->all(), [
            'role'          => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('fail', 'Data Role Gagal Disimpan');
        }
        // dd($request->role);
        if ($request->role == 'ADMIN' || $request->role == 'ADMIN') {
            return redirect()->back()->withErrors($validator)->with('fail', 'Prohibited to Create Admin Role');
        }

        $id = $request->id;

        $data = [
            'role'              => strtoupper($request->role),
        ];

        $update = Role::where('id', $id)->update($data);
        if ($update) {
            return back()->with('update', 'Data Role Berhasil Diupdate');
        }
    }

    public function deleteRole($id){
        $roles = Role::findOrFail($id);
        $roles->delete();        
        return back()->with('delete', 'Data Role Berhasil Dihapus');
    }

    public function ubahConf(Request $request){
        
        if($request->page == 'nakespg'){
            $data = [
                'nakespg' => $request->priv
            ];
            Role::where('id', $request->id)->update($data);
        }
        else if($request->page == 'regpasienpg'){
            $data = [
                'regpasienpg' => $request->priv
            ];
            Role::where('id', $request->id)->update($data);
        }
        else if($request->page == 'pekerjaanpg'){
            $data = [
                'pekerjaanpg' => $request->priv
            ];
            Role::where('id', $request->id)->update($data);
        }
        else if($request->page == 'tindakanpg'){
            $data = [
                'tindakanpg' => $request->priv
            ];
            Role::where('id', $request->id)->update($data);
        }
        else if($request->page == 'satuanpg'){
            $data = [
                'satuanpg' => $request->priv
            ];
            Role::where('id', $request->id)->update($data);
        }
        else if($request->page == 'obatpg'){
            $data = [
                'obatpg' => $request->priv
            ];
            Role::where('id', $request->id)->update($data);
        }
        else if($request->page == 'pasienTranspg'){
            $data = [
                'pasienTranspg' => $request->priv
            ];
            Role::where('id', $request->id)->update($data);
        }
        else if($request->page == 'paymentTranspg'){
            $data = [
                'paymentTranspg' => $request->priv
            ];
            Role::where('id', $request->id)->update($data);
        }
        else if($request->page == 'profilepg'){
            $data = [
                'profilepg' => $request->priv
            ];
            Role::where('id', $request->id)->update($data);
        }
    }

    public function saveConf(){
        return back()->with('success', 'Konfigurasi Role Berhasil Diterapkan');
    }

    public function logout()
    {
        if (session()->has('loggedRole')) {
            session()->pull('loggedRole');
            return redirect('/');
        }        
    }
}
