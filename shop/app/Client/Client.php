<?php

namespace App\Client;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Support\Arrayable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Client implements Arrayable, JWTSubject, Authenticatable
{
    public ?int $ClientId;
    public string $Firstname;
    public string $Lastname;
    public string $Email;
    public string $Password;

    /**
     * Client constructor.
     * @param int|null $ClientId
     * @param string $Firstname
     * @param string $Lastname
     * @param string $Email
     * @param string $Password
     */
    public function __construct(?int $ClientId = null, string $Firstname, string $Lastname, string $Email, string $Password)
    {
        $this->ClientId = $ClientId;
        $this->Firstname = $Firstname;
        $this->Lastname = $Lastname;
        $this->Email = $Email;
        $this->Password = $Password;
    }

    public function toArray()
    {
        return [
            'ClientId' => $this->ClientId,
            'Firstname' => $this->Firstname,
            'Lastname' => $this->Lastname,
            'Email' => $this->Email,
            'Password' => $this->Password,
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->ClientId;
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getAuthIdentifierName()
    {
        return 'ClientId';
    }

    public function getAuthIdentifier()
    {
        return $this->ClientId;
    }

    public function getAuthPassword()
    {
        return $this->Password;
    }

    public function getRememberToken()
    {
        return '';
    }

    public function setRememberToken($value)
    {
        return;
    }

    public function getRememberTokenName()
    {
       return '';
    }

    public function getName(): string
    {
        return $this->Firstname . ' ' . $this->Lastname;
    }
}
