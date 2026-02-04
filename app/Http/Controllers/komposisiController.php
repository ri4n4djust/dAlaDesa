<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Komposisi;
use Illuminate\Support\Facades\DB;

class komposisiController extends Controller
{
    //
    public function index()
    {
        //$posts = Komposisi::join('tblBarang', 'tblKomposisi.idBarang', '=', 'tblBarang.id')
         //      ->get(['tblKomposisi.*', 'tblBarang.*']);

        $posts = DB::table('tblKomposisi')
               //->where('idBarang', $id)
               ->join('tblBarang', 'tblKomposisi.kdBarang', 'tblBarang.kdBarang')
               ->get();
        //$posts = Komposisi::latest()->get();
        return response([
            'success' => true,
            'message' => 'List Semua Supplier',
            'data' => $posts
        ], 200);
    }

    public function allInventori()
    {
        $posts = DB::table('tblInventori')
               ->join('tblBarang', 'tblInventori.kdBarang', 'tblBarang.kdBarang')
               ->select('tblInventori.*', 'tblBarang.kdBarang', 'tblBarang.nmBarang', 'tblBarang.satuanBarang')
               ->get();
        //$posts = Komposisi::latest()->get();
        return response([
            'success' => true,
            'data' => $posts
        ], 200);
    }

    public function store(Request $request)
    {
            $post = Komposisi::create([
                'idMenu'     => $request->input('idMenu'),
                'idBarang'     => $request->input('idBarang'),
                'hargaBarang'     => $request->input('hargaBarang'),
                'qtyBarang'     => $request->input('qtyBarang'),
                'satuanBarang'     => $request->input('satuanBarang'),
                'totalBarang'     => $request->input('totalBarang'),
                'totalSatuan'     => $request->input('totalSatuan') ,
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

    public function detail($id)
    {
        $post = DB::table('tblKomposisi')
               ->where('tblKomposisi.idMenu', $id)
               ->join('tblBarang', 'tblKomposisi.idBarang', 'tblBarang.kdBarang')
               ->get(['tblBarang.nmBarang', 'tblKomposisi.*']);
        $sumtot = DB::table('tblKomposisi')
                ->where('idMenu', '=', $id)
               ->sum('totalBarang');
        //$post = Komposisi::where('idMenu',$id)->get();

        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Post!',
                'sumtotal' => $sumtot,
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
    public function destroy($id)
    {
        $post = Komposisi::findOrFail($id);
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
