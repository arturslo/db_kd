<?php

namespace App\User;

use Illuminate\Support\Facades\DB;

class UserRepository
{
    public function create(User $user): int
    {
        $sql = "INSERT INTO `User` (`UserId`, `Firstname`, `Lastname`, `Email`, `Password`) VALUES (:UserId, :Firstname, :Lastname, :Email, :Password);";
        DB::insert($sql, $user->toArray());
        $id = (int)DB::getPdo()->lastInsertId();

        return $id;
    }
}
