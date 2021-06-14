<?php

namespace App\Client;

use Illuminate\Support\Facades\DB;

class ClientRepository
{
    public function create(Client $client): int
    {
        $sql = "INSERT INTO `Client` (`ClientId`, `Firstname`, `Lastname`, `Email`, `Password`) VALUES (:ClientId, :Firstname, :Lastname, :Email, :Password);";
        DB::insert($sql, $client->toArray());
        $id = (int)DB::getPdo()->lastInsertId();

        return $id;
    }

    public function findByEmailAndPassword($Email, $Password): ?Client
    {
        $sql = "SELECT * FROM `Client` WHERE Email=:Email AND Password=:Password";
        $rows = DB::select($sql, ['Email' => $Email, 'Password' => $Password]);

        if (!isset($rows[0])) {
            return null;
        }

        return new Client(...(array)$rows[0]);
    }

    public function findByClientId($ClientId): ?Client
    {
        $sql = "SELECT * FROM `Client` WHERE ClientId=:ClientId";
        $rows = DB::select($sql, ['ClientId' => $ClientId]);

        if (!isset($rows[0])) {
            return null;
        }

        return new Client(...(array)$rows[0]);
    }
}
