<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;
use App\Komposisi;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class menuController extends Controller
{
    //
    public function index()
    {
        $posts = Menu::join('tblKategoriMenu', 'tblMenu.ktgMenu', 'tblKategoriMenu.kdKtgMenu')
                    ->select('tblMenu.*', 'tblKategoriMenu.nmKtgMenu')
                    ->latest()->get();
        return response([
            'success' => true,
            'message' => 'List Semua Supplier',
            'data' => $posts
        ], 200);
    }

    public function cariMenu(Request $request){
        $menuss = Menu::where('nmMenu','LIKE',''.$request->menu.'%')
                        //->take(5)
                        ->get();
        return response([
            'data' => $menuss
        ]);
    }

    public function ktgMenu()
    {
        $posts = DB::table('tblKategoriMenu')->latest()->get();
        return response([
            'success' => true,
            'message' => 'List Semua Supplier',
            'data' => $posts
        ], 200);
    }

    public function store(Request $request)
    {
        
            //$file = $request->file('gbrBarang');

            //$imageName = time().'.'.$request->name->getClientOriginalExtension();
            //$request->image->move(public_path('images'), $imageName);

            $post = Menu::create([
                'kdMenu'     => $request->input('kdMenu'),
                'nmMenu'     => $request->input('nmMenu'),
                'hargaMenu'   => $request->input('hargaMenu'),
                'ktgMenu'   => $request->input('ktgMenu'),
                'promoMenu'   => $request->input('promo'),
                'stokMenu'   => 1,
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


    public function show($id)
    {
        $post = Menu::where('kdMenu', '=', $id)->first();

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
        $post = Menu::where('kdMenu', $id)->first();

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
            'nmMenu'     => 'required'
        ],
            [
                'nmMenu.required' => 'Masukkan Nama Menu !',
            ]
        );

        if($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ],400);

        } else {

            $post = Menu::whereId($request->input('id'))->update([
                'nmMenu'     => $request->input('nmMenu'),
                'hargaMenu'   => $request->input('hargaMenu'),
                'stokMenu'   => $request->input('stokMenu'),
                'hppMenu'   => $request->input('hppMenu'),
                'ktgMenu'   => $request->input('ktgMenu'),
                'promoMenu'   => $request->input('promoMenu')
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

    public function destroy($id)
    {
        $post = Menu::findOrFail($id);
        $kodeMenu = $post->kdMenu;

        Komposisi::where('idMenu', $kodeMenu)->delete();

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
