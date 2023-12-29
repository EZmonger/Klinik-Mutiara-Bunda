<?php

namespace App\Http\Controllers;

use App\Imports\TindakanImport;
use App\Models\Matrix;
use App\Models\Nakes;
use App\Models\Role;
use App\Models\Tindakan;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TindakanAdminController extends Controller
{
    public function __construct()
    {
        $adminInfo = Nakes::where('id', session('loggedId'))->first();        
        if(!$adminInfo){            
            $this->logout();
        }
    }

    public function tindakan()
    {
        $adminInfo = Nakes::where('id', session('loggedId'))->first();
        $adminRoleId = Role::where('role', 'Admin')->pluck('id')->first();
        $roleInfo = Role::where('id', session('loggedRole'))->first();
        
        $tindakan = Tindakan::all();
        return view('admin.tindakan.index', [
            'title' => 'Tindakan',
            'infos' => $adminInfo,
            'adminRoleId' => $adminRoleId,
            'roleinfo' => $roleInfo,
            'tindakan' => $tindakan
        ]);
    }

    public function insert(Request $request)
    {
        // VALIDASI 
        $validator = Validator::make($request->all(), [
            'tindakan'  => 'required|unique:tindakans,tindakan',
            'tujuan'    => 'required',
            'harga'     => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('fail', 'Data Tindakan Gagal Disimpan');
        }

        // PENERAPAN NOMOR PADA KODE TINDAKAN 
        $no = Tindakan::max('nomor');
        $nomor = str::padLeft($no+1, 3, '0');

        // INPUT DATA 
        $data = [
            'kodetindakan'  => "TDK-".$nomor,
            'nomor'         => $nomor,
            'tindakan'      => strtoupper($request->tindakan),
            'tujuan'        => strtoupper($request->tujuan),
            'harga'         => $request->harga
        ];
        Tindakan::create($data);
        return back()->with('success', 'Data Tindakan Berhasil Disimpan');
    }

    public function update(Request $request)
    {
        // VALIDASI 
        $validator = Validator::make($request->all(), [
            'tindakan'  => 'required',
            'tujuan'    => 'required',
            'harga'     => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('fail', 'Data Tindakan Gagal Diupdate');
        }


        $id = $request->id;

        // UPDATE DATA 
        $data = [            
            'tindakan'      => strtoupper($request->tindakan),
            'tujuan'        => strtoupper($request->tujuan),
            'harga'         => $request->harga
        ];
        $update = Tindakan::where('id', $id)->update($data);
        if ($update) {
            return redirect('/tindakan')->with('update', 'Data Tindakan Berhasil Diupdate');
        }
    }

    public function delete($id)
    {
        $tindakan = Tindakan::findOrFail($id);
        
        // CARI TRANSACTION DETAIL UNTUK DELETE TINDAKAN 
        $transDetail = TransactionDetail::where('idTindakan', $id)->get();
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
        
        
        $tindakan->delete();        
        return back()->with('delete', 'Data Tindakan Berhasil Dihapus');
    }

    public function uploadtindakan(Request $request){
        $file = $request->file('excelfile');

        // IMPORT DATA EXCEL KE TINDAKAN 
        $imported = new TindakanImport;
        $imported->import($file);

        return back()->with('success', 'Data Tindakan Berhasil Diimport');
    }

    public function logout()
    {
        if (session()->has('loggedAdmin')) {
            session()->pull('loggedAdmin');                        
            return redirect('/');
        }        
    }
}
