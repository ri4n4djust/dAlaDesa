<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Meja;
use App\TransaksiDetail;
use App\Transaksi;
use App\Barang;
use App\Penjualan;
use App\KartuStok;
use App\KartuStokInventori;
use App\Pembayara;
use App\Order;
use App\Menu;
use App\Inventori;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;

class mejaController extends Controller
{
    //

    public function index()
    {
        $posts = Meja::get();
        return response([
            'success' => true,
            'message' => 'List Semua Supplier',
            'data' => $posts
        ], 200);
    }

    public function mejakosong()
    {
        $posts = Meja::where('status', '0')->get();
        return response([
            'success' => true,
            'message' => 'List Semua Supplier',
            'data' => $posts
        ], 200);
    }

    public function pindah(Request $request)
    {

        Meja::whereId($request->input('noMejaLama'))->update([
            'status'   => '0',
            'waiterMeja' => '0',
        ]);
        Meja::whereId($request->input('noMejaBaru'))->update([
            'status'   => '1',
            'waiterMeja' => $request->input('waiterMeja'),
        ]);
            $post = TransaksiDetail::where('noMejaTmp', $request->input('noMejaLama'))->update([
                'noMejaTmp'     => $request->input('noMejaBaru'),
                //'paxMeja'   => $request->input('paxMeja'),
            ]);

            Order::where('idMeja', $request->input('noMejaLama'))->update([
                'idMeja'     => $request->input('noMejaBaru'),
                //'paxMeja'   => $request->input('paxMeja'),
            ]);

            if ($post) {
                return response()->json([
                    'success' => true,
                    'message' => 'Post Berhasil Disimpan!',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Post Gagal Disimpan!',
                ], 400);
            }
        
    }

