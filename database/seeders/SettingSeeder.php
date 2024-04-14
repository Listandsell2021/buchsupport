<?php

namespace Database\Seeders;

use App\DataHolders\Enum\SettingType;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::truncate();

        $settings = [
            [
                'name' => 'Company Name',
                'group' => 'company_info',
                'key' => 'company_name',
                'value' => 'Lead Kompass',
                'type' => SettingType::string->name,
            ],
            [
                'name' => 'Street Address',
                'group' => 'company_info',
                'key' => 'company_street_address',
                'value' => 'Friedrichstr.171',
                'type' => SettingType::string->name,
            ],
            [
                'name' => 'Postal Code',
                'group' => 'company_info',
                'key' => 'company_postal_code',
                'value' => '10117',
                'type' => SettingType::string->name,
            ],
            [
                'name' => 'City',
                'group' => 'company_info',
                'key' => 'company_city',
                'value' => 'Berlin',
                'type' => SettingType::string->name,
            ],
            [
                'name' => 'Phone No',
                'group' => 'company_info',
                'key' => 'company_phone_no',
                'value' => '030 520045118',
                'type' => SettingType::string->name,
            ],
            [
                'name' => 'Email',
                'group' => 'company_info',
                'key' => 'company_email',
                'value' => 'info@buch-leadkompass.de',
                'type' => SettingType::string->name,
            ],
            [
                'name' => 'Fax No',
                'group' => 'company_info',
                'key' => 'company_fax',
                'value' => '2342342',
                'type' => SettingType::string->name,
            ],
            [
                'name' => 'Website',
                'group' => 'company_info',
                'key' => 'company_website',
                'value' => 'https://leadkompass.de',
                'type' => SettingType::string->name,
            ],
            [
                'name' => 'Registration Court/No',
                'group' => 'company_info',
                'key' => 'company_registration_no',
                'value' => 'Amtsgericht Berlin Charlottenburg HRB 221154B',
                'type' => SettingType::string->name,
            ],
            [
                'name' => 'Company Manager',
                'group' => 'company_info',
                'key' => 'company_manager',
                'value' => 'Ilkan Caliskan',
                'type' => SettingType::string->name,
            ],




            [
                'name' => 'Bank Name',
                'group' => 'bank_info',
                'key' => 'bank_name',
                'value' => 'Deutsche Bank',
                'type' => SettingType::string->name,
            ],
            [
                'name' => 'Bank IBAN No',
                'group' => 'bank_info',
                'key' => 'bank_iban_no',
                'value' => 'DE90 1007 0124 0283 7060 00',
                'type' => SettingType::string->name,
            ],
            [
                'name' => 'Bank BIC No',
                'group' => 'bank_info',
                'key' => 'bank_bic_no',
                'value' => 'DEUTDEDB101',
                'type' => SettingType::string->name,
            ],



            [
                'name' => 'Commission Percentage',
                'group' => 'commission',
                'key' => 'commission_percentage',
                'value' => 20,
                'type' => SettingType::float->name,
            ],
            [
                'name' => 'Commission Threshold Amount',
                'group' => 'commission',
                'key' => 'threshold_amount',
                'value' => 50000,
                'type' => SettingType::integer->name,
            ],
            [
                'name' => 'Commission Percentage above threshold',
                'group' => 'commission',
                'key' => 'percentage_above_threshold',
                'value' => 25,
                'type' => SettingType::float->name,
            ],



            [
                'name' => 'VAT ID',
                'group' => 'invoice',
                'key' => 'vat_id',
                'value' => 'DE340103050',
                'type' => SettingType::string->name,
            ],
            [
                'name' => 'VAT Percentage',
                'group' => 'invoice',
                'key' => 'vat_percentage',
                'value' => '19',
                'type' => SettingType::float->name,
            ],


            [
                'name' => 'Invoice Heading',
                'group' => 'invoice',
                'key' => 'invoice_heading',
                'value' => '<h4>Performa-Rechnung {invoice_no}</h4><p>Das Rechnungsdatum entspricht dem Leistungsdatum</p>',
                'type' => SettingType::string->name,
            ],
            [
                'name' => 'Invoice Description',
                'group' => 'invoice',
                'key' => 'invoice_description',
                'value' => '<p>Sehr geehrter {customer}, 
                            <br> vielen Dank für Ihren Auftrag! 
                            <br> Wir bestätigen Ihnen den Kaufvertrag vom {invoice_date} 
                            <br> Der Kaufpreis beträgt <span>{invoice_price}</span>
                            <br> Bitte zahlen Sie die Rechnungssumme nach Rechnungserhalt auf das unten angegebene Konto. </p>',
                'type' => SettingType::string->name,
            ],
            [
                'name' => 'Invoice Starting No',
                'group' => 'invoice',
                'key' => 'invoice_starting_no',
                'value' => 123,
                'type' => SettingType::integer->name,
            ],
            [
                'name' => 'Enable Invoice Starting No',
                'group' => 'invoice',
                'key' => 'enable_invoice_starting_no',
                'value' => 0,
                'type' => SettingType::boolean->name,
            ],


            [
                'name' => 'Cancelled Invoice Heading',
                'group' => 'invoice',
                'key' => 'cancelled_invoice_heading',
                'value' => '<h4>Storno-Rechnung</h4><p>Das Storno-Rechnung entspricht dem Leistungsdatum</p>',
                'type' => SettingType::string->name,
            ],
            [
                'name' => 'Cancelled Invoice Description',
                'group' => 'invoice',
                'key' => 'cancelled_invoice_description',
                'value' => '<p>Bitte zahlen Sie die Rechnungssumme nach Rechnungserhalt auf das unten angegebene Konto. </p>',
                'type' => SettingType::string->name,
            ],
            [
                'name' => 'Cancellation Starting No',
                'group' => 'invoice',
                'key' => 'cancelled_invoice_starting_no',
                'value' => 456,
                'type' => SettingType::integer->name,
            ],
            [
                'name' => 'Enable Cancellation Starting No',
                'group' => 'invoice',
                'key' => 'enable_cancelled_invoice_starting_no',
                'value' => 0,
                'type' => SettingType::boolean->name,
            ],


            [
                'name' => 'Payment Reminder',
                'group' => 'invoice',
                'key' => 'payment_reminder_text',
                'value' => '<h4>Zahlungserinnerung</h4>
                            Rechnung Nr. {invoice_no} <br>
                            Sehr geehrter {customer}, <br><br>
                            die zum {invoice_date} fällige Rate von {invoice_price} ist trotz Zahlungserinnerung noch nicht bei uns eingegangen. <br>
                            Wir möchten Sie daher bitten, dies innerhalb der nächsten 7 Tage durch Überweisung an die unten <br>
                            genannte Bankverbindung nachzuholen. Ansonsten müssen wir beim nächsten mal eine Mahnung 
                            verschicken. <br>
                            Sollten sich Ihre mittlerweile erfolgte Zahlung und diese Mahnung überschnitten haben, bitten wir Sie diese
                            zu ignorieren.
                            <br>
                            <br>
                            Mit freundlichen Grüßen
                            {company_name}',
                'type' => SettingType::string->name,
            ],


            [
                'name' => 'Payment Warning',
                'group' => 'invoice',
                'key' => 'payment_warning_text',
                'value' => '<h4>Mahnung</h4>
                            <p>Sehr geehrte {customer},</p>
                            die zum {invoice_date} und {current_date} fällige Raten insgesamt in höhe von {invoice_price} sind noch nicht
                            bei uns eingegangen.
                            <br>
                            <br>
                            Wir möchten Sie daher bitten, die Summe von {invoice_price_with_charge} inkl. Mahngebühren innerhalb der
                            nächsten 7 Tage durch Überweisung an die unten genannte Bankverbindung nachzuholen.
                            <br>
                            <br>
                            Falls Sie Fragen zur Rechnung haben oder Wir Ihnen in einer anderen Sache weiterhelfen dürfen, können
                            Sie gerne Kontakt mit uns aufnehmen.
                            <br>
                            Sollte sich Ihre mittlerweile erfolgte Zahlung und diese Mahnung überschnitten haben, bitten wir Sie dieses
                            zu ignorieren.
                            <br>
                            <strong>Mit freundlichen Grüßen</strong>
                            <br>
                            <strong>{company_name}</strong>',
                'type' => SettingType::string->name,
            ],


            [
                'name' => 'Credit Note Heading',
                'group' => 'invoice',
                'key' => 'credit_note_heading',
                'value' => '<h4>Gutschrift</h4><p>Das Gutschrift entspricht dem Leistungsdatum</p>',
                'type' => SettingType::string->name,
            ],
            [
                'name' => 'Credit Note Description',
                'group' => 'invoice',
                'key' => 'credit_note_description',
                'value' => '<p>Bitte zahlen Sie die Gutschrift nach Rechnungserhalt auf das unten angegebene Konto. </p>',
                'type' => SettingType::string->name,
            ],
            [
                'name' => 'Credit Note Starting No',
                'group' => 'invoice',
                'key' => 'credit_note_starting_no',
                'value' => 789,
                'type' => SettingType::integer->name,
            ],
            [
                'name' => 'Enable Credit Note Starting No',
                'group' => 'invoice',
                'key' => 'enable_credit_note_starting_no',
                'value' => 0,
                'type' => SettingType::boolean->name,
            ],


            [
                'name' => 'Digital Signature',
                'group' => 'invoice',
                'key' => 'invoice_signature',
                'value' => '-----',
                'type' => SettingType::string->name,
            ],


        ];

        Setting::insert($settings);

    }
}
