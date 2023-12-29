<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUltController;
use App\Http\Controllers\TindakanController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\NakesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ObatAdminController;
use App\Http\Controllers\ObatNakesController;
use App\Http\Controllers\TindakanAdminController;
use App\Http\Controllers\TindakanNakesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login.login');
});

Route::get('/login', function () {
    return view('login.login');
});

Route::post('/signin', [AuthController::class, 'signin']);
Route::get('/logoutadminult', [AdminUltController::class, 'logout']);


//MENGGUNAKAN GROUP MIDDLEWARE
Route::group(['middleware' => ['AuthUlti']], function () {

    // GROUP HALAMAN INDEX 
    // NOTE (
    //     - ROUTE INPUT TRANSAKSI PASIEN DI GRUP HALAMAN DATAPASIEN 
    //     - DETAIL TOTAL PASIEN DI GRUP DATA PASIEN
    //     - DETAIL TOTAL PEMBAYARAN DI GRUP PEMBAYARAN
    // )
    Route::prefix('index')->group(function() {
        Route::get('/', [AdminUltController::class, 'index']);
        Route::post('/', [AdminUltController::class, 'index'])->name('admin.berandasearch');
        Route::post('obat', [AdminUltController::class, 'indexObat']);
        Route::post('tindakan', [AdminUltController::class, 'indexTindakan']);
    });

    //ROLE CONFIGURATION
    Route::prefix('roleconfig')->group(function() {
        Route::get('/', [AdminUltController::class, 'roleConf']);
        Route::post('/add', [AdminUltController::class, 'addRole'])->name('role.add');
        Route::post('/edit', [AdminUltController::class, 'updateRole'])->name('role.edit');
        Route::get('/delete/{id}', [AdminUltController::class, 'deleteRole']);
        Route::post('/ubahconfig', [AdminUltController::class, 'ubahConf']);
        Route::get('/saveconfig', [AdminUltController::class, 'saveConf']);
    });

    //PEKERJAAN
    Route::prefix('pekerjaan')->group(function() {
        Route::get('/', [AdminUltController::class, 'pekerjaan']);
        Route::post('add', [AdminUltController::class, 'addpekerjaan'])->name('pekerjaan.add');
        Route::post('update', [AdminUltController::class, 'updatepekerjaan'])->name('pekerjaan.update');
        Route::get('delete/{id}', [AdminUltController::class, 'deletepekerjaan']);
    });

    //MEMBER/NAKES
    Route::prefix('member')->group(function() {
        Route::get('/', [AdminUltController::class, 'tenakes']);
        Route::post('/add', [AdminUltController::class, 'insertnakes'])->name('member.add');
        Route::post('/update', [AdminUltController::class, 'updatenakes'])->name('member.update');
        Route::post('/resetPassword', [AdminUltController::class, 'updatepasswordnakes'])->name('member.resetPassword');
        Route::get('/delete/{id}', [AdminUltController::class, 'deletenakes']);
    });

    //TINDAKAN
    Route::prefix('tindakan')->group(function() {
        Route::get('/', [TindakanAdminController::class, 'tindakan']);
        Route::post('/add', [TindakanAdminController::class, 'insert'])->name('tindakan.add');
        Route::post('/update', [TindakanAdminController::class, 'update'])->name('tindakan.update');
        Route::get('/delete/{id}', [TindakanAdminController::class, 'delete']);
        Route::post('/uploadTindakan', [TindakanAdminController::class, 'uploadtindakan'])->name('tindakan.import');
    });

    //SATUAN
    Route::prefix('satuan')->group(function() {
        Route::get('/', [ObatAdminController::class, 'satuan']);
        Route::post('/add', [ObatAdminController::class, 'insertSatuan'])->name('satuan.add');
        Route::post('/updateData', [ObatAdminController::class, 'updateSatuan'])->name('satuan.update');
        Route::get('/delete/{id}', [ObatAdminController::class, 'deleteSatuan']);
    });

    //OBAT
    Route::prefix('obat')->group(function() {
        Route::get('/', [ObatAdminController::class, 'obat']);
        Route::post('/add', [ObatAdminController::class, 'insert'])->name('obat.add');
        Route::post('/updateData', [ObatAdminController::class, 'update'])->name('obat.update');
        Route::post('/updateStock', [ObatAdminController::class, 'updateStock'])->name('obat.updateStock');
        Route::get('/delete/{id}', [ObatAdminController::class, 'delete']);
        Route::post('/uploadObat', [ObatAdminController::class, 'uploadobat'])->name('obat.import');
    });

    //PASIEN
    Route::prefix('pasien')->group(function() {
        Route::get('/', [AdminUltController::class, 'pasiens']);
        Route::post('/', [AdminUltController::class, 'pasiens'])->name('pasien.search');
        Route::post('/add', [AdminUltController::class, 'insertpasiens'])->name('pasien.add');
        Route::post('/update', [AdminUltController::class, 'updatepasiens'])->name('pasien.update');
        Route::get('/delete/{id}', [AdminUltController::class, 'deletepasiens']);
        Route::get('/rekamanmedisadm/{id}', [AdminUltController::class, 'rekamanmedis']);
        Route::post('/rekamanmedisadm/{id}', [AdminUltController::class, 'rekamanmedis'])->name('rekamanmedis.search');
        
    });
    
    //DATAPASIEN
    Route::prefix('datapasien')->group(function() {
        Route::get('/', [AdminUltController::class, 'datapasiens']);
        Route::post('/', [AdminUltController::class, 'datapasiens'])->name('datapasien.search');
        Route::get('/from{tanggalfrom}to{tanggalto}', [AdminUltController::class, 'datapasiensDashboard']);
        Route::post('/add', [AdminUltController::class, 'insertdataps'])->name('datapasien.add');
        Route::post('/update', [AdminUltController::class, 'updatedataps'])->name('datapasien.update');
        Route::get('/inputtindakanobat/{id}', [AdminUltController::class, 'inputtindakanobatmenu']);
        Route::post('/addtindakanobat', [AdminUltController::class, 'inputtindakanobat'])->name('datapasien.addtindakanobat');
        Route::get('/delete/{id}', [AdminUltController::class, 'deletedataps']);
    });
    Route::post('/getPasien', [AdminUltController::class, 'getPasien']);

    //PEMBAYARAN
    Route::prefix('pembayaran')->group(function() {
        Route::get('/', [AdminUltController::class, 'pembayaran']);
        Route::post('/', [AdminUltController::class, 'pembayaran'])->name('pembayaran.search');
        Route::get('/from{tanggalfrom}to{tanggalto}', [AdminUltController::class, 'pembayaranDashboard']);
        Route::post('/detail', [AdminUltController::class, 'pembayaran_detail']);
        Route::get('/payment/{id}', [AdminUltController::class, 'payment']);
        Route::get('/invoice/{id}', [AdminUltController::class, 'invoice']);
        Route::get('/delete/{id}', [AdminUltController::class, 'deletePembayaran']);
    });
    Route::get('/downloadExcel/from{fromDate}to{toDate}', [AdminUltController::class, 'downloadExcel']);

    //PROFILE 
    // NOTE (
    //     UPDATE PROFILE DI MEMBER/NAKES
    // )
    Route::get('/profile', [AdminUltController::class, 'profil']);
    Route::post('/ubahSandi', [AdminUltController::class, 'ubahPassword']);

    //LOGOUT
    Route::post('/logoutadminult', [AdminUltController::class, 'logout']);
    
});

