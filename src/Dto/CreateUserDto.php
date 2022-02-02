<?php

namespace App\Dto;


class CreateUserDto
{
    private $email;
    private $age;
    private $first_name;
    private $last_name;
    private $password;
    private $date_created;


    public function __construct(string $email, string $first_name, string $last_name,
                                string $password, int $age)
    {
        $this->email = $email;
        $this->age = $age;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->password = $password;
        $this->date_created = new \DateTime();
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getDateCreated(): \DateTime
    {
        return $this->date_created;
    }


    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAge(): int
    {
        return $this->age;
    }
}

