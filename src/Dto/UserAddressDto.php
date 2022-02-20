<?php
/* DTO address */

namespace App\Dto;


use App\Entity\User;

class UserAddressDto
{
    private $town;

    private $user;

    public function __construct(string $town, User $user)
    {
        $this->town = $town;
        $this->user = $user;
    }

    public function getTown(): string
    {
        return $this->town;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}