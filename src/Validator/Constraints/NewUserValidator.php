<?php

namespace App\Validator\Constraints;


use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NewUserValidator extends ConstraintValidator
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        $valid = true;

        $exitUser = $this->userRepository->findOneBy([
            'email' => $value
        ]);
        if (null !== $exitUser) {
            $valid = false;
        }

        if ($valid === false) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
