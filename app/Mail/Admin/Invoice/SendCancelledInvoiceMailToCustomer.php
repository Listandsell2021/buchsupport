<?php

namespace App\Mail\Admin\Invoice;

use App\Libraries\SpatiaDbMail\TemplateMailableExtender;
use App\Models\Lead;

class SendCancelledInvoiceMailToCustomer extends TemplateMailableExtender
{
    public string $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

}
