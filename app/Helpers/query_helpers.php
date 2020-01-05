<?php

use Illuminate\Support\Facades\DB;

function queryForLikes($value)
{
    $query = DB::select('SELECT phoneId, count(id) as safe FROM (
                  SELECT `id`,`phoneId`,`value`,`created_at`
                FROM likes ' . getSql('phoneId') . ' 
                AND `value` = ' . $value . '
                ORDER BY created_at DESC LIMIT 50
                ) AS tmp_test GROUP BY phoneId');
    $ids   = [];
    foreach ($query as $item) {
        $ids[] = $item->phoneId;
    }

    return $ids;
}

function queryForViews()
{
    $query = DB::select('SELECT phoneId FROM (
                 SELECT phoneId,created_at
                  FROM views ' . getSql('phoneId') . ' 
                  ORDER BY created_at DESC limit 12
                  ) AS tmp_test GROUP BY phoneId');
    $ids   = [];
    foreach ($query as $item) {
        $ids[] = $item->phoneId;
    }

    return $ids;
}

function getSql(string $field)
{
    $lastId = \App\Helpers\DataCacheHelper::lastShownPhoneId();
    $sql = '';
    if (!empty($lastId)) {
        $sql = ' where `'. $field .'` < ' . $lastId;
    }

    return $sql;
}