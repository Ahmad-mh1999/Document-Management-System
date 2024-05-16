<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

trait UploadTrait
{
    /**
     * Uploads a file to the specified folder and returns the public URL of the uploaded file.
     *
     * @param Request $request
     * @param string $folderName
     * @param string $fileName
     * @return string|null
     */
    public function uploadFile(Request $request, $folderName, $fileName)
    {
        $validator = Validator::make($request->all(), [
            $fileName => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,csv|max:2048',
        ]);

        if ($validator->fails()) {
            Log::error('File upload validation failed: ' . $validator->errors());
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $file = $request->file($fileName);
        $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $newFileName = time() . '.' . $extension;
        $path = $folderName . '/' . $newFileName;

        $file = $request->file($fileName);
        $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $newFileName = time() . '.' . $extension;
        $path = $folderName . '/' . $newFileName;

        try {
            if ($file->isValid()) {
                $uploaded = Storage::put($path, file_get_contents($file));

                if ($uploaded) {
                    return Storage::url($path);
                } else {
                    Log::error('Failed to upload file: ' . $path);
                    throw new \Exception('Failed to upload file');
                }
            } else {
                Log::error('Invalid file: ' . $file->getClientOriginalName());
                throw new \Exception('Invalid file');
            }
        } catch (\Exception $e) {
            Log::error('File upload error: ' . $e->getMessage());
            return null;
        }
    }


    public function fileExists(Request $request, string $folder, string $fileColumnName)
    {
        /**
         * Check if a file exists and upload it.
         *
         * @param  Request  $request The HTTP request object.
         * @param  string  $folder The folder to upload the file to.
         * @param  string  $fileColumnName The name of the file input field in the request.
         * @return string|null The file path if the file exists, otherwise null.
         */
        if (empty($request->file($fileColumnName))) {
            return null;
        }
        return $this->uploadFile($request, $folder, $fileColumnName);
    }
}
