<?php

namespace Database\Seeders;

use App\Mail\Admin\Invoice\SendCancelledInvoiceMailToCustomer;
use App\Mail\Admin\Invoice\SendPaymentReminderMailToCustomer;
use App\Mail\Admin\Invoice\SendPaymentWarningMailToCustomer;
use Illuminate\Database\Seeder;
use App\Models\MailTemplate;
use App\Mail\Admin\Lead\NewCustomerRequestMailToAdmin;
use App\Mail\Admin\WelcomeMail;

class MailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MailTemplate::truncate();

        $mailTemplates = [
            [
                'name' => 'Welcome Mail',
                'mailable' => WelcomeMail::class,
                'subject' => 'Welcome Mail Subject',
                'html_template' => getMailTemplate('admin/welcome.html'),
                'text_template' => '',
                'layout_path' => '',                //admin/layout/main.html
                'html_layout' => '{{{ body }}}',    //getMailTemplate('admin/layout/main.html')
                'style_path' => '',
                'html_style' => getMailTemplate('layout/style.html'), //getMailTemplate('admin/layout/style.html')
            ],
            [
                'name' => 'New Customer Request Mail',
                'mailable' => NewCustomerRequestMailToAdmin::class,
                'subject' => 'New Customer Request Mail',
                'html_template' => getMailTemplate('admin/new_customer_request.html'),
                'text_template' => '',
                'layout_path' => '',
                'html_layout' => '{{{ body }}}',
                'style_path' => '',
                'html_style' => getMailTemplate('layout/style.html'),
            ],

            [
                'name' => 'Payment Reminder Mail',
                'mailable' => SendPaymentReminderMailToCustomer::class,
                'subject' => 'Payment Reminder',
                'html_template' => getMailTemplate('admin/payment_reminder.html'),
                'text_template' => '',
                'layout_path' => '',
                'html_layout' => '{{{ body }}}',
                'style_path' => '',
                'html_style' => getMailTemplate('layout/style.html'),
            ],
            [
                'name' => 'Payment Warning Mail',
                'mailable' => SendPaymentWarningMailToCustomer::class,
                'subject' => 'Payment Warning',
                'html_template' => getMailTemplate('admin/payment_warning.html'),
                'text_template' => '',
                'layout_path' => '',
                'html_layout' => '{{{ body }}}',
                'style_path' => '',
                'html_style' => getMailTemplate('layout/style.html'),
            ],
            [
                'name' => 'Cancelled Invoice',
                'mailable' => SendCancelledInvoiceMailToCustomer::class,
                'subject' => 'Cancelled Invoice',
                'html_template' => getMailTemplate('admin/cancelled_invoice.html'),
                'text_template' => '',
                'layout_path' => '',
                'html_layout' => '{{{ body }}}',
                'style_path' => '',
                'html_style' => getMailTemplate('layout/style.html'),
            ]
        ];

        MailTemplate::insert(
            array_map(function ($mailTempalte) {
                return array_merge($mailTempalte, ['created_at' => getCurrentDateTime(), 'updated_at' => getCurrentDateTime()]);
            }, $mailTemplates)
        );

    }
}
