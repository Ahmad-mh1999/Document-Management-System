<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\DocumentResource;
use App\Http\Requests\storeDocumentRequest;
use App\Http\Requests\updateDocumentRequest;
use App\Http\Traits\responseTrait;
use App\Http\Traits\UploadTrait;

class DocumentController extends Controller
{
    use responseTrait, UploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Cache::remember('documents', 1000, function () {
            return Document::all();
        });

        $data = DocumentResource::collection($documents);
        return $this->customeResponse($data, 'success', 200);
        // return $this->customeRespone($data, 'success', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeDocumentRequest $request)
    {
        try {
            DB::beginTransaction();
            $path = null;
            if ($request->hasFile('path')) {
                $path = $this->uploadFile($request, 'documents', 'path');
                if (!$path) {
                    return $this->customeResponse(null, 'Failed to upload file', 422);
                }
            }
            $document = Document::create([
                'name' => $request->name,
                'path' => $path,
                'user_id' => $request->user_id,
            ]);
            DB::commit();

            Cache::forget('documents');
            Cache::put('documents', Document::all(), 1000);
            $data = new DocumentResource($document);
            return $this->customeResponse($document, 'stored successfully', 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->customeResponse($th->getMessage(), 'error', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        $data = new DocumentResource($document);
        return $this->customeRespone($data, 'success', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(updateDocumentRequest $request, Document $document)
    {
        try {
            DB::beginTransaction();
            $path = null;
            if ($request->hasFile('path')) {
                $path = $this->uploadFile($request, 'documents', 'path');
            }
            $document->update([
                'name' => $request->name,
                'path' => $path,
                'user_id' => $request->user_id,
            ]);
            DB::commit();
            Cache::forget('documents');
            Cache::put('documents', Document::all(), 1000);
            $data = new DocumentResource($document);
            return response()->json(['message' => $data], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        $document->delete();

        Cache::forget('documents');
        Cache::put('documents', Document::all(), 1000);
        return $this->customeRespone(null, 'Document Deleted Successfully', 200);
    }
}
