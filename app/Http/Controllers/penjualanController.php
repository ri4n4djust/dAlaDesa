<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penjualan;
use App\PenjualanDetail;
use App\Pembayara;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class penjualanController extends Controller
{
    //
    public function index()
    {
        $posts = Penjualan::join('tblMeja', 'tblPenjualan.noMeja', 'tblMeja.id')
                ->join('tblPembayaran', 'tblPenjualan.noNota', 'tblPembayaran.notaPembayaran')
                ->join('users', 'tblPenjualan.userNota', 'users.id')
                ->select('tblPenjualan.*', 'tblMeja.noMeja', 'users.name', 
                'tblPembayaran.pajakPembayaran', 'tblPembayaran.diskonPembayaran',
                'tblPembayaran.typePembayaran', 'tblPembayaran.chargePembayaran', 'tblPembayaran.noKartuPembayaran')
                ->orderBy('tblPenjualan.id', 'DESC')
                ->take(2000)
                ->get();
        return response([
            'success' => true,
            'message' => 'List Semua SPenjualan',
            'data' => $posts
        ], 200);
    }
    public function penjualanBarang()
    {
        $posts = DB::select("SELECT tblPenjualanDetail.kdBarang, tblPenjualanDetail.qty, tblPenjualanDetail.nmBarang, tblPenjualan.tglNota, tblPenjualan.noNota 
                            FROM tblPenjualanDetail, tblPenjualan 
                            WHERE tblPenjualan.noNota = tblPenjualanDetail.noNota 
                            ORDER BY tblPenjualan.tglNota DESC
                            Limit 2000");
                // ->take(2000)
                // ->get();
        return response([
            'success' => true,
            'message' => 'List Semua SPenjualanBarang',
            'data' => $posts
        ], 200);
    }
    public function groupPay($id){
        $pay = DB::table('splitPayment as w')
                ->select(array(DB::Raw('sum(w.hrgBarang) as harga'),DB::Raw('sum(w.subTotal) as total'),DB::Raw('w.groupNota')))
                ->groupBy('w.groupNota')
                ->where('w.noNota', $id)
                ->get();
        $brg = DB::table('splitPayment')
                ->select(array(DB::Raw('*')))
                ->where('noNota', $id)
                ->get();
        return response([
                    'success' => true,
                    'message' => 'List Semua group',
                    'data' => $pay,
                    'databarang' => $brg
                ], 200);
    }
    public function laporanBulanan(Request $request)
    {

        $bulan = DB::table('tblPenjualan as w')
                ->select(array(DB::Raw('sum(w.totalNota) as total'),DB::Raw('sum(w.taxNota) as ppn'),DB::Raw('sum(w.diskonNota) as diskon'),DB::Raw('sum(w.chargeNota) as charge'),DB::Raw('w.tglNota')))
                ->groupBy('w.tglNota')
                ->orderBy('w.tglNota')
                ->get();
        return response([
                    'success' => true,
                    'message' => 'List Semua SPenjualan',
                    'data' => $bulan
                ], 200);
    }
    public function laporanBulananSorting(Request $request)
    {

        $startDate1 = $request->input('startDate');
        $endDate1 = $request->input('endDate');
        $startDate = $startDate1." 00:00:00";
        $endDate = $endDate1." 23:59:59";
        // $startDate = $request->input('startDate');
        // $endDate = $request->input('endDate');

        $bulan = DB::table('tblPenjualan as w')
                ->select(array(DB::Raw('sum(w.totalNota) as total'),DB::Raw('sum(w.pax) as pax'),DB::Raw('sum(w.taxNota) as ppn'),DB::Raw('sum(w.diskonNota) as diskon'),DB::Raw('sum(w.chargeNota) as charge'),DB::Raw('w.tglNota')))
                ->groupBy('w.tglNota')
                ->orderBy('w.tglNota')
                ->whereBetween('w.tglNota', [$startDate, $endDate])
                ->get();
                $NotalTOtal = Penjualan::whereBetween('tglNota', [$startDate, $endDate])->sum('totalNota');
                $pajakSum = Penjualan::whereBetween('tglNota', [$startDate, $endDate])->sum('taxNota');
                $diskonSum = Penjualan::whereBetween('tglNota', [$startDate, $endDate])->sum('diskonNota');
                $chargeSum = Penjualan::whereBetween('tglNota', [$startDate, $endDate])->sum('chargeNota');
                $paxSum = Penjualan::whereBetween('tglNota', [$startDate, $endDate])->sum('pax');

        return response([
                    'success' => true,
                    'message' => 'List Semua SPenjualan',
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'notaSum' => $NotalTOtal,
                    'pajakSum' => $pajakSum,
                    'diskonSum' => $diskonSum,
                    'chargeSum' => $chargeSum,
                    'paxSum' => $paxSum,
                    'data' => $bulan
                ], 200);
    }
    public function sorting(Request $request)
    {
        //$from = date('2021/02/01');
        //$to = date('2021/02/02');
        $startDate1 = $request->input('startDate');
        $endDate1 = $request->input('endDate');
        $startDate = $startDate1." 00:00:00";
        $endDate = $endDate1." 23:59:59";
        $cr = $request->input('typeNotaCari');
        $crpel = $request->input('typePelangganCari');
        if($cr == 0 && $crpel == 'Cash'){
            $posts = Penjualan::whereBetween('tglNota', [$startDate, $endDate])->get();
            $NotalTOtal = Penjualan::whereBetween('tglNota', [$startDate, $endDate])->sum('totalNota');
            $pajakSum = Penjualan::whereBetween('tglNota', [$startDate, $endDate])->sum('taxNota');
            $diskonSum = Penjualan::whereBetween('tglNota', [$startDate, $endDate])->sum('diskonNota');
            $paxSum = Penjualan::whereBetween('tglNota', [$startDate, $endDate])->sum('pax'); 
            
            //$posts = Penjualan::latest()->get();
        return response([
            'success' => true,
            'message' => 'List Semua SPenjualan',
            'startDate' => $startDate,
            'endDate' => $endDate,
            'notaSum' => $NotalTOtal,
            'pajakSum' => $pajakSum,
            'diskonSum' => $diskonSum,
            'paxSum' => $paxSum,
            'data' => $posts
        ], 200);
        }else{
            $posts = Penjualan::whereBetween('tglNota', [$startDate, $endDate])
                                ->where('typeNota', $cr)
                                ->where('pelangganNota', $crpel)
                                ->get();
            $NotalTOtal = Penjualan::whereBetween('tglNota', [$startDate, $endDate])
                                ->where('typeNota', $cr)
                                ->where('pelangganNota', $crpel)
                                ->sum('totalNota');
            $pajakSum = Penjualan::whereBetween('tglNota', [$startDate, $endDate])
                                ->where('typeNota', $cr)
                                ->where('pelangganNota', $crpel)
                                ->sum('taxNota');
            $diskonSum = Penjualan::whereBetween('tglNota', [$startDate, $endDate])
                                ->where('typeNota', $cr)
                                ->where('pelangganNota', $crpel)
                                ->sum('diskonNota');

        //$posts = Penjualan::latest()->get();
        return response([
            'success' => true,
            'message' => 'List Semua SPenjualan',
            'startDate' => $startDate,
            'endDate' => $endDate,
            'notaSum' => $NotalTOtal,
            'pajakSum' => $pajakSum,
            'diskonSum' => $diskonSum,
            'data' => $posts
        ], 200);
        }
    }
    public function sortingBarang(Request $request)
    {
        //$from = date('2021/02/01');
        //$to = date('2021/02/02');
        $startDate1 = $request->input('startDate');
        $endDate1 = $request->input('endDate');
        $startDate = $startDate1." 00:00:00";
        $endDate = $endDate1." 23:59:59";
        $cr = $request->input('namaMenu');
        if($cr == ''){
            $posts = DB::select("SELECT tblPenjualanDetail.kdBarang, tblPenjualanDetail.qty, tblPenjualanDetail.nmBarang, tblPenjualan.tglNota, tblPenjualan.noNota 
                            FROM tblPenjualanDetail, tblPenjualan 
                            WHERE tblPenjualan.noNota = tblPenjualanDetail.noNota 
                            AND tblPenjualan.tglNota BETWEEN '$startDate' AND '$endDate'
                            ORDER BY tblPenjualan.tglNota DESC
                            Limit 50");
            $NotalTOtal = DB::select("SELECT SUM(qty) total FROM( SELECT tblPenjualanDetail.kdBarang, tblPenjualanDetail.qty as qty, tblPenjualanDetail.nmBarang, tblPenjualan.tglNota, tblPenjualan.noNota 
                            FROM tblPenjualanDetail, tblPenjualan 
                            WHERE tblPenjualan.noNota = tblPenjualanDetail.noNota 
                            AND tblPenjualan.tglNota BETWEEN '$startDate' AND '$endDate'
                            ORDER BY tblPenjualan.tglNota DESC
                            Limit 50) as sc WHERE sc.kdBarang != '';");
            
            //$posts = Penjualan::latest()->get();
            return response([
                'success' => true,
                'message' => 'List Semua SPenjualan Barang',
                'startDate' => $startDate,
                'endDate' => $endDate,
                'totalSum' => $NotalTOtal[0]->total,
                'data' => $posts
            ], 200);
        }else{
            $posts = DB::select("SELECT tblPenjualanDetail.kdBarang, tblPenjualanDetail.qty as qty, tblPenjualanDetail.nmBarang, tblPenjualan.tglNota, tblPenjualan.noNota 
                        FROM tblPenjualanDetail, tblPenjualan 
                        WHERE tblPenjualan.noNota = tblPenjualanDetail.noNota 
                        AND tblPenjualan.tglNota BETWEEN '$startDate' AND '$endDate'
                        AND tblPenjualanDetail.kdBarang = '$cr'
                        ORDER BY tblPenjualan.tglNota DESC");
            $NotalTOtal = DB::select("SELECT SUM(qty) total FROM( SELECT tblPenjualanDetail.kdBarang, tblPenjualanDetail.qty as qty, tblPenjualanDetail.nmBarang, tblPenjualan.tglNota, tblPenjualan.noNota 
                        FROM tblPenjualanDetail, tblPenjualan 
                        WHERE tblPenjualan.noNota = tblPenjualanDetail.noNota 
                        AND tblPenjualan.tglNota BETWEEN '$startDate' AND '$endDate'
                        ORDER BY tblPenjualan.tglNota DESC) as sc WHERE sc.kdBarang = '$cr' ");
            //$posts = Penjualan::latest()->get();
            return response([
                'success' => true,
                'message' => 'List Semua SPenjualan',
                'startDate' => $startDate,
                'endDate' => $endDate,
                'totalSum' => $NotalTOtal[0]->total,
                'data' => $posts
            ], 200);
        }
    }
    public function listDetailPenjualan($id)
    {
        //$post = TransaksiDetail::whereId($id)->first();
        $post = DB::table('tblPenjualanDetail')
                    ->where('noNota', $id)->get();
        $total = DB::table('tblPenjualanDetail')
                    ->where('noNota', $id)->sum('total');

        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Post!',
                'data'    => $post,
                'total' => $total
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post Tidak Ditemukan!',
                'data'    => ''
            ], 404);
        }
    }
    
    public function destroy($id)
    {
        $post = Penjualan::findOrFail($id);
        $kdPenjualan = $post->noNota;

        PenjualanDetail::where('noNota', $kdPenjualan)->delete();
        Pembayara::where('notaPembayaran', $kdPenjualan)->delete();

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

    public function destroyPembayaran($id)
    {
        
        $post = Penjualan::findOrFail($id);
        $kdPenjualan = $post->noNota;
        $noMeja = $post->noMeja;
        $pax = $post->pax;

        $kodisiMeja = DB::table('tblMeja')->where('id', $noMeja)->first();
        if($kodisiMeja->status === '1'){
            return response()->json([
                'success' => false,
                'message' => 'Meja blm kosong',
            ], 500);
        }else{

            $tmpTrx = DB::table('tblPenjualanDetail')
                        ->where('noMeja', $noMeja)
                        ->where('noNota', $kdPenjualan)->get();
            $dataSet = [];
            foreach ($tmpTrx as $s) {
                $dataSet[] = [
                    'noNotaTmp'     => $kdPenjualan,
                    'noMejaTmp'     => $s->noMeja,
                    'kdBarangTmp'     => $s->kdBarang,
                    'hrgJualTmp'     => $s->hrgJual,
                    'qtyTmp'     => $s->qty,
                    'totalTmp'     => $s->total,
                    'typeTmp'     => $s->type,
                    'nmBarangTmp'     => $s->nmBarang, 
                    'note'  => $s->note, 
                    'ktgMenu'  => $s->ktgMenu,
                    'promoMenu'  => $s->promoMenu,
                ];
            }
            $detpost = DB::table('tblTmp_TransaksiDetail')->insert($dataSet);

            DB::table('tblMeja')->where('id', $noMeja)->update([
                'status' => '1',
                'paxMeja' => $pax,
            ]);

            PenjualanDetail::where('noNota', $kdPenjualan)->delete();
            Pembayara::where('notaPembayaran', $kdPenjualan)->delete();

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
}
