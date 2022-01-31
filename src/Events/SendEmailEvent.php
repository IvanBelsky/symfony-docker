<?php

namespace App\Events;


use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class SendEmailEvent extends Event
{
   public const SEND_EMAIL = 'send_email';
   private $user;
   private $message;
   public function __construct(User $user, string $message)
   {
       $this->user = $user;
       $this->message = $message;
   }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }


}