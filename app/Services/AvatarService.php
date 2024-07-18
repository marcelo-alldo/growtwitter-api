<?php

namespace App\Services;

use App\Exceptions\AvatarStoreFailException;

class AvatarService
{
    public static function storeAvatar($avatar)
    {
        try {
            return 'data:image/' . $avatar->getClientOriginalExtension() . ';base64,' . base64_encode(file_get_contents($avatar));
        } catch (\Throwable $th) {
            throw new AvatarStoreFailException("Falha ao adicionar o avatar, {$th->getMessage()}");
        }
    }
}
