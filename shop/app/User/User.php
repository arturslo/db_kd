<?php

namespace App\User;

use Illuminate\Contracts\Support\Arrayable;

class User implements Arrayable
{
    public ?int $UserId;
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
    public function __construct(?int $UserId = null, string $Firstname, string $Lastname, string $Email, string $Password)
    {
        $this->UserId = $UserId;
        $this->Firstname = $Firstname;
        $this->Lastname = $Lastname;
        $this->Email = $Email;
        $this->Password = $Password;
    }

    public function toArray()
    {
        return [
            'UserId' => $this->UserId,
            'Firstname' => $this->Firstname,
            'Lastname' => $this->Lastname,
            'Email' => $this->Email,
            'Password' => $this->Password,
        ];
    }
}
