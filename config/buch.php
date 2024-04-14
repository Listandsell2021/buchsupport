<?php

return [

    'product_conditions' => [
        ['label' => 'Schlecht', 'value' => 1],
        ['label' => 'Ungenügend', 'value' => 2],
        ['label' => 'Ausreichend', 'value' => 3],
        ['label' => 'Gut', 'value' => 4],
        ['label' => 'Sehr gut', 'value' => 5],
        ['label' => 'Neuwertig', 'value' => 6],
    ],

    'product_condition_default' => 'Ausreichend',

    'countries' => ['Deutschland', 'Österreich', 'Schweiz', 'Luxemburg'],

    'company' => [
        'address' => 'Friedrichstraße 171 10117 Berlin',
        'phone_no' => '03050951811',
        'phone_no_link' => 'tel:00493050951811',
        'email' => 'info@leadkompass.de',
    ],

    'vat_percentage' => 19,

    'leads_import_extensions' => ['xlsx', 'csv', 'xlx, xls'],

    'invoice_storage_folder' => 'customer_invoices',

    'admin_commission_storage_folder' => 'admin_commissions',

    'admin_commission_rows' => 20,

    'payment_reminder_storage_folder' => 'payment_reminders',

    'months' => [ 1 => 'jan', 2 => 'feb', 3 => 'mar', 4 => 'apr', 5 => 'may', 6 => 'jun', 7 => 'jul', 8 => 'aug', 9 => 'sep', 10 => 'oct', 11 => 'nov', 12 => 'dec' ],

    'user_image_extensions' => ['jpg', 'png'],
    'user_image_max_size' => 500, //KB
    'user_image_storage_folder' => 'user_profile',

    'lead_document_storage_folder' => 'lead_documents',
    'lead_document_max_size' => 1024, // 1MB
    'lead_document_extensions' => ['jpg', 'png', 'pdf'],
    'base_mode_timestamp_format' => 'd.m.Y H:i',

    'lead_table_columns' => ['lead_name', 'lead_salesperson', 'lead_email', 'lead_gender', 'lead_phone_no', 'lead_country', 'lead_city', 'lead_street', 'lead_postal_code', 'lead_status'],
];