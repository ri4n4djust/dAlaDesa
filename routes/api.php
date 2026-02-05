<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [App\Http\Controllers\loginController::class , 'login']);
Route::post('/authcek', [App\Http\Controllers\loginController::class , 'authCek']);
//====dashboard
Route::get('/awaldashboard', [App\Http\Controllers\loginController::class , 'dashboard']);

//======barang
Route::get('/posts', [App\Http\Controllers\salesController::class , 'index']);
Route::get('/semuabarang', [App\Http\Controllers\salesController::class , 'semua']);
Route::get('/mentah', [App\Http\Controllers\salesController::class , 'mentah']);
Route::post('/posts/store', [App\Http\Controllers\salesController::class , 'store']);
Route::get('/posts/{id?}', [App\Http\Controllers\salesController::class , 'show']);
Route::get('/detailbarang/{id?}', [App\Http\Controllers\salesController::class , 'showDetailBarang']);
Route::post('/posts/update/{id?}', [App\Http\Controllers\salesController::class , 'update']);
Route::delete('/posts/{id?}', [App\Http\Controllers\salesController::class , 'destroy']);

//=======kategori
Route::get('/kategori', [App\Http\Controllers\kategoriController::class , 'index']);
Route::post('/kategori/store', [App\Http\Controllers\kategoriController::class , 'store']);
Route::get('/kategori/{id?}', [App\Http\Controllers\kategoriController::class , 'show']);
Route::post('/kategori/update/{id?}', [App\Http\Controllers\kategoriController::class , 'update']);
Route::delete('/kategori/{id?}', [App\Http\Controllers\kategoriController::class , 'destroy']);

Route::get('/update-penjualan', [App\Http\Controllers\kategoriController::class , 'updatePenjualan']);
//========supplier
Route::get('/supplier', [App\Http\Controllers\supplierController::class , 'index']);
Route::post('/supplier/store', [App\Http\Controllers\supplierController::class , 'store']);
Route::get('/supplier/{id?}', [App\Http\Controllers\supplierController::class , 'show']);
Route::post('/supplier/update/{id?}', [App\Http\Controllers\supplierController::class , 'update']);
Route::delete('/supplier/{id?}', [App\Http\Controllers\supplierController::class , 'destroy']);

//========pelanggan
Route::get('/pelanggan', [App\Http\Controllers\customerController::class , 'index']);
Route::post('/pelanggan/store', [App\Http\Controllers\customerController::class , 'store']);
Route::get('/pelanggan/{id?}', [App\Http\Controllers\customerController::class , 'show']);
Route::post('/pelanggan/update/{id?}', [App\Http\Controllers\customerController::class , 'update']);
Route::delete('/pelanggan/{id?}', [App\Http\Controllers\customerController::class , 'destroy']);

//========meja
Route::get('/meja', [App\Http\Controllers\mejaController::class , 'index']);
Route::get('/mejakosong', [App\Http\Controllers\mejaController::class , 'mejakosong']);
Route::post('/meja/pindah', [App\Http\Controllers\mejaController::class , 'pindah']);
Route::post('/meja/store', [App\Http\Controllers\mejaController::class , 'store']);
Route::post('/meja/duduk', [App\Http\Controllers\mejaController::class , 'duduk']);
Route::get('/meja/{id?}', [App\Http\Controllers\mejaController::class , 'show']);
Route::get('/meja/edit/{id?}', [App\Http\Controllers\mejaController::class , 'showedit']);
Route::get('/detail/{id?}', [App\Http\Controllers\mejaController::class , 'detail']);
Route::post('/meja/update/{id?}', [App\Http\Controllers\mejaController::class , 'update']);
Route::post('/meja/cekin/{id?}', [App\Http\Controllers\mejaController::class , 'cekin']);
Route::post('/meja/cancelcekin/{id?}', [App\Http\Controllers\mejaController::class , 'cancelcekin']);
Route::delete('/meja/{id?}', [App\Http\Controllers\mejaController::class , 'destroy']);

