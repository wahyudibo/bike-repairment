<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use NotificationChannels\WebPush\HasPushSubscriptions;
use DB;

class Repairment extends Model
{
    use Notifiable;
    use HasPushSubscriptions;

    public static function stats()
    {
        $sql = "
        SELECT
            IFNULL(SUM(CASE status WHEN 'WAITING' THEN 1 ELSE 0 END), 0) as waiting,
            IFNULL(SUM(CASE status WHEN 'ON_PROGRESS' THEN 1 ELSE 0 END), 0) as on_progress,
            IFNULL(SUM(CASE status WHEN 'DONE' THEN 1 ELSE 0 END), 0) as done,
            IFNULL(SUM(CASE status WHEN 'CANCELED' THEN 1 ELSE 0 END), 0) as canceled
        FROM repairments
        ";

        return collect(DB::select($sql))->first();
    }
}
