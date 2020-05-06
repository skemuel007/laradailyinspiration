<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Validator;

class FileController extends Controller
{
    //
    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'file' => 'required|mimes:png,gif,jpeg,pdf,jpg|max:500'
        ]);

        // max 500kb

        if ( $validator->fails() ) {
            return response()->json([
                'success' => false,
                'data' => $validator->errors(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        // get the file details
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $fileSize = $file->getSize();
        $fileType = $file->getMimeType();

        $newFileName = time() . strtolower(preg_replace('/\s/', '', $request->input('name'))) . $request->input('ugFormId') .
            '.' . $extension;

        $storage = Storage::disk('public')->put($newFileName,
            File::get($file));

        File::create([
            'name' => $newFileName,
            'size' => $fileSize,
            'type' => $request->input('name'),
            'extension' => $extension
        ]);

        return response()->json([
            'success' => true,
            'data' => null
        ], 201);
    }

    public function downloadFile($id) {
        $file = File::find($id);

        $fileName = $file->name;

        // $url = Storage::url($fileName);
        $path = storage_path('app/public' . DIRECTORY_SEPARATOR . $fileName);

        // check if file exists
        if( !File::exists($path)) {
            return response()->json([
                'success' => false,
                'data' => null
            ], 404);
        }

        /*
         * or
         * use file systems app_url
         * // inspiration from config/filesystems.php
         * // environment variable APP_URL
         * = localhost:8000/storage/filename
         *http://localhost:8000/storage/15782780641phpIj8ltG.png
         * return response()->json();
         */

        // return download response
        return response()->download($path);
    }
}
