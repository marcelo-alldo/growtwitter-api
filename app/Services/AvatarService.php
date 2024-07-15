<?php

namespace App\Services;

use App\Exceptions\AvatarStoreFailException;
use Illuminate\Support\Str;

class AvatarService
{

  public static function storeAvatar($avatar)
  {
    try {
      $newAvatarName = self::setFileName($avatar);
      $avatar->move(base_path("storage/app/public/user/avatar"), $newAvatarName);
      return $newAvatarName;
    } catch (\Throwable $th) {
      throw new AvatarStoreFailException("Fail to store avatar, {$th->getMessage()}");
    }
  }

  public static function mountUserAvatarUrl($url, $avatarName)
  {
    return $url . "/storage/user/avatar/{$avatarName}";
  }

  public static function setFileName($file)
  {
    return (string) Str::uuid() . '.' . $file->extension();
  }
}
