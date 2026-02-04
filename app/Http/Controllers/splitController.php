<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Split;
use Illuminate\Support\Facades\DB;

class splitController extends Controller
{
    //
    public function add(Request $request){
        try {
            $exception = DB::transaction(function() use ($request){
                $body1 = $request->input('data');
                // $path = $request->path();
                $body =json_decode($body1); 
                    $dataSet = [];
                    foreach ($body as $s) {
                        $dataSet[] = [
                            'noNota'  => $s->noNotaTmp,
                            'noMeja'    => $s->noMejaTmp,
                            'kdBarang'       => $s->kdBarangTmp,
                            'qtyBarang' => $s->qtyTmp,
                            'subTotal' => $s->qtyTmp * $s->hrgJualTmp,
                            'groupNota' => $s->groupNot,
                            'nmBarang' =>$s->nmBarangTmp,
                            'hrgBarang' =>$s->hrgJualTmp,
                            'bayar' =>$s->bayarS,
                            'kembalian' =>$s->kembalianS
                        ];
                    }
                    DB::table('splitPayment')->insert($dataSet);
  
                DB::commit();
                });
                if(is_null($exception)) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Post Berhasil Disimpan!',
                    ], 200);
                } else {                    
                    // DB::rollback();
                    return response()->json([
                        'success' => false,
                        'message' => 'Post Tidak Berhasil Disimpan!',
                    ], 200);
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
}
