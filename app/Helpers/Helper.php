<?php
    namespace App\Helpers;
    use Illuminate\Support\Facades\File;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Http\UploadedFile;
    use App\Traits\FileManager;
    use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

    class Helper{
        use FileManager;
        # Lấy danh sách tất cả các module của hệ thống
        public static function allModules()
        {
            return array_map('basename', File::directories(__DIR__. '/../Modules/'));
        }
        public static function trackingError($params)
        {
            $module = $params['module'];
            $action = $params['action'];
            $msg_log = $params['msg_log'];
        
            $host = request()->getHost();
            if($action==null){
                $action = request()->route()->getActionMethod() ?? "undefine";
            }
            config([
                'logging.channels.' . 'log_error' => [
                    'driver' => 'daily',
                    'path' => storage_path("logs/log_error/custom_error/custom_error.log"),
                    'level' => 'error',
                    'days' => 365
                ]
            ]);

            Log::channel('log_error')->error($module.'_'.$action.":".$msg_log);
        }
        public static function createThumbnail(string $extension) {
            $url = '';
            switch ($extension) {
                case 'png':
                case 'jpg':
                case 'jpeg':
                    $url = asset('./assets/img/thumbnails/image.png');
                    break;
                case 'docx':
                case 'doc':
                    $url = asset('./assets/img/thumbnails/doc.png');
                    break;
                case 'xls':
                case 'xlsx':
                    $url = asset('./assets/img/thumbnails/excel.png');
                    break;
                case 'pdf':
                    $url = asset('./assets/img/thumbnails/pdf.png');
                    break;
                case 'mp3':
                case 'mp4':
                    $url = asset('./assets/img/thumbnails/media.png');
                    break;
                case 'pptx':
                case 'ppt':
                    $url = asset('./assets/img/thumbnails/ppt.png');
                    break;
                case 'folder':
                    $url = asset('./assets/img/thumbnails/folder.svg');
                    break;  
                default:
                    $url = asset('./assets/img/thumbnails/document.png');
                    break;
            }
            return $url;
        }

        public static function uploadFile(UploadedFile $file, string $path, string|null $disk = '')
        {
            $hashName = hashName();
            $extension = $file->getClientOriginalExtension();
            $newName = "$hashName.$extension";
            (new self)->upload($file, $path, $newName, $disk);
            $thumbnail = self::createThumbnail($extension);
            return [
                'path' => $path . '/' . $newName,
                'file_name' => $file->getClientOriginalName(),
                'hash_name' => $newName,
                'extension' => $extension,
                'mime_type' => $file->getClientMimeType(),
                'size' => $file->getSize(),
                'thumbnail_url' => $thumbnail,
            ];
        }

        public static function saveAvatarGoogle($avatarUrl, $user)
        {
            $client = new Client();
            $response = $client->get($avatarUrl);
            $avatarContent = $response->getBody()->getContents();
            $userId = $user->id . $user->google_id;
            $avatarFilename = 'avatars/' . $userId . '_avatar.jpg';
            Storage::disk('public')->put($avatarFilename, $avatarContent);
            return $avatarFilename;
        }
    }