    public function store(Request $request)
    {
        //validate data
        $validator = Validator::make($request->all(), [
            'noMeja'     => 'required'
        ],
            [
                'noMeja.required' => 'Masukkan NO Meja',
            ]
        );

        if($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ],400);

        } else {
            //$file = $request->file('gbrBarang');

            //$imageName = time().'.'.$request->name->getClientOriginalExtension();
            //$request->image->move(public_path('images'), $imageName);

            $post = Meja::create([
                'noMeja'     => $request->input('noMeja'),
                'paxMeja'   => $request->input('paxMeja'),
                'status'   => 0
            ]);


            if ($post) {
                return response()->json([
                    'success' => true,
                    'message' => 'Post Berhasil Disimpan!',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Post Gagal Disimpan!',
                ], 400);
            }
        }
    }


    public function show($id)
    {
        $post = Meja::join('users', 'tblMeja.waiterMeja', 'users.id')
        ->where('tblMeja.id', $id)
        ->select('tblMeja.*', 'users.name')
        ->first();

        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Post!',
                'data'    => $post
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post Tidak Ditemukan!',
                'data'    => ''
            ], 404);
        }
    }
    public function showedit($id)
    {
        $post = Meja::where('tblMeja.id', $id)->first();
        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Post!',
                'data'    => $post
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post Tidak Ditemukan!',
                'data'    => ''
            ], 404);
        }
    }

    public function detail($id)
    {
        $post = Meja::join('users', 'tblMeja.waiterMeja', 'users.id')
        ->where('tblMeja.id', $id)
        ->select('tblMeja.*', 'users.name')
        ->first();

        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Post!',
                'data'    => $post
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post Tidak Ditemukan!',
                'data'    => ''
            ], 404);
        }
    }

    public function update(Request $request)
    {
        //validate data
        $validator = Validator::make($request->all(), [
            'noMeja'     => 'required'
        ],
            [
                'noMeja.required' => 'Masukkan No Meja!',
            ]
        );

        if($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ],400);

        } else {

            $post = Meja::whereId($request->input('id'))->update([
                'noMeja'     => $request->input('noMeja'),
                'paxMeja'   => $request->input('paxMeja'),
            ]);


            if ($post) {
                return response()->json([
                    'success' => true,
                    'message' => 'Post Berhasil Diupdate!',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Post Gagal Diupdate!',
                ], 500);
            }

        }

    }

    public function cekin(Request $request)
    {
            $post = Meja::whereId($request->input('idMeja'))->update([
                'status'   => '1',
                'waiterMeja' => $request->input('idWaiter'),
                'paxMeja' => $request->input('paxMeja'),
            ]);

            if ($post) {
                return response()->json([
                    'success' => true,
                    'message' => 'Post Berhasil Cek in!',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Post Gagal Diupdate!',
                ], 404);
            }
    }

    public function cancelcekin($id)
    {
            $post = Meja::whereId($id)->update([
                'status'   => '0',
            ]);

            if ($post) {
                return response()->json([
                    'success' => true,
                    'message' => 'Post Berhasil Cancel Cek in!',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Post Gagal Diupdate!',
                ], 404);
            }
    }

    

    public function addMenu(Request $request)
    {

        $cekorder = DB::table('tblOrder')
                ->where('kdMenu', $request->input('idBarang'))
                ->where('idMeja', $request->input('noMeja'))
                ->where('stsPrintOrder', '0')
                ->first();

        if($cekorder != null ){

            Order::where('kdMenu', $request->input('idBarang'))
                ->where('idMeja', $request->input('noMeja'))
                ->where('stsPrintOrder', '0')  
                ->update([
                'qtyOrder'   => $cekorder->qtyOrder + $request->input('qtyBarang'),
            ]);


        }else{
            Order::create([
                'kdMenu'    => $request->input('idBarang'),
                'idMeja'    => $request->input('noMeja'),
                'wktOrder'  => date("Y-m-d h:i:s"),
                'waiterOrder'   =>$request->input('waiterOrder'),
                'stsPrintOrder' => '0',
                'qtyOrder'  => $request->input('qtyBarang'),
                'noteOrder'  => $request->input('note'),
                'ktgMenuOrder'  => $request->input('ktgMenu'),

            ]);
        }
        $brg = DB::table('tblTmp_TransaksiDetail')
                ->where('kdBarangTmp', $request->input('idBarang'))
                ->where('noMejaTmp', $request->input('noMeja'))
                ->first();
        if ($brg === null ){

        $post = TransaksiDetail::create([
            'noNotaTmp'     => $request->input('noNota'),
            'noMejaTmp'     => $request->input('noMeja'),
            'kdBarangTmp'     => $request->input('idBarang'),
            'hrgJualTmp'     => $request->input('hargaJual'),
            'qtyTmp'     => $request->input('qtyBarang'),
            'totalTmp'     => $request->input('total'),
            'typeTmp'     => $request->input('type'),
            'nmBarangTmp'     => $request->input('nmBarang'),
            'note'  => $request->input('note'),
            'ktgMenu'  => $request->input('ktgMenu'),
            'promoMenu'  => $request->input('promoMenu'),
        ]);

        

                $kompo = DB::table('tblKomposisi')
                            ->where('idMenu', '=', $request->input('idBarang'))
                            ->get();
                foreach ($kompo as $k){
                        $ko = $k->idBarang;
                        $qtyCost = $k->qtyBarang * $request->input('qtyBarang');
                        $qtyCostSatuan = $k->totalSatuan * $request->input('qtyBarang'); 

                        $barang = DB::table('tblBarang')->where('kdBarang', $ko)->first();
                        $stokLama = $barang->stkBarang;
                        $satuanBarang = $barang->satuanBarang;
                        DB::table('tblBarang')->where('kdBarang', $ko)
                        ->update(array('stkBarang' => $stokLama - $qtyCost ));


                        $barangInv = DB::table('tblInventori')->where('kdBarang', $ko)->first();
                        $stokLamaInv = $barangInv->stkInventori;
                        DB::table('tblInventori')->where('kdBarang', $ko)
                        ->update(array('stkInventori' => $stokLamaInv - $qtyCostSatuan ));
                        
                        //=========Update Kartu Stok
                        KartuStok::insert([
                            'kdBarang'     => $k->idBarang,
                            'tglKartu'     => $request->input('tglNota'),
                            'qtyMasuk'     => '0',
                            'qtyKeluar'     => $qtyCost,
                            'noTransaksi'     => $request->input('noNota'),
                            'keteranganKartu'     => 'Penjualan Menu',
                            'satuanKartu' => $satuanBarang,
                        ]);
                        KartuStokInventori::insert([
                            'kdBarang'     => $k->idBarang,
                            'tglInv'     => $request->input('tglNota'),
                            'qtyMasukInv'     => '0',
                            'qtyKeluarInv'     => $qtyCostSatuan,
                            'noTransaksiInv'     => $request->input('noNota'),
                            'keteranganKartuInv'     => 'Penjualan Menu',
                            'satuanKartuInv' => $satuanBarang,
                        ]);
                        //=========endKartu stok

                }
            
                return response()->json([
                    'success' => true,
                    'komposisi' => $kompo,
                    'message' => 'Post Berhasil Disimpan!',
                ], 200);
                
            } else {

                $brng = DB::table('tblTmp_TransaksiDetail')
                ->where('kdBarangTmp', $request->input('idBarang'))
                ->where('noMejaTmp', $request->input('noMeja'))
                ->first();
                $qtyB = $brng->qtyTmp ;
                $totalB = $brng->totalTmp ;

                DB::table('tblTmp_TransaksiDetail')
                    ->where('kdBarangTmp', $request->input('idBarang'))
                    ->where('noMejaTmp', $request->input('noMeja'))
                    ->update([
                        'qtyTmp' => $qtyB + $request->input('qtyBarang'),
                        'totalTmp' => $totalB + $request->input('total'),
                        ]);
                
                $kompo = DB::table('tblKomposisi')
                        ->where('idMenu', '=', $request->input('idBarang'))
                        ->get();
                foreach ($kompo as $k){
                    $ko = $k->idBarang;
                    $qtyCost = $k->qtyBarang * $request->input('qtyBarang');
                    $qtyCostSatuan = $k->totalSatuan * $request->input('qtyBarang'); 

                    $barang = DB::table('tblBarang')->where('kdBarang', $ko)->first();
                    $stokLama = $barang->stkBarang;
                    $satuanBarang = $barang->satuanBarang;
                    DB::table('tblBarang')->where('kdBarang', $ko)
                    ->update(array('stkBarang' => $stokLama - $qtyCost ));

                    $barangInv = DB::table('tblInventori')->where('kdBarang', $ko)->first();
                    $stokLamaInv = $barangInv->stkInventori;
                    //$satuanBarang = $barang->satuanBarang;
                    DB::table('tblInventori')->where('kdBarang', $ko)
                    ->update(array('stkInventori' => $stokLamaInv - $qtyCostSatuan ));


                    KartuStok::insert([
                        'kdBarang'     => $k->idBarang,
                        'tglKartu'     => $request->input('tglNota'),
                        'qtyMasuk'     => '0',
                        'qtyKeluar'     => $qtyCost,
                        'noTransaksi'     => $request->input('noNota'),
                        'keteranganKartu'     => 'Penjualan Menu',
                        'satuanKartu' => $satuanBarang,
                    ]);
                    KartuStokInventori::insert([
                        'kdBarang'     => $k->idBarang,
                        'tglInv'     => $request->input('tglNota'),
                        'qtyMasukInv'     => '0',
                        'qtyKeluarInv'     => $qtyCostSatuan,
                        'noTransaksiInv'     => $request->input('noNota'),
                        'keteranganKartuInv'     => 'Penjualan Menu',
                        'satuanKartuInv' => $satuanBarang,
                    ]);
                    //=========endKartu stok
                
                }  

                

                return response()->json([
                    'success' => true,
                    'message' => 'Post Berhasil Disimpan!',
                ], 200);
            }
        
    }

    public function addTransaksi(Request $request)
    {
        if (Penjualan::where('noNota', $request->input('noNota'))->exists()) {
           // $count = Penjualan::all()->last();
           // $terakhir = substr($count->noNota, 11);
           // $kodeBaru = $terakhir + 1  ;
           // $tahun = date('Y');

           return response()->json([
            'success' => true,
            'message' => 'Transaksi Sudah Tersimpan',
            ], 200);
        }else{
           // $noNota = $request->input('noNota');

           try {
            $exception = DB::transaction(function() use ($request){ 
                $post = Penjualan::insert([
                    'noNota'     => $request->input('noNota'),
                    'noMeja'     => $request->input('noMeja'),
                    'tglNota'     => $request->input('tglNota'),
                    'totalNota'     => $request->input('totalNota'),
                    'taxNota'     => $request->input('taxNota'),
                    'diskonNota'     => $request->input('diskonNota'),
                    'bayarNota'     => $request->input('bayarNota'),
                    'kembalianNota'     => $request->input('kembalianNota'),
                    'pelangganNota'     => $request->input('pelanggan'),
                    'userNota'     => $request->input('userNota'),
                    'waiterNota'     => $request->input('waiterNota'),
                    'typeNota'  => $request->input('typeNota'),
                    'chargeNota'  => $request->input('chargeNota'),
                    'pax'  => $request->input('pax'),
                    'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                    'updated_at' => date("Y-m-d H:i:s", strtotime('now'))
                ]);
        
                $pembayaran = Pembayara::insert([
                    'notaPembayaran'     => $request->input('noNota'),
                    'diskonPembayaran'     => $request->input('diskonPembayaran'),
                    'pajakPembayaran'     => $request->input('pajakPembayaran'),
                    'typePembayaran'     => $request->input('typeNota'),
                    'chargePembayaran'     => $request->input('chargePembayaran'),
                    'noKartuPembayaran'     => $request->input('noKartuPembayaran')
                ]);
        
                
                $tmpTrx = DB::table('tblTmp_TransaksiDetail')->where('noMejaTmp', $request->input('noMeja'))->get();
                $dataSet = [];
                foreach ($tmpTrx as $s) {
                    $dataSet[] = [
                        'noNota'  => $request->input('noNota'),
                        'noMeja'    => $s->noMejaTmp,
                        'kdBarang'       => $s->kdBarangTmp,
                        'hrgJual' => $s->hrgJualTmp,
                        'qty' => $s->qtyTmp,
                        'total' => $s->totalTmp,
                        'type' => $s->typeTmp,
                        'nmBarang' =>$s->nmBarangTmp, 
                        'note' => $s->note,
                        'ktgMenu' => $s->ktgMenu,
                        'promoMenu' => $s->promoMenu,
                    ];
                }
                $detpost = DB::table('tblPenjualanDetail')->insert($dataSet);
        
                        // DB::table('tblMeja')->where('id', $request->input('noMeja'))->update(['status'   => '0' ,]);
                        //DB::table('tblTmp_TransaksiDetail')->where('noMejaTmp', $request->input('noMeja'))->delete();
                        DB::delete('delete from tblTmp_TransaksiDetail where noMejaTmp = ?', [$request->input('noMeja')]);
                        DB::delete('delete from tblOrder where idMeja = ?', [$request->input('noMeja')]);
                        DB::update('update tblMeja set status = ? where id = ?', ["0" , $request->input('noMeja')]);
                    
                DB::commit();
            });
            if(is_null($exception)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Post Berhasil Disimpan!',
                ], 200);
            } else {                    
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => 'Post Tidak Berhasil Disimpan!',
                ], 200);
            }
               // all good
           } catch (\Exception $e) {
               //DB::rollback();
               // something went wrong
               return response()->json([
                'success' => false,
                'message' => 'exception'.$e,
            ], 400);
           }
        }
    }

    public function listTransaksi($id)
    {
        //$post = TransaksiDetail::whereId($id)->first();
        $post = DB::table('tblTmp_TransaksiDetail')
                    ->where('noMejaTmp', $id)
                    ->orderBy('ktgMenu', 'ASC')
                    ->get();

        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Post!',
                'data'    => $post
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post Tidak Ditemukan!',
                'data'    => ''
            ], 404);
        }
    }

    public function printStatus(Request $request){

        $menu  = $request->input('kodeMenu');
        $meja = $request->input('meja');
        $data = Order::where('idMeja', $meja)->where('kdMenu', $menu)->first();
        return response()->json([
            'success' => true,
            'message' => 'Detail ststus!',
            'data'    => $data,
        ], 200);

    }

    public function listOrder()
    {
        //$post = TransaksiDetail::whereId($id)->first();
        $post = TransaksiDetail::join('tblMeja', 'tblTmp_TransaksiDetail.noMejaTmp', '=', 'tblMeja.id')
                               
                ->get();

        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Post!',
                'data'    => $post,
                'ada'   => '1'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post Tidak Ditemukan!',
                'data'    => '',
                'ada'   => '0'
            ], 404);
        }
    }

    public function printOrder($id)
    {
        //$post = TransaksiDetail::whereId($id)->first();
        $post = Order::join('tblMeja', 'tblOrder.idMeja', '=', 'tblMeja.id')
                        ->join('tblMenu', 'tblOrder.kdMenu', 'tblMenu.kdMenu')

                ->where('tblOrder.idMeja', $id)
                ->where('tblOrder.ktgMenuOrder', 'M01')
                ->where('tblOrder.stsPrintOrder', '0')
                ->select('tblMeja.noMeja', 'tblOrder.*', 'tblMenu.nmMenu')
                ->orderBy('tblOrder.id', 'ASC')
                ->get();
                return response()->json([
                    'success' => true,
                    'message' => 'Detail Post!',
                    'data'    => $post,
                    'ada'   => '1'
                ], 200);
        
    }
    public function printOrder1($id)
    {
        //$post = TransaksiDetail::whereId($id)->first();
        $post = Order::join('tblMeja', 'tblOrder.idMeja', '=', 'tblMeja.id')
                        ->join('tblMenu', 'tblOrder.kdMenu', 'tblMenu.kdMenu')

                ->where('tblOrder.idMeja', $id)
                ->where('tblOrder.ktgMenuOrder', 'M02')
                ->where('tblOrder.stsPrintOrder', '0')
                ->select('tblMeja.noMeja', 'tblOrder.*', 'tblMenu.nmMenu')
                ->orderBy('tblOrder.id', 'ASC')
                ->get();
                return response()->json([
                    'success' => true,
                    'message' => 'Detail Post!',
                    'data'    => $post,
                    'ada'   => '1'
                ], 200);
        
    }

    public function afterPrintOrder($id)
    {

        try {
            $exception = DB::transaction(function() use ($id){
            //$post = TransaksiDetail::whereId($id)->first();
                $or = Order::where('idMeja', $id)->update(['stsPrintOrder'     => '1',]);
                DB::commit();
            });
                if (is_null($exception)) {
                    $post = Order::join('tblMeja', 'tblOrder.idMeja', '=', 'tblMeja.id')
                                ->join('tblMenu', 'tblOrder.kdMenu', 'tblMenu.kdMenu')
                        ->where('tblOrder.idMeja', $id)
                        ->where('tblOrder.stsPrintOrder', '0')
                        ->select('tblMeja.noMeja', 'tblOrder.*', 'tblMenu.nmMenu')
                        ->orderBy('tblOrder.id', 'ASC')
                        ->get();
                    return response()->json([
                        'success' => true,
                        'message' => 'Detail Post!',
                        'data'    => $post
                    ], 200);
                } else {
                    DB::rollback();
                    return response()->json([
                        
                        'success' => false,
                        'message' => 'Post Tidak Ditemukan!',
                        'data'    => ''
                    ], 404);
                }
            
            } catch (\Exception $e) {
                //DB::rollback();
                // something went wrong
                return response()->json([
                 'success' => false,
                 'message' => 'exception'.$e,
             ], 400);
            }
    }

    public function totalTrx($id)
    {
        $totalNota = DB::table('tblTmp_TransaksiDetail')
            ->where('noMejaTmp', '=', $id)
            ->sum('totalTmp');

        if ($totalNota) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Post!',
                'subTotal'    => $totalNota
            ], 200);
        }
    }

    public function totalTrxTnpPromo($id)
    {
        $totalNota = DB::table('tblTmp_TransaksiDetail')
            ->where('noMejaTmp', '=', $id)
            ->where('promoMenu', '=', NULL)
            ->sum('totalTmp');

        if ($totalNota == NULL) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Post!',
                'subTotal'    => 0
            ], 200);
        }else{
            return response()->json([
                'success' => true,
                'message' => 'Detail Post!',
                'subTotal'    => $totalNota
            ], 200);
        }
    }

    public function destroy1($id)
    {
        $post = TransaksiDetail::findOrFail($id);

        $noNotaTmp = $post->noNotaTmp;
        $kodebarang = $post->kdBarangTmp;
        $qtybarang = $post->qtyTmp;

        DB::table('tblOrder')->where('kdMenu', $kodebarang)->delete();
        
        
        if (Barang::where('kdBarang', $kodebarang)->exists()) {
            // exists
            $barang = DB::table('tblBarang')->where('kdBarang', $kodebarang)->first();
            $stokLama = $barang->stkBarang;
            DB::table('tblBarang')->where('kdBarang', $kodebarang)->update([
                    'stkBarang'     => $stokLama + $qtybarang
            ]);

            $barangInv = DB::table('tblInventori')->where('kdBarang', $kodebarang)->first();
            $stokLamaInv = $barangInv->stkInventori;
            DB::table('tblInventori')->where('kdBarang', $kodebarang)->update([
                    'stkInventori'     => $stokLamaInv + $qtybarang
            ]);

            DB::table('tblOrder')->where('kdMenu', $kodebarang)->delete();

            DB::table('tblKartuStok')
                ->where('kdBarang', $kodebarang)
                ->where('noTransaksi', $noNotaTmp)
                ->where('keteranganKartu', 'Penjualan')
                ->delete();
                
            DB::table('tblKartuStokInventori')
                ->where('kdBarang', $kodebarang)
                ->where('noTransaksiInv', $noNotaTmp)
                ->where('keteranganKartuInv', 'Penjualan')
                ->delete();

            $post->delete();
            return response()->json([
                'success' => true,
                'message' => 'Post Berhasil Dihapus!',
            ], 200);

        } else {

            $kompo = DB::table('tblKomposisi')
                        ->where('idMenu', '=', $kodebarang)
                        ->get();
            foreach ($kompo as $k){
                    $ko = $k->idBarang;
                    $qtyCost = $k->qtyBarang * $qtybarang;
                    $qtyCostSatuan = $k->totalSatuan * $qtybarang;


                    $barang = DB::table('tblBarang')->where('kdBarang', $ko)->first();
                    $stokLama = $barang->stkBarang;
                    $satuanBarang = $barang->satuanBarang;
                    DB::table('tblBarang')->where('kdBarang', $ko)
                    ->update(array('stkBarang' => $stokLama + $qtyCost ));

                    $barangInv = DB::table('tblInventori')->where('kdBarang', $ko)->first();
                    $stokLamaInv = $barangInv->stkInventori;
                    //$satuanBarang = $barang->satuanBarang;
                    DB::table('tblInventori')->where('kdBarang', $ko)
                    ->update(array('stkInventori' => $stokLamaInv + $qtyCostSatuan ));

                    //=========Update Kartu Stok
                    DB::table('tblKartuStok')
                        ->where('kdBarang', $ko)
                        ->where('noTransaksi', $noNotaTmp)
                        ->where('keteranganKartu', 'Penjualan Menu')
                        ->delete();
                    DB::table('tblKartuStokInventori')
                        ->where('kdBarang', $ko)
                        ->where('noTransaksiInv', $noNotaTmp)
                        ->where('keteranganKartuInv', 'Penjualan Menu')
                        ->delete();
                    //=========endKartu stok

            }

        
            $post->delete();
            return response()->json([
                'success' => true,
                'message' => 'Post Berhasil Dihapus!',
            ], 200);
        }
        
    }

    public function destroyNewOrder($id)
    {
        $post = Order::findOrFail($id);
        

        $noNotaTmp = $post->idMeja;
        $kodebarang = $post->kdMenu;
        $qtybarang = $post->qtyOrder;

        // DB::table('tblOrder')->where('kdMenu', $kodebarang)->delete();
        // $barang = DB::table('tblBarang')->where('kdBarang', $kodebarang)->first();
        // $stokLama = $barang->stkBarang;
        // DB::table('tblBarang')->where('kdBarang', $kodebarang)->update([
        //         'stkBarang'     => $stokLama + $qtybarang
        // ]);
        
        
        // if (Barang::where('kdBarang', $kodebarang)->exists()) {
        //     // exists

        //     $barangInv = DB::table('tblInventori')->where('kdBarang', $kodebarang)->first();
        //     $stokLamaInv = $barangInv->stkInventori;
        //     DB::table('tblInventori')->where('kdBarang', $kodebarang)->update([
        //             'stkInventori'     => $stokLamaInv + $qtybarang
        //     ]);

        //     $barangTrx = DB::table('tblTmp_TransaksiDetail')
        //     ->where('kdBarangTmp', $kodebarang)
        //     ->where('noMejaTmp', $noNotaTmp)
        //     ->first();
        //     $orderT = $barangTrx->qtyTmp;
        //     if($orderT-$qtybarang == 0){
        //         DB::table('tblTmp_TransaksiDetail')
        //         ->where('kdBarangTmp', $kodebarang)
        //         ->where('noMejaTmp', $noNotaTmp)
        //         ->delete();
        //     }else{
        //         DB::table('tblTmp_TransaksiDetail')
        //         ->where('kdBarangTmp', $kodebarang)
        //         ->where('noMejaTmp', $noNotaTmp)
        //         ->update([
        //                 'qtyTmp'     => $orderT - $qtybarang
        //         ]);
        //     }

        //     // DB::table('tblOrder')->where('kdMenu', $kodebarang)->delete();

        //     DB::table('tblKartuStok')
        //         ->where('kdBarang', $kodebarang)
        //         ->where('noTransaksi', $noNotaTmp)
        //         ->where('keteranganKartu', 'Penjualan')
        //         ->delete();
                
        //     DB::table('tblKartuStokInventori')
        //         ->where('kdBarang', $kodebarang)
        //         ->where('noTransaksiInv', $noNotaTmp)
        //         ->where('keteranganKartuInv', 'Penjualan')
        //         ->delete();

        //     $post->delete();
        //     return response()->json([
        //         'success' => true,
        //         'message' => 'Post Berhasil Dihapus!',
        //     ], 200);

        // } else {

            $kompo = DB::table('tblKomposisi')
                        ->where('idMenu', '=', $kodebarang)
                        ->get();
            foreach ($kompo as $k){
                    $ko = $k->idBarang;
                    $qtyCost = $k->qtyBarang * $qtybarang;
                    $qtyCostSatuan = $k->totalSatuan * $qtybarang;


                    $barang = DB::table('tblBarang')->where('kdBarang', $ko)->first();
                    $stokLama = $barang->stkBarang;
                    $satuanBarang = $barang->satuanBarang;
                    DB::table('tblBarang')->where('kdBarang', $ko)
                    ->update(array('stkBarang' => $stokLama + $qtyCost ));

                    $barangInv = DB::table('tblInventori')->where('kdBarang', $ko)->first();
                    $stokLamaInv = $barangInv->stkInventori;
                    //$satuanBarang = $barang->satuanBarang;
                    DB::table('tblInventori')->where('kdBarang', $ko)
                    ->update(array('stkInventori' => $stokLamaInv + $qtyCostSatuan ));

                    

                    //=========Update Kartu Stok
                    DB::table('tblKartuStok')
                        ->where('kdBarang', $ko)
                        ->where('noTransaksi', $noNotaTmp)
                        ->where('keteranganKartu', 'Penjualan Menu')
                        ->delete();
                    DB::table('tblKartuStokInventori')
                        ->where('kdBarang', $ko)
                        ->where('noTransaksiInv', $noNotaTmp)
                        ->where('keteranganKartuInv', 'Penjualan Menu')
                        ->delete();
                    //=========endKartu stok

            }

            $barangTrx = DB::table('tblTmp_TransaksiDetail')
            ->where('kdBarangTmp', $kodebarang)
            ->where('noMejaTmp', $noNotaTmp)
            ->first();
            $orderT = $barangTrx->qtyTmp;
            $hrgT = $barangTrx->hrgJualTmp;
            $nqty = $orderT - $qtybarang;
            if($orderT-$qtybarang == 0){
                DB::table('tblTmp_TransaksiDetail')
                ->where('kdBarangTmp', $kodebarang)
                ->where('noMejaTmp', $noNotaTmp)
                ->delete();
            }else{
                DB::table('tblTmp_TransaksiDetail')
                ->where('kdBarangTmp', $kodebarang)
                ->where('noMejaTmp', $noNotaTmp)
                ->update([
                        'qtyTmp'     => $nqty,
                        'totalTmp'    => $nqty * $hrgT
                ]);
            }

        
            $post->delete();
            return response()->json([
                'success' => true,
                'message' => 'Post Berhasil Dihapus!',
            ], 200);
        // }
        
    }

    public function destroy($id)
    {
        $post = Meja::findOrFail($id);
        $post->delete();

        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Post Berhasil Dihapus!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post Gagal Dihapus!',
            ], 500);
        }
    }

    public function editQty(Request $request){
        $id = $request->input('id');
        $nqty = $request->input('qty');
        $post = TransaksiDetail::findOrFail($id);
        $harga = $post->hrgJualTmp ;
        $idmeja = $post->noMejaTmp ;
        $idMenu = $post->kdBarangTmp ;
        TransaksiDetail::where('id', $id)->update([
            'qtyTmp' => $nqty,
            'totalTmp' => $nqty * $harga
        ]);
        Order::where('kdMenu', $idMenu)->where('idMeja', $idmeja)->update([
            'qtyOrder' => $nqty ,
            'stsPrintOrder' => '0'
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Post Berhasil diubah!',
            // 'data' => $harga
        ], 200);

    }
}
