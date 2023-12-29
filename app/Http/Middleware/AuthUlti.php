<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;

class AuthUlti
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('loggedId') && $request->path() != '/login') {
            return redirect('/login')->with('fail', 'Anda Belum Login');
        }
        // else {
        //     // dd(session('loggedRole'));
        // }
        if (session()->has('loggedId')) {
            $adminid = Role::where('role', 'Admin')->pluck('id')->first();
            // dd(session('loggedRole'));
            if ($request->path() == '/login') {
                return redirect('/')->with('logged', 'Anda Sudah Login');
            }
            if (session('loggedRole') != $adminid) {
                $userId = Role::where('id', session('loggedRole'))->first();
                // dd($request->path());

                //roleconfig
                if ($request->is('roleconfig') || $request->is('roleconfig/*')) {
                    // dd($request->path());
                    
                    return redirect('/login')->with('fail', 'Anda Tidak Memiliki Izin Untuk Mengakses Halaman Ini');
                }

                //pekerjaan
                if ($request->is('pekerjaan')) {
                    // dd($userId->pekerjaanpg);
                    if ($userId->pekerjaanpg == 'none') {
                        return redirect('/login')->with('fail', 'Anda Tidak Memiliki Izin Untuk Mengakses Halaman Ini');
                    }
                }
                if ($request->is('pekerjaan/delete/*')) {
                    if ($userId->pekerjaanpg != 'delete') {
                        return redirect('/login')->with('fail', 'Anda Tidak Memiliki Izin Untuk Mengakses Halaman Ini');
                    }
                }

                //member
                if ($request->is('member')) {
                    if ($userId->nakespg == 'none') {
                        return redirect('/login')->with('fail', 'Anda Tidak Memiliki Izin Untuk Mengakses Halaman Ini');
                    }
                }
                if ($request->is('member/delete/*')) {
                    if ($userId->nakespg != 'delete') {
                        return redirect('/login')->with('fail', 'Anda Tidak Memiliki Izin Untuk Mengakses Halaman Ini');
                    }
                }

                //tindakan
                if ($request->is('tindakan')) {
                    if ($userId->tindakanpg == 'none') {
                        return redirect('/login')->with('fail', 'Anda Tidak Memiliki Izin Untuk Mengakses Halaman Ini');
                    }
                }
                if ($request->is('tindakan/delete/*')) {
                    if ($userId->tindakanpg != 'delete') {
                        return redirect('/login')->with('fail', 'Anda Tidak Memiliki Izin Untuk Mengakses Halaman Ini');
                    }
                }

                //satuan
                if ($request->is('satuan')) {
                    if ($userId->satuanpg == 'none') {
                        return redirect('/login')->with('fail', 'Anda Tidak Memiliki Izin Untuk Mengakses Halaman Ini');
                    }
                }
                if ($request->is('satuan/delete/*')) {
                    if ($userId->satuanpg != 'delete') {
                        return redirect('/login')->with('fail', 'Anda Tidak Memiliki Izin Untuk Mengakses Halaman Ini');
                    }
                }

                //obat
                if ($request->is('obat')) {
                    if ($userId->obatpg == 'none') {
                        return redirect('/login')->with('fail', 'Anda Tidak Memiliki Izin Untuk Mengakses Halaman Ini');
                    }
                }
                if ($request->is('obat/delete/*')) {
                    if ($userId->obatpg != 'delete') {
                        return redirect('/login')->with('fail', 'Anda Tidak Memiliki Izin Untuk Mengakses Halaman Ini');
                    }
                }

                //pasien
                if ($request->is('pasien')) {
                    if ($userId->regpasienpg == 'none') {
                        return redirect('/login')->with('fail', 'Anda Tidak Memiliki Izin Untuk Mengakses Halaman Ini');
                    }
                }
                if ($request->is('pasien/delete/*')) {
                    if ($userId->regpasienpg != 'delete') {
                        return redirect('/login')->with('fail', 'Anda Tidak Memiliki Izin Untuk Mengakses Halaman Ini');
                    }
                }
                if ($request->is('pasien/rekamanmedisadm/*')) {
                    if ($userId->regpasienpg == 'none' || $userId->pasienTranspg == 'none' || $userId->paymentTranspg == 'none') {
                        return redirect('/login')->with('fail', 'Anda Tidak Memiliki Izin Untuk Mengakses Halaman Ini');
                    }
                }

                //datapasien
                if ($request->is('datapasien')) {
                    if ($userId->pasienTranspg == 'none') {
                        return redirect('/login')->with('fail', 'Anda Tidak Memiliki Izin Untuk Mengakses Halaman Ini');
                    }
                }
                if ($request->is('datapasien/delete/*')) {
                    if ($userId->pasienTranspg != 'delete') {
                        return redirect('/login')->with('fail', 'Anda Tidak Memiliki Izin Untuk Mengakses Halaman Ini');
                    }
                }
                if ($request->is('datapasien/inputtindakanobat/*')) {
                    if ($userId->pasienTranspg == 'view' || $userId->pasienTranspg == 'none') {
                        return redirect('/login')->with('fail', 'Anda Tidak Memiliki Izin Untuk Mengakses Halaman Ini');
                    }
                }
                if ($request->is('datapasien/from{tanggalfrom}to{tanggalto}')) {
                    if ($userId->pasienTranspg == 'none') {
                        return redirect('/login')->with('fail', 'Anda Tidak Memiliki Izin Untuk Mengakses Halaman Ini');
                    }
                }

                //pembayaran
                if ($request->is('pembayaran')) {
                    if ($userId->paymentTranspg == 'none') {
                        return redirect('/login')->with('fail', 'Anda Tidak Memiliki Izin Untuk Mengakses Halaman Ini');
                    }
                }
                if ($request->is('pembayaran/delete/*')) {
                    if ($userId->paymentTranspg != 'delete') {
                        return redirect('/login')->with('fail', 'Anda Tidak Memiliki Izin Untuk Mengakses Halaman Ini');
                    }
                }
                if ($request->is('pembayaran/from{tanggalfrom}to{tanggalto}')) {
                    if ($userId->paymentTranspg == 'none') {
                        return redirect('/login')->with('fail', 'Anda Tidak Memiliki Izin Untuk Mengakses Halaman Ini');
                    }
                }
                if ($request->is('pembayaran/invoice/*')) {
                    if ($userId->paymentTranspg == 'none') {
                        return redirect('/login')->with('fail', 'Anda Tidak Memiliki Izin Untuk Mengakses Halaman Ini');
                    }
                }
                if ($request->is('pembayaran/payment/*')) {
                    if ($userId->paymentTranspg == 'none' || $userId->paymentTranspg == 'view') {
                        return redirect('/login')->with('fail', 'Anda Tidak Memiliki Izin Untuk Mengakses Halaman Ini');
                    }
                }
                if ($request->is('downloadExcel/from{tanggalfrom}to{tanggalto}')) {
                    if ($userId->paymentTranspg == 'none') {
                        return redirect('/login')->with('fail', 'Anda Tidak Memiliki Izin Untuk Mengakses Halaman Ini');
                    }
                }

                //profile
                if ($request->is('profile')) {
                    if ($userId->profilepg == 'none') {
                        return redirect('/login')->with('fail', 'Anda Tidak Memiliki Izin Untuk Mengakses Halaman Ini');
                    }
                }
            }
        }

        if (session()->has('loggedAdmin') && $request->path() == '/login') {
        }
        return $next($request);
    }
}