//===========transaksi
Route::post('/editqty', [App\Http\Controllers\mejaController::class , 'editQty']);
Route::post('/addItem/store', [App\Http\Controllers\mejaController::class , 'addItem']);
Route::post('/addMenu/store', [App\Http\Controllers\mejaController::class , 'addMenu']);
Route::post('/transaksi/{id}', [App\Http\Controllers\mejaController::class , 'listTransaksi']);
Route::delete('/orderDelete/{id?}', [App\Http\Controllers\mejaController::class , 'destroy1']);
Route::delete('/deleteneworder/{id?}', [App\Http\Controllers\mejaController::class , 'destroyNewOrder']);
Route::post('/addTransaksi/store', [App\Http\Controllers\mejaController::class , 'addTransaksi']);
Route::post('/orderprint/{id}', [App\Http\Controllers\mejaController::class , 'printOrder']);
Route::post('/orderprint1/{id}', [App\Http\Controllers\mejaController::class , 'printOrder1']);
Route::post('/afterorderprint/{id}', [App\Http\Controllers\mejaController::class , 'afterPrintOrder']);
Route::post('/getprintstatus', [App\Http\Controllers\mejaController::class , 'printStatus']);

//============pembayaran
Route::post('/addSplit/store', [App\Http\Controllers\splitController::class , 'add']);
Route::get('/grouppayment/{id}', [App\Http\Controllers\penjualanController::class , 'groupPay']);

//=========total
Route::post('/totalTrx/{id}', [App\Http\Controllers\mejaController::class , 'totalTrx']);
Route::post('/totalTrxTnpPromo/{id}', [App\Http\Controllers\mejaController::class , 'totalTrxTnpPromo']);



//=======penomeran
Route::post('/noNota/{id}', [App\Http\Controllers\nomorController::class , 'noNota']);
Route::get('/kodeBarang', [App\Http\Controllers\nomorController::class , 'kodeBarang']);
Route::get('/kodeMenu', [App\Http\Controllers\nomorController::class , 'kodeMenu']);
Route::get('/kodePembelian', [App\Http\Controllers\nomorController::class , 'kodePembelian']);
Route::get('/kodeSupplier', [App\Http\Controllers\nomorController::class , 'kodeSupplier']);
Route::get('/kodePelanggan', [App\Http\Controllers\nomorController::class , 'kodePelanggan']);
Route::get('/kodeKategori', [App\Http\Controllers\nomorController::class , 'kodeKategori']);
Route::get('/kodeStokOpname', [App\Http\Controllers\nomorController::class , 'kodeStokOpname']);
Route::get('/username', [App\Http\Controllers\nomorController::class , 'kodeUsername']);


//=========Pembelian
Route::post('/addItemPembelian/store', [App\Http\Controllers\pembelianController::class , 'addItemPembelian']);
Route::post('/dataPembelian/{id}', [App\Http\Controllers\pembelianController::class , 'listTransaksiPembelian']);
Route::post('/totalTrxPembelian', [App\Http\Controllers\pembelianController::class , 'totalTrxPembelian']);
Route::delete('/pembelianDelete/{id?}', [App\Http\Controllers\pembelianController::class , 'destroy1']);
Route::post('/addPembelian/store', [App\Http\Controllers\pembelianController::class , 'addTransaksiPembelian']);

//=======live Order
Route::get('/orderlist', [App\Http\Controllers\mejaController::class , 'listOrder']);
//=======carimenu
Route::get('/carimenu', [App\Http\Controllers\menuController::class , 'cariMenu']);

//========menu
Route::get('/menu', [App\Http\Controllers\menuController::class , 'index']);
Route::get('/kategorimenu', [App\Http\Controllers\menuController::class , 'ktgMenu']);
Route::post('/menu/store', [App\Http\Controllers\menuController::class , 'store']);
Route::get('/menu/{id?}', [App\Http\Controllers\menuController::class , 'show']);
Route::get('/detailMenu/{id?}', [App\Http\Controllers\menuController::class , 'detail']);
Route::post('/menu/update/{id?}', [App\Http\Controllers\menuController::class , 'update']);
Route::delete('/menu/{id?}', [App\Http\Controllers\menuController::class , 'destroy']);

//========User
Route::get('/user', [App\Http\Controllers\loginController::class , 'index']);
Route::post('/user/store', [App\Http\Controllers\loginController::class , 'store']);
Route::get('/user/{id?}', [App\Http\Controllers\loginController::class , 'show']);
Route::post('/user/update/{id?}', [App\Http\Controllers\loginController::class , 'update']);
Route::delete('/user/{id?}', [App\Http\Controllers\loginController::class , 'destroy']);

