<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokter;
use Illuminate\Support\Facades\Validator;

class DokterController extends Controller
{
    public function index()
    {
        $query = Dokter::latest();
        $dokter = $query->get();

        return response()->json($dokter, 200);
    }

    public function store(Request $request)
    {
        $rules = [
            'nama_dokter' => 'required|string|max:258',
            'profesi' => 'required|string|max:258',
            'alamat' => 'required|string|max:258',
        ];

        $messages = [
            'nama_dokter.required' => 'nama_dokter is required',
            'profesi.required' => 'profesi is required',
            'alamat.required' => 'Jenis dokter is required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json( $validator->errors(), 400);
        }

        try {

            Dokter::create([
                'nama_dokter' => $request->input('nama_dokter'),
                'profesi' => $request->input('profesi'),
                'alamat' => $request->input('alamat'),
            ]);

            return response()->json([
                'message' => "dokter successfully created."
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
        $dokter = Dokter::where('id_dokter',$id)->first();

        if (!$dokter) {
            return response()->json([
                'message' => "dokter Not Found"
            ], 404);
        }

        return response()->json($dokter, 200);
    }


    public function update(Request $request, string $id)
    {
        $rules = [
            'nama_dokter' => 'required|string|max:258',
            'profesi' => 'required|string|max:258',
            'alamat' => 'required|string|max:258',
        ];

        $messages = [
            'nama_dokter.required' => 'nama_dokter is required',
            'profesi.required' => 'profesi is required',
            'alamat.required' => 'jenis dokter is required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json( $validator->errors(), 400);
        }

        try {
            $dokter = Dokter::where('id_dokter', $id)->first();

            if (!$dokter) {
                return response()->json([
                    'message' => "dokter Not Found"
                ], 404);
            }

            $updatedData = [
                'nama_dokter' => $request->input('nama_dokter'),
                'profesi' => $request->input('profesi'),
                'alamat' => $request->input('alamat'),
            ];


            Dokter::where('id_dokter', $id)->update($updatedData);

            return response()->json([
                'message' => "dokter successfully updated."
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Something went really wrong"
            ], 500);
        }
    }


    public function destroy(string $id)
    {
        $dokter = Dokter::where('id_dokter', $id)->first();

        if (!$dokter) {
            return response()->json([
                'message' => "dokter Not Found"
            ], 404);
        }

        Dokter::where('id_dokter', $id)->delete();

        return response()->json([
            'message' => "dokter successfully deleted."
        ], 200);
    }
}
