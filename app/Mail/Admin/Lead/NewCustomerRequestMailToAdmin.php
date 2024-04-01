<?php

namespace App\Mail\Admin\Lead;

use App\Libraries\SpatiaDbMail\TemplateMailableExtender;
use App\Models\Lead;

class NewCustomerRequestMailToAdmin extends TemplateMailableExtender
{
    public string $leadId;
    public string $name;

    public function __construct(Lead $lead)
    {
        $this->leadId = $lead->id;
        $this->name = $lead->fullname();
    }

}