//========komposisi
Route::get('/komposisi', [App\Http\Controllers\komposisiController::class , 'index']);
Route::get('/itemKomposisi', [App\Http\Controllers\komposisiController::class , 'allInventori']);
Route::post('/komposisi/detail/{id}', [App\Http\Controllers\komposisiController::class , 'detail']);
Route::post('/komposisi/store', [App\Http\Controllers\komposisiController::class , 'store']);
Route::delete('/komposisi/{id?}', [App\Http\Controllers\komposisiController::class , 'destroy']);

//=====Laporan Penjualan
Route::get('/penjualan', [App\Http\Controllers\penjualanController::class , 'index']);
Route::get('/penjualanbarang', [App\Http\Controllers\penjualanController::class , 'penjualanBarang']);
Route::get('/penjualanbulanan', [App\Http\Controllers\penjualanController::class , 'laporanBulanan']);
Route::post('/lapPenjualan', [App\Http\Controllers\penjualanController::class , 'sorting']);
Route::post('/lapPenjualanBarang', [App\Http\Controllers\penjualanController::class , 'sortingBarang']);
Route::post('/lapPenjualanBulanan', [App\Http\Controllers\penjualanController::class , 'laporanBulananSorting']);
Route::get('/detailpenjualan/{id}', [App\Http\Controllers\penjualanController::class , 'listDetailPenjualan']);
Route::delete('/hapuspenjualan/{id?}', [App\Http\Controllers\penjualanController::class , 'destroy']);
Route::delete('/voidPembayaran/{id?}', [App\Http\Controllers\penjualanController::class , 'destroyPembayaran']);

//=====Laporan Pembelian
Route::get('/pembelian', [App\Http\Controllers\pembelianController::class , 'index']);
Route::get('/pembelianBulanan', [App\Http\Controllers\pembelianController::class , 'laporanBulanan']);
Route::post('/lapPembelian', [App\Http\Controllers\pembelianController::class , 'sorting']);
Route::post('/lapPembelianBulanan', [App\Http\Controllers\pembelianController::class , 'laporanBulananSorting']);
Route::get('/detailpembelian/{id}', [App\Http\Controllers\pembelianController::class , 'listDetailPembelian']);
Route::delete('/hapuspembelian/{id?}', [App\Http\Controllers\pembelianController::class , 'hapusPembelian']);

//=========Stok
Route::get('/detailstok/{id}', [App\Http\Controllers\stokController::class , 'DetailStok']);
Route::post('/detailstokopname/{id}', [App\Http\Controllers\stokController::class , 'DetailStokOpname']);
Route::get('/stokopname', [App\Http\Controllers\stokController::class , 'allOpname']);
Route::post('/addItemOpname/store', [App\Http\Controllers\stokController::class , 'addItemOpname']);
Route::post('/dataStokOpname/{id}', [App\Http\Controllers\stokController::class , 'listTransaksiOpname']);
Route::get('/stokkurang', [App\Http\Controllers\stokController::class , 'stokTipis']);

Route::delete('/opnameDelete/{id?}', [App\Http\Controllers\stokController::class , 'destroy1']);
Route::post('/totalTrxOpname', [App\Http\Controllers\stokController::class , 'totalTrxOpname']);
Route::post('/addOpname/store', [App\Http\Controllers\stokController::class , 'addTransaksiOpname']);

//=========Inventori
Route::get('/inventori', [App\Http\Controllers\stokController::class , 'indexInventori']);
Route::get('/baranginventori', [App\Http\Controllers\salesController::class , 'barangInventori']);
Route::post('/detailinventori/{id}', [App\Http\Controllers\stokController::class , 'DetailInventori']);
Route::post('/detailinventoridate/{id}', [App\Http\Controllers\stokController::class , 'DetailInventoriByDate']);
Route::post('/inputInventori', [App\Http\Controllers\stokController::class , 'inputInv']);
Route::post('/dataStokInventori/{id}', [App\Http\Controllers\stokController::class , 'listTransaksiInventori']);
Route::delete('/opnameInvDelete/{id?}', [App\Http\Controllers\stokController::class , 'destroyInv']);

Route::get('/kosongkandb', [App\Http\Controllers\stokController::class , 'kosongdb']);

