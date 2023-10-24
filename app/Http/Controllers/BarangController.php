<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function findAll()
    {
        $barang = Barang::latest()->get();

        $data = [];

        foreach ($barang as $item) {
            $data[] = [
                "id" => $item->id,
                "author" => $item->user->name,
                "nama_barang" => $item->nama_barang,
                "jenis" => $item->jenis,
                "jumlah" => $item->jumlah,
                "created_at" => $item->created_at->format("D, d M Y")
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Menampilkan semua Barang',
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addBarang(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'nama_barang' => ['required', 'string', 'max:255'],
            'jumlah' => ['required', 'integer', 'max:255'],
            'jenis' => ['required', 'string', 'max:255'],
           
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $user = auth()->user();

        $barang = $user->barang()->create([
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'jenis' => $request->jenis,

            
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil ditambahkan',
            'data' => $barang
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function findByID($id)
    {
        $barang = Barang::find($id);

        return response()->json([
            'success' => true,
            'message' => 'Menampilkan Barang',
            'data' => $barang
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editBarang(Request $request, $id)
    {
        $validator = Validator::make(request()->all(), [
            'nama_barang' => ['required', 'string', 'max:255'],
            'jumlah' => ['required', 'integer', 'max:255'],
            'jenis' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $user = auth()->user();

        $barang = Barang::find($id);

        if ($user->id != $barang->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu bukan pemilik Barang'
            ], 403);
        }
        $barang->nama_barang = $request->nama_barang;
        $barang->jumlah = $request->jumlah;
        $barang->jenis = $request->jenis;
        
        $barang->save();

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil diubah',
            'data' => $barang
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteBarang($id)
    {
        $user = auth()->user();

        $barang = Barang::find($id);

        if ($user->id != $barang->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu bukan pemilik barang'
            ], 403);
        }

        $barang->delete();

        return response()->json([
            'success' => true,
            'message' => 'barang berhasil dihapus',
            'data' => $barang
        ]);
    }
}
