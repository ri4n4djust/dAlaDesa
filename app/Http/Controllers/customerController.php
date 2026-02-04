<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pelanggan;
use App\Barang;

use Illuminate\Support\Facades\Validator;

class customerController extends Controller
{
    //
    public function index()
    {
        $posts = Pelanggan::latest()->get();
        return response([
            'success' => true,
            'message' => 'List Semua Pelanggan',
            'data' => $posts
        ], 200);
    }

    public function store(Request $request)
    {
        //validate data
        $validator = Validator::make($request->all(), [
            'nmPelanggan'     => 'required',
            'noHpPelanggan'   => 'required',
        ],
            [
                'nmPelanggan.required' => 'Masukkan Nama Pelanggan',
                'noHpPelanggan.required' => 'Masukkan No Hp Pelanggan !',
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

            $post = Pelanggan::create([
                'kdPelanggan'     => $request->input('kdPelanggan'),
                'nmPelanggan'     => $request->input('nmPelanggan'),
                'almtPelanggan'   => $request->input('almtPelanggan'),
                'noHpPelanggan'   => $request->input('noHpPelanggan'),
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
        $post = Pelanggan::whereId($id)->first();

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
            'nmPelanggan'     => 'required',
            'noHpPelanggan'   => 'required',
        ],
            [
                'nmPelanggan.required' => 'Masukkan Nama Pelanggan !',
                'noHpPelanggan.required' => 'Masukkan No Hp Pelanggan !',
            ]
        );

        if($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ],400);

        } else {

            $post = Pelanggan::whereId($request->input('id'))->update([
                'nmPelanggan'     => $request->input('nmPelanggan'),
                'almtPelanggan'   => $request->input('almtPelanggan'),
                'noHpPelanggan'   => $request->input('noHpPelanggan'),
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
        $post = Pelanggan::findOrFail($id);
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
