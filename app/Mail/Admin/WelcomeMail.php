<?php

namespace App\Mail\Admin;

use App\Libraries\SpatiaDbMail\TemplateMailableExtender;
use App\Models\User;

class WelcomeMail extends TemplateMailableExtender
{
    public string $name;
    public string $email;

    public function __construct(User $user)
    {
        $this->name = $user->first_name.' '.$user->last_name;
        $this->email = $user->email;
    }

}
