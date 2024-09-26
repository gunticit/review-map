<?php
    namespace App\Traits;
    use Illuminate\Http\UploadedFile;
    
    trait UploadFile
    {
        public function uploadFile(UploadedFile $file, string $directory)
        {
            $filePath = $file->store($directory);
            return [
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $filePath,
            ];
        }
    }