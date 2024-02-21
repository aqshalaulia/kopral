<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index()
    {
        $query = Supplier::latest();
        $supplier = $query->get();

        return response()->json($supplier, 200);
    }

    public function store(Request $request)
    {
        $rules = [
            'nama_supplier' => 'required|string|max:258',
            'barang' => 'required|string|max:258',
            'alamat' => 'required|string|max:258',
        ];

        $messages = [
            'nama_supplier.required' => 'nama_supplier is required',
            'barang.required' => 'barang is required',
            'alamat.required' => 'alamat is required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json( $validator->errors(), 400);
        }

        try {

            Supplier::create([
                'nama_supplier' => $request->input('nama_supplier'),
                'barang' => $request->input('barang'),
                'alamat' => $request->input('alamat'),
            ]);

            return response()->json([
                'message' => "supplier successfully created."
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Something went really wrong!",
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id)
    {
        $supplier = Supplier::where('id_supplier',$id)->first();

        if (!$supplier) {
            return response()->json([
                'message' => "supplier Not Found"
            ], 404);
        }

        return response()->json($supplier, 200);
    }


    public function update(Request $request, string $id)
    {
        $rules = [
            'nama_supplier' => 'required|string|max:258',
            'barang' => 'required|string|max:258',
            'alamat' => 'required|string|max:258',
        ];

        $messages = [
            'nama_supplier.required' => 'nama_supplier is required',
            'barang.required' => 'barang is required',
            'alamat.required' => 'jenis supplier is required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json( $validator->errors(), 400);
        }

        try {
            $supplier = Supplier::where('id_supplier', $id)->first();

            if (!$supplier) {
                return response()->json([
                    'message' => "supplier Not Found"
                ], 404);
            }

            $updatedData = [
                'nama_supplier' => $request->input('nama_supplier'),
                'barang' => $request->input('barang'),
                'alamat' => $request->input('alamat'),
            ];


            Supplier::where('id_supplier', $id)->update($updatedData);

            return response()->json([
                'message' => "supplier successfully updated."
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Something went really wrong"
            ], 500);
        }
    }


    public function destroy(string $id)
    {
        $supplier = Supplier::where('id_supplier', $id)->first();

        if (!$supplier) {
            return response()->json([
                'message' => "supplier Not Found"
            ], 404);
        }

        Supplier::where('id_supplier', $id)->delete();

        return response()->json([
            'message' => "supplier successfully deleted."
        ], 200);
    }
}
