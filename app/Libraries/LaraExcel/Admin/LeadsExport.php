<?php

namespace App\Libraries\LaraExcel\Admin;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class LeadsExport implements FromCollection
{
    use Exportable;


    public function collection()
    {
        return Lead::select('first_name', 'last_name', 'email', 'gender', 'phone_no', 'street', 'postal_code', 'city', 'country', 'map_longitude', 'map_latitude', 'status', 'salesperson_id')->get();
    }
}
