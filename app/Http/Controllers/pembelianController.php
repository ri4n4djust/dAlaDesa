<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PembelianDetail;
use App\Pembelian;
use App\KartuStok;
use App\KartuStokInventori;
use App\Inventori;

use Illuminate\Support\Facades\DB;

class pembelianController extends Controller
{
    //
    public function index()
    {
        $posts = Pembelian::join('tblSupplier', 'tblPembelian.idSupplier', '=', 'tblSupplier.kdSupplier')
                            ->select('tblPembelian.*', 'tblSupplier.nmSupplier', 'tblSupplier.kdSupplier')
                            ->orderBy('tblPembelian.id', 'DESC')
                            ->get();
        return response([
            'success' => true,
            'message' => 'List Semua SPenjualan',
            'data' => $posts
        ], 200);
    }
    public function laporanBulanan()
    {

        $bulan = DB::table('tblPembelian as w')
                ->select(array(DB::Raw('sum(w.totalNotaPembelian) as total'),DB::Raw('w.tglNotaPembelian')))
                ->groupBy('w.tglNotaPembelian')
                ->orderBy('w.tglNotaPembelian')
                ->get();
        return response([
                    'success' => true,
                    'message' => 'List Semua SPenjualan',
                    'data' => $bulan
                ], 200);
    }
    public function laporanBulananSorting(Request $request)
    {

        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $bulan = DB::table('tblPembelian as w')
                ->select(array(DB::Raw('sum(w.totalNotaPembelian) as total'),DB::Raw('w.tglNotaPembelian')))
                ->groupBy('w.tglNotaPembelian')
                ->orderBy('w.tglNotaPembelian')
                ->whereBetween('w.tglNotaPembelian', [$startDate, $endDate])
                ->get();
                $NotalTOtal = Pembelian::whereBetween('tglNotaPembelian', [$startDate, $endDate])->sum('totalNotaPembelian');

        return response([
                    'success' => true,
                    'message' => 'List Semua SPenjualan',
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'notaSum' => $NotalTOtal,
                    'data' => $bulan
                ], 200);
    }
    public function sorting(Request $request)
    {
        //$from = date('2021/02/01');
        //$to = date('2021/02/02');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $posts = Pembelian::join('tblSupplier', 'tblPembelian.idSupplier', '=', 'tblSupplier.kdSupplier')
                            ->whereBetween('tblPembelian.tglNotaPembelian', [$startDate, $endDate])
                            ->get();
        $NotalTOtal = Pembelian::join('tblSupplier', 'tblPembelian.idSupplier', '=', 'tblSupplier.kdSupplier')
                            ->whereBetween('tblPembelian.tglNotaPembelian', [$startDate, $endDate])
                            ->sum('totalNotaPembelian');

        //$posts = Penjualan::latest()->get();
        return response([
            'success' => true,
            'message' => 'List Semua Pembelian',
            'startDate' => $startDate,
            'endDate' => $endDate,
            'notaSum' => $NotalTOtal,
            'data' => $posts
        ], 200);

    }
    public function listDetailPembelian($id)
    {
        //$post = TransaksiDetail::whereId($id)->first();
        $post = DB::table('tblPembelianDetail')
                    ->join('tblBarang', 'tblPembelianDetail.kdBarang', 'tblBarang.kdBarang')
                    ->where('tblPembelianDetail.noNotaPembelian', $id)->get();

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

    public function addItemPembelian(Request $request)
    {
        $brg = DB::table('tblPembelianDetail')
                ->where('kdBarang', $request->input('kdBarang'))
                ->where('noNotaPembelian', $request->input('noNotaPembelian'))
                ->first();
        if ($brg == null ){

            $post = PembelianDetail::create([
                'noNotaPembelian'     => $request->input('noNotaPembelian'),
                'kdBarang'     => $request->input('kdBarang'),
                'hrgPokok'     => $request->input('hrgBeli'),
                'qtyBeli'     => $request->input('qtyBeli'),
                'totalBeli'     => $request->input('totalBeli'),
                'qtySatuan'     => $request->input('qtySatuan'),
            ]);
            
            $barang = DB::table('tblBarang')->where('kdBarang', $request->input('kdBarang'))->first();
            $stokLama = $barang->stkBarang;
            $satuanKartu = $barang->satuanBarang;

            DB::table('tblBarang')->where('kdBarang', $request->input('kdBarang'))->update([
                'stkBarang'     => $stokLama + $request->input('qtyBeli'),
                'hrgPokok'     => $request->input('hrgBeli'),
            ]);

            //=======Update Tabel Inventori
            $inven = DB::table('tblInventori')->where('kdBarang', $request->input('kdBarang'))->first();
            $stokLamaInv = $inven->stkInventori;
            DB::table('tblInventori')->where('kdBarang', $request->input('kdBarang'))->update([
                //'stkInventori'     => $stokLamaInv + $request->input('qtySatuan'),
                'hrgSatuan' => $request->input('hrgSatuan'),
                'stkSatuan' => $request->input('stkSatuan'),
            ]);
            //===============================

                        
            KartuStok::create([
                'kdBarang'     => $request->input('kdBarang'),
                'tglKartu'     => $request->input('tglNotaPembelian'),
                'qtyMasuk'     => $request->input('qtyBeli'),
                'qtyKeluar'     => '0',
                'noTransaksi'     => $request->input('noNotaPembelian'),
                'keteranganKartu'     => 'Pembelian',
                'satuanKartu' => $satuanKartu,
            ]);
            /*
            KartuStokInventori::create([
                'kdBarang'     => $request->input('kdBarang'),
                'tglInv'     => $request->input('tglNotaPembelian'),
                'qtyMasukInv'     => $request->input('qtySatuan'),
                'qtyKeluarInv'     => '0',
                'noTransaksiInv'     => $request->input('noNotaPembelian'),
                'keteranganKartuInv'     => 'Pembelian',
                'satuanKartuInv' => $satuanKartu,
            ]);
            */

                return response()->json([
                    'success' => true,
                    'message' => 'Post Berhasil Disimpan!',
                ], 200);

        } else {

            //=========PembelianDetail
            $brng = DB::table('tblPembelianDetail')
                ->where('kdBarang', $request->input('kdBarang'))
                ->where('noNotaPembelian', $request->input('noNotaPembelian'))
                ->first();
            $qtyB = $brng->qtyBeli ;
            $totalB = $brng->totalBeli ;
            
            
            DB::table('tblPembelianDetail')
                ->where('kdBarang', $request->input('kdBarang'))
                ->where('noNotaPembelian', $request->input('noNotaPembelian'))
                ->update([
                    'qtyBeli' => $qtyB + $request->input('qtyBeli'),
                    'totalBeli' => $totalB + $request->input('totalBeli'),
                    ]);
            //=======Update stok tabel barang
            $barang = DB::table('tblBarang')->where('kdBarang', $request->input('kdBarang'))->first();
            $stokLama = $barang->stkBarang;
            DB::table('tblBarang')->where('kdBarang', $request->input('kdBarang'))->update([
            'stkBarang'     => $stokLama + $request->input('qtyBeli')
            ]);
            //======================
            //=======Update Tabel Inventori
            $inven = DB::table('tblInventori')->where('kdBarang', $request->input('kdBarang'))->first();
            $stokLamaInv = $inven->stkInventori;
            DB::table('tblInventori')->where('kdBarang', $request->input('kdBarang'))->update([
            'stkInventori'     => $stokLamaInv + $request->input('qtySatuan')
            ]);
            //===============================

            //=========EndPembelianDetail
            //=========Update Kartu Stok
            $brngstok = DB::table('tblKartuStok')
                ->where('kdBarang', $request->input('kdBarang'))
                ->where('noTransaksi', $request->input('noNotaPembelian'))
                ->first();
            $qtyS = $brngstok->qtyMasuk ;
            DB::table('tblKartuStok')
                ->where('kdBarang', $request->input('kdBarang'))
                ->where('noTransaksi', $request->input('noNotaPembelian'))
                ->update([
                    'qtyMasuk' => $qtyS + $request->input('qtyBeli'),
                    ]);
            //=========endKartu stok

            

                    return response()->json([
                        'success' => true,
                        'message' => 'Post Berhasil Disimpan!',
                    ], 200);

            
        }
    }

    public function listTransaksiPembelian($id)
    {
        //$post = TransaksiDetail::whereId($id)->first();
        $post = DB::table('tblPembelianDetail')
                    ->join('tblBarang', 'tblBarang.kdBarang', '=', 'tblPembelianDetail.kdBarang')
                    ->select('tblPembelianDetail.*', 'tblBarang.nmBarang')
                    ->where('noNotaPembelian', $id)->get();

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

    public function totalTrxPembelian(Request $request)
    {
        $totalNota = DB::table('tblPembelianDetail')
            ->where('noNotaPembelian', '=', $request->input('ntp'))
            ->sum('totalBeli');

        if ($totalNota) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Post!',
                'subTotalBeli'    => $totalNota
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post Tidak Ditemukan!',
                'subTotalBeli'    => ''
            ], 404);
        }
    }

    public function addTransaksiPembelian(Request $request)
    {
        $post = Pembelian::create([
            'noNotaPembelian'     => $request->input('noNotaPembelian'),
            'idSupplier'     => $request->input('idSupplier'),
            'tglNotaPembelian'     => $request->input('tglNotaPembelian'),
            'totalNotaPembelian'     => $request->input('totalNotaPembelian'),
            'userPembelian'     => $request->input('userPembelian'),
        ]);

        DB::table('tblKartuStok')
                ->where('noTransaksi', $request->input('noNotaPembelian'))
                ->update([
                    'tglKartu' => $request->input('tglNotaPembelian'),
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

    public function destroy1($id)
    {
        

        $post = PembelianDetail::findOrFail($id);

        $noNotaPembelian = $post->noNotaPembelian;
        $kodebarang = $post->kdBarang;
        $qtybarang = $post->qtyBeli;
        $qtySatuan = $post->qtySatuan;

        $barang = DB::table('tblBarang')->where('kdBarang', $kodebarang)->first();
        $stokLama = $barang->stkBarang;
        DB::table('tblBarang')->where('kdBarang', $kodebarang)->update([
                'stkBarang'     => $stokLama - $qtybarang
        ]);

        $inven = DB::table('tblInventori')->where('kdBarang', $kodebarang)->first();
        $stokLamaInv = $inven->stkInventori;
        DB::table('tblInventori')->where('kdBarang', $kodebarang)->update([
                'stkInventori'     => $stokLamaInv - $qtySatuan
        ]);

        DB::table('tblKartuStok')
            ->where('kdBarang', $kodebarang)
            ->where('noTransaksi', $noNotaPembelian)
            ->delete();
        
        DB::table('tblKartuStokInventori')
            ->where('kdBarang', $kodebarang)
            ->where('noTransaksiInv', $noNotaPembelian)
            ->delete();

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

    public function hapusPembelian($id)
    {
        $post = Pembelian::findOrFail($id);
        $kdPembelian = $post->noNotaPembelian;

        PembelianDetail::where('noNotaPembelian', $kdPembelian)->delete();

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
}
