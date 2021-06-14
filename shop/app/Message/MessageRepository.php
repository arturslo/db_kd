<?php

namespace App\Message;

use Illuminate\Support\Facades\DB;

class MessageRepository
{
    public function create(Message $message): int
    {
        $sql = "INSERT INTO `Message` (`MessageId`, `OrderNo`, `Text`) VALUES (:MessageId, :OrderNo, :Text);";
        DB::insert($sql, $message->toArray());
        $id = (int)DB::getPdo()->lastInsertId();

        return $id;
    }
}
