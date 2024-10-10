<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use getID3;

class FileHelper
{
    public static function uploadFile($file, $folder)
    {
        if ($file->isValid()) {
            // Tạo tên file duy nhất
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            // Lưu file vào thư mục đã chỉ định
            $path = $file->storeAs('public/' . $folder, $filename);

            // Khởi tạo getID3
            $getID3 = new getID3;
            $filePath = storage_path('app/' . $path);
            $fileInfo = $getID3->analyze($filePath);

            // Lấy thông tin độ dài video
            $duration = isset($fileInfo['playtime_string']) ? $fileInfo['playtime_string'] : null;

            // Trả về thông tin file
            return [
                'path' => str_replace('public/', '/storage/', $path), // Đường dẫn lưu file
                'filename' => $filename, // Tên file
                'size' => $file->getSize(), // Kích thước file
                'duration' => $duration, // Độ dài video
            ];
        }

        return null; // Nếu file không hợp lệ
    }

    public static function deleteFile($path)
    {
        $path = str_replace('/storage/', 'public/', $path);
        return Storage::delete($path);
    }

    public static function existsFile($path)
    {
        $path = str_replace('/storage/', 'public/', $path);
        return Storage::exists($path);
    }
}
