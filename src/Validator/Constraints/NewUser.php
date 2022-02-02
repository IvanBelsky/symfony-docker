<?php

namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

class NewUser extends Constraint
{
    public $message;

    public $message2;

    public function __construct($options = null, $groups = null, $payload = null)
    {
        parent::__construct($options, $groups, $payload);
    }
}
