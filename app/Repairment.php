<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Repairment extends Model
{
    public static function stats()
    {
        $sql = "
        SELECT
            SUM(CASE status WHEN 'WAITING' THEN 1 ELSE 0 END) as waiting,
            SUM(CASE status WHEN 'ON_PROGRESS' THEN 1 ELSE 0 END) as on_progress,
            SUM(CASE status WHEN 'DONE' THEN 1 ELSE 0 END) as done,
            SUM(CASE status WHEN 'CANCELED' THEN 1 ELSE 0 END) as canceled
        FROM repairments
        ";

        return collect(DB::select($sql))->first();
    }
}
