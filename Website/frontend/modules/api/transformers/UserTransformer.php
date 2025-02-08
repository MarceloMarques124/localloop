<?php

namespace frontend\modules\api\transformers;

use common\models\Review;

class UserTransformer
{
    public static function transform($userInfo): array
    {
        $user = $userInfo['user'];

        $averageStars = Review::find()
            ->where(['user_info_id' => $user['id']])
            ->average('stars');

        return [
            'id' => $userInfo['id'],
            'name' => $userInfo['name'],
            'address' => $userInfo['address'],
            'postal_code' => $userInfo['postal_code'],
            'flagged_for_ban' => $userInfo['flagged_for_ban'],
            'created_at' => $userInfo['created_at'],
            'updated_at' => $userInfo['updated_at'],
            'username' => $user['username'],
            'email' => $user['email'],
            'status' => $user['status'],
            'average_stars' => $averageStars ?: 0,
        ];
    }
}