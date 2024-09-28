<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait FileManager
{
    public function upload(UploadedFile $file, string $path, string $fileName, string|null $disk = null)
    {
        $pathSite = getPathFolder($path);
        $disk = $disk ?? config('constants.document.disk_document');
        return Storage::disk($disk)->putFileAs($pathSite, $file, $fileName);
    }

    public function removeFile(string $path, string|null $disk = '')
    {
        $pathSite = getPathFolder($path);
        $disk = $disk ?? config('constants.document.disk_document');
        return Storage::disk($disk)->delete($pathSite);
    }

    public function removeFolder(string $path, string|null $disk = null)
    {
        $pathSite = getPathFolder($path);
        $disk = $disk ?? config('constants.document.disk_document');
        return Storage::disk($disk)->deleteDirectory($pathSite);
    }

    public function removeTempFile(string $path, string|null $disk = null)
    {
        $pathSite = getPathTempFolder($path);
        $disk = $disk ?? config('constants.document.disk_document');
        return Storage::disk($disk)->delete($pathSite);
    }

    public function rename(string $documentPath, string $newDocumentPath, string|null $disk = null)
    {
        $pathSite = getPathFolder($documentPath);
        $disk = $disk ?? config('constants.document.disk_document');
        $oldName = Storage::disk($disk)->path($pathSite  . $documentPath);
        $newName =  Storage::disk($disk)->path($pathSite . $newDocumentPath);
        if (file_exists($oldName) && config('constants.document.disk_document') == 'local') {
            rename($oldName, $newName);
        }
    }

    public function download(string $documentPath, string $name, string|null $disk = null)
    {
        $pathSite = getPathFolder($documentPath);
        $disk = $disk ?? config('constants.document.disk_document');
        if (Storage::disk($disk)->exists($pathSite)) {
            $result = Storage::disk($disk)->download($pathSite, $name);
            ob_end_clean();
            return $result;
        }
    }
}
