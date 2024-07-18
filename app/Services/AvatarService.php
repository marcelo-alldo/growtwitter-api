<?php

namespace App\Services;

use App\Exceptions\AvatarStoreFailException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AvatarService
{
    public static function storeAvatar($avatar)
    {
        try {
            $newAvatarName = self::setFileName($avatar);
            $filePath = "user/avatar/{$newAvatarName}";
            Storage::disk('s3')->put($filePath, file_get_contents($avatar));
            return $newAvatarName;
        } catch (\Throwable $th) {
            throw new AvatarStoreFailException("Falha ao adicionar o avatar, {$th->getMessage()}");
        }
    }

    public static function mountUserAvatarUrl($url, $avatarName)
    {
        return Storage::disk('s3')->url("user/avatar/{$avatarName}");
    }

    public static function setFileName($file)
    {
        return (string) Str::uuid() . '.' . $file->extension();
    }
}
