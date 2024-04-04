<?php

namespace App\CommandProcess\Admin\Lead;

use Illuminate\Http\UploadedFile;
use Rosamarsky\CommandBus\Command;

class CreateLeadContract implements Command
{
    public int $leadId;
    public UploadedFile $document;
    public int $serviceId;
    public int $quantity;
    public float $price;
    public string $note;

    public function __construct(int $leadId, UploadedFile $document, int $serviceId, int $quantity, float $price, string $note)
    {
        $this->leadId = $leadId;
        $this->document = $document;
        $this->serviceId = $serviceId;
        $this->price = $price;
        $this->note = $note;
        $this->quantity = $quantity;
    }
}
