<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kategori;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Penjualan;

class kategoriController extends Controller
{
    //
    public function index()
    {
        $data = Kategori::get();
        return response([
            'success' => true,
            'message' => 'List Semua Kategori',
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        //validate data
        $validator = Validator::make($request->all(), [
            'kodeKtg'     => 'required',
        ],
            [
                'kodeKtg.required' => 'Masukkan Nama Kategori',
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

            $post = Kategori::create([
                'kodeKtg'     => $request->input('kodeKtg'),
                'namaKtg'     => $request->input('namaKtg'),
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
        $post = Kategori::whereId($id)->first();

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
            'kodeKtg'     => 'required',
        ],
            [
                'kodeKtg.required' => 'Masukkan Nama Kategori !',
            ]
        );

        if($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ],400);

        } else {

            $post = Kategori::whereId($request->input('id'))->update([
                'namaKtg'   => $request->input('namaKtg'),
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
        $post = Kategori::findOrFail($id);
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

    public function updatePenjualan()
    {
        $post = Penjualan::whereBetween('tglNota', ['2023/10/01', '2023/10/25'])->get(['tglNota']);
        
        for($i=0; $i<count($post); $i++){
            echo $post[$i]->tglNota.'<br>';
            $old_date = $post[$i]->tglNota ;
            Penjualan::where('tglNota', $old_date)->update([
                'tglNota' => $old_date.' 18:30:00',
            ]);
        }
        
    }

}
