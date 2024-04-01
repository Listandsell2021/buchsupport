<?php

namespace App\Mail\Admin\Invoice;

use App\Libraries\SpatiaDbMail\TemplateMailableExtender;
use App\Models\Lead;

class SendPaymentReminderMailToCustomer extends TemplateMailableExtender
{
    public string $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

}
