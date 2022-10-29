<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class DataController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['login','register']]);
    // }

    public function create()
    {
        $validator = Validator::make(request()->all(),[
            'name' => 'required',
            'alamat' => 'required',
            'nohp' => 'required',
            'gender' => 'required',
            'url' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        $data =  DataSiswa::create([
            'name' => request('name'),
            'alamat' => request('alamat'),
            'nohp' => request('nohp'),
            'gender' => request('gender'),
            'url' => request('url'),
            'latitude' => request('latitude'),
            'longitude' => request('longitude')
        ]);

        if ($data) {
            return response()->json(['message' => 'Pendaftaran Berhasil']);
        }else{
            return response()->json(['message' => 'Pendaftaran Gagal']);
        }

    }

    public function show()
    {
        $data = DataSiswa::all();
        if ($data) {
            return Response::json(["success" => 200, "data" => $data]);
        } else {
            return response()->json(['message' => 'Tidak ada']);
        }
        
    }

    public function update($id)
    {
        try {
            $validator = Validator::make(request()->all(),[
                'name' => 'required',
                'alamat' => 'required',
                'nohp' => 'required',
                
            ]);
    
            if ($validator->fails()) {
                return response()->json(['message' => 'Error', 'errors' => $validator->errors()], 422);
            }
            $data = DataSiswa::find($id);

           

            if ($data) {
                $data->name = request('name');
                $data->alamat = request('alamat');
                $data->nohp = request('nohp');
                $data->save();
                return Response::json(["success" => 200, "data" => $data]);
            } else{
                return response()->json(['message' => 'Gagal']);
            }
       
        } catch (Exception $error) {
            return response()->json(['message' => 'Failed']);
        }
        
    }

    public function destroy($id)
    {
        try {
            $data = DataSiswa::find($id);
            if (is_null($data)) {
                return response()->json(['message' => 'Gagal']);
            } 
            $data->delete();
            return response()->json(['message' => 'Berhasil Logout']); 
        } catch (Exception $error) {
            return response()->json(['message' => 'Failed']);
        }
    }
}
