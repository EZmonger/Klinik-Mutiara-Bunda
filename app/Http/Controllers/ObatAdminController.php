<?php

namespace App\Http\Controllers;

use App\Imports\ObatImport;
use App\Models\Matrix;
use App\Models\Nakes;
use App\Models\Obat;
use App\Models\Role;
use App\Models\Satuan;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ObatAdminController extends Controller
{
    public function __construct()
    {
        $adminInfo = Nakes::where('id', session('loggedId'))->first();        
        if(!$adminInfo){            
            $this->logout();
        }
    }

    public function obat()
    {
        $adminInfo = Nakes::where('id', session('loggedId'))->first();
        $adminRoleId = Role::where('role', 'Admin')->pluck('id')->first();
        $roleInfo = Role::where('id', session('loggedRole'))->first();
        
        $obat = Obat::join('satuans', 'obats.idSatuan', '=', 'satuans.id', 'left outer')
        ->select('obats.id as obatid', 'idSatuan', 'kodeobat', 'obat', 'satuan', 'stock', 'harga')
        // ->where('obats.deleted_at', null)
        ->get();

        $satuan = Satuan::all();
        // dd($obat);
        return view('admin.obat.index', [
            'title' => 'Obat',
            'infos' => $adminInfo,
            'adminRoleId' => $adminRoleId,
            'roleinfo' => $roleInfo,          
            'obat' => $obat,
            'satuan' => $satuan
        ]);
    }

    public function insert(Request $request)
    {
        // VALIDASI INPUT
        $validator = Validator::make($request->all(), [
            'obat'  => 'required|unique:obats,obat',
            'satuan'    => 'required',
            'stock'     => 'required',
            'harga'     => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('fail', 'Data Obat Gagal Disimpan');
        }
        
        // PENERAPAN NOMOR KODE OBAT 
        $no = Obat::max('nomor');
        $nomor = str::padLeft($no+1, 3, '0');

        // INPUT DATA 
        $data = [
            'kodeobat'  => "OBT-".$nomor,
            'idSatuan'    => $request->satuan,
            'nomor'     => $nomor,
            'obat'      => $request->obat,
            'stock'     => $request->stock,
            'harga'     => $request->harga
        ];
        Obat::create($data);
        return back()->with('success', 'Data Obat Berhasil Disimpan');
    }

    public function update(Request $request)
    {
        // VALIDASI INPUT 
        $validator = Validator::make($request->all(), [
            'obat'  => 'required',
            'satuan'    => 'required',
            'harga'     => 'required'
            // 'stock'     => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('fail', 'Data Obat Gagal Diupdate');
        }


        $id = $request->id;

        // UPDATE DATA 
        $data = [            
            'obat'      => $request->obat,
            'idSatuan'    => $request->satuan,
            // 'stock'     => $request->stock,
            'harga'     => $request->harga
        ];
        $update = Obat::where('id', $id)->update($data);
        if ($update) {
            return redirect('/obat')->with('update', 'Data Obat Berhasil Diupdate');
        }
    }

    public function updateStock(Request $request)
    {
        // VALIDASI 
        $validator = Validator::make($request->all(), [
            'stock'     => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('fail', 'Stock Obat Gagal Diupdate');
        }

        $id = $request->id;

        // INPUT DATA 
        $data = [            
            'stock'     => $request->stock,
        ];
        $update = Obat::where('id', $id)->update($data);
        if ($update) {
            return redirect('/obat')->with('update', 'Stock Obat Berhasil Diupdate');
        }
    }

    public function delete($id)
    {
        // CARI OBAT 
        $obat = Obat::findOrFail($id);

        // CARI TRANSACTION DETAIL UNTUK DELETE TINDAKAN 
        $transDetail = TransactionDetail::where('idObat', $id)->get();
        foreach($transDetail as $td){
            $trans = Transaction::where('id', $td->idTransactionH);
            $transTotal = $trans->pluck('hargaTotal')->first();
            if ($transTotal == $td->hargaSubtotal) {
                $trans->delete();
            }
            elseif ($transTotal > $td->hargaSubtotal) {
                $data = [
                    'hargaTotal' => $transTotal - $td->hargaSubtotal
                ];
                $trans->update($data);
            }
        }
        
        $obat->delete();        
        return back()->with('delete', 'Data Obat Berhasil Dihapus');
    }

    public function satuan(){
        $adminInfo = Nakes::where('id', session('loggedId'))->first();
        $adminRoleId = Role::where('role', 'Admin')->pluck('id')->first();
        $roleInfo = Role::where('id', session('loggedRole'))->first();

        $satuan = Satuan::all();
        return view('admin.obat.satuan', [
            'title' => 'Satuan Obat',
            'infos' => $adminInfo,  
            'adminRoleId' => $adminRoleId,
            'roleinfo' => $roleInfo,
            'satuan' => $satuan
        ]);
    }

    public function insertSatuan(Request $request){
        // VALIDASI 
        $validator = Validator::make($request->all(), [
            'satuan' => 'required|unique:satuans,satuan',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('fail', 'Data Satuan Obat Gagal Disimpan');
        }

        // PENERAPAN NOMOR PADA KODE SATUAN 
        $no = Satuan::max('nomor');
        $nomor = str::padLeft($no+1, 2, '0');

        // INPUT DATA
        $data = [
            'kodesatuan' => "SAT-".$nomor,
            'nomor'         => $nomor,
            'satuan'     => strtoupper($request->satuan),
        ];
        Satuan::create($data);
        return back()->with('success', 'Data Satuan Obat Berhasil Disimpan');
    }

    public function updateSatuan(Request $request){
        // VALIDASI 
        $validator = Validator::make($request->all(), [
            'satuan' => 'required',            
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('fail', 'Data Satuan Obat Gagal Diupdate');
        }

        $id = $request->id;

        // UPDATE DATA 
        $data = [
            'satuan'         => strtoupper($request->satuan),
        ];
        $update = Satuan::where('id', $id)->update($data);
        if ($update) {
            return back()->with('update', 'Data Satuan Obat Berhasil Diupdate');
        }
    }

    public function deleteSatuan($id){
        $satuan = Satuan::findOrFail($id);
        $satuan->delete();        
        return back()->with('delete', 'Data Satuan Obat Berhasil Dihapus');
    }

    public function uploadobat(Request $request){
        $file = $request->file('excelfile');

        // IMPORT DATA EXCEL KE OBAT 
        $imported = new ObatImport;
        $imported->import($file);

        return back()->with('success', 'Data Obat Berhasil Diimport');
    }

    public function logout()
    {
        if (session()->has('loggedAdmin')) {
            session()->pull('loggedAdmin');                        
            return redirect('/');
        }        
    }
}
