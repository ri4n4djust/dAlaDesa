<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Supplier;
use App\Barang;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class supplierController extends Controller
{
    //
    //
    public function index()
    {
        $posts = Supplier::latest()->get();
        return response([
            'success' => true,
            'message' => 'List Semua Supplier',
            'data' => $posts
        ], 200);
    }

    public function store(Request $request)
    {
        //validate data
        $validator = Validator::make($request->all(), [
            'nmSupplier'     => 'required',
            'noHp'   => 'required',
        ],
            [
                'nmSupplier.required' => 'Masukkan Nama Supplier',
                'noHp.required' => 'Masukkan No Hp supplier !',
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

            $post = Supplier::create([
                'kdSupplier'     => $request->input('kdSupplier'),
                'nmSupplier'     => $request->input('nmSupplier'),
                'almtSupplier'   => $request->input('almtSupplier'),
                'noHp'   => $request->input('noHp'),
                'kontakSupplier'   => $request->input('kontakSupplier')
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
        $post = Supplier::whereId($id)->first();

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
            'nmSupplier'     => 'required',
            'noHp'   => 'required',
        ],
            [
                'nmSupplier.required' => 'Masukkan Nama Supplier !',
                'noHp.required' => 'Masukkan No Hp supplier !',
            ]
        );

        if($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ],400);

        } else {

            $post = Supplier::whereId($request->input('id'))->update([
                'nmSupplier'     => $request->input('nmSupplier'),
                'almtSupplier'   => $request->input('almtSupplier'),
                'noHp'   => $request->input('noHp'),
                'kontakSupplier'   => $request->input('kontakSupplier')
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
        $post = Supplier::findOrFail($id);
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
