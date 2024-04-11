<?php

use App\Http\Controllers\API\Admin\Auth\OrderController;
use App\Http\Controllers\API\Admin\LeadAppointmentController;
use App\Http\Controllers\API\Admin\LeadDocumentController;
use App\Http\Controllers\API\Admin\LeadStatusController;
use App\Http\Controllers\API\Admin\LeadTaskController;
use App\Http\Controllers\API\Admin\PipelineController;
use App\Http\Controllers\API\Admin\ServicePipelineController;
use Illuminate\Support\Facades\Route;
use \App\DataHolders\Enum\AdminPermission;
use App\Http\Controllers\API\Admin\AdminController;
use \App\Http\Controllers\API\Admin\RoleController;
use \App\Http\Controllers\API\Admin\ServiceController;
use \App\Http\Controllers\API\Admin\LeadController;
use \App\Http\Controllers\API\Admin\SmartListController;
use \App\Http\Controllers\API\Admin\CustomerController;
use \App\Http\Controllers\API\Admin\MailController;
use \App\Http\Controllers\API\Admin\SettingController;
use \App\Http\Controllers\API\Admin\NotificationController;
use \App\Http\Controllers\API\Admin\DashboardController;
use \App\Http\Controllers\API\Admin\InvoiceController;

/*Route::post('admin/dashboard/cards',                          function (\Illuminate\Http\Request $request) {
    dd($request->user());
})->name('admin.dashboard.cards');*/

Route::prefix('admin')->middleware(['auth:sanctum', 'auth:admin', 'admin_permission_session'])->group( function () {

    // Dashboard Cards
    Route::post('dashboard/cards',                          [DashboardController::class, 'getCardDetails'])->name('admin.dashboard.cards');

    // Administrator
    Route::get('admins',                [AdminController::class, 'index'])->name('admin.admins.index')->middleware('can:'.AdminPermission::LIST_ADMIN->name);
    Route::post('admins',               [AdminController::class, 'store'])->name('admin.admins.store')->middleware('can:'.AdminPermission::CREATE_ADMIN->name);
    Route::get('admins/{id}',           [AdminController::class, 'show'])->name('admin.admins.show')->middleware('can:'.AdminPermission::SHOW_ADMIN->name);
    Route::put('admins/{id}',           [AdminController::class, 'update'])->name('admin.admins.update')->middleware('can:'.AdminPermission::UPDATE_ADMIN->name);
    Route::delete('admins/{id}',        [AdminController::class, 'destroy'])->name('admin.admins.destroy')->middleware('can:'.AdminPermission::DELETE_ADMIN->name);
    Route::post('admins/auth-roles',    [AdminController::class, 'getAuthRoles'])->name('admin.admins.auth_roles');
    Route::post('admins/admin-roles',   [AdminController::class, 'getAdminRoles'])->name('admin.admins.roles.list');
    Route::post('admins/change-status', [AdminController::class, 'changeActiveStatus'])->name('admin.admins.change_status')->middleware('can:'.AdminPermission::UPDATE_ADMIN->name);
    Route::post('admins/bulk-action',   [AdminController::class, 'updateBulkAction'])->name('admin.admins.bulk_action')->middleware('can:'.AdminPermission::UPDATE_ADMIN->name);
    Route::post('admins/create-commission-pdf', [AdminController::class, 'createSalespersonCommissionPdf'])->name('admin.admins.create_commission_pdf')->middleware('can:'.AdminPermission::UPDATE_ADMIN->name);
    Route::post('admins/get-commissions', [AdminController::class, 'getSalespersonCommissions'])->name('admin.admins.commissions')->middleware('can:'.AdminPermission::UPDATE_ADMIN->name);
    Route::post('admins/update-commission-paid-status', [AdminController::class, 'updateCommissionPaidStatus'])->name('admin.admins.update_commission_paid_status')->middleware('can:'.AdminPermission::UPDATE_ADMIN->name);
    Route::post('admins/download-commission', [AdminController::class, 'downloadAdminCommission'])->name('admin.admins.download_commission')->middleware('can:'.AdminPermission::UPDATE_ADMIN->name);


    // Roles
    Route::get('roles',                 [RoleController::class, 'index'])->name('admin.roles.index')->middleware('can:'.AdminPermission::LIST_ROLE->name);
    Route::post('roles',                [RoleController::class, 'store'])->name('admin.roles.store')->middleware('can:'.AdminPermission::CREATE_ROLE->name);
    Route::get('roles/{id}',            [RoleController::class, 'show'])->name('admin.roles.show')->middleware('can:'.AdminPermission::SHOW_ROLE->name);
    Route::put('roles/{id}',            [RoleController::class, 'update'])->name('admin.roles.update')->middleware('can:'.AdminPermission::UPDATE_ROLE->name);
    Route::delete('roles/{id}',         [RoleController::class, 'destroy'])->name('admin.roles.destroy')->middleware('can:'.AdminPermission::DELETE_ROLE->name);
    Route::post('roles/bulk-action',   [RoleController::class, 'updateBulkAction'])->name('admin.roles.bulk_action')->middleware('can:'.AdminPermission::UPDATE_ROLE->name);
    Route::post('roles/change-status',  [RoleController::class, 'changeActiveStatus'])->name('admin.roles.change_status')->middleware('can:'.AdminPermission::UPDATE_ROLE->name);
    Route::post('roles/get-permissions', [RoleController::class, 'getAllPermissions'])->name('admin.roles.get_permissions');


    // Salesperson
    Route::post('salespersons/get-active',              [AdminController::class, 'getActiveSalespersons'])->name('admin.salespersons.get_active');
    Route::post('salespersons/commission-graph-data',   [DashboardController::class, 'getSalespersonCommissionGraph'])->name('admin.salespersons.commission_graph');


    // Services
    Route::get('services',                  [ServiceController::class, 'index'])->name('admin.services.index')->middleware('can:'.AdminPermission::LIST_SERVICE->name);
    Route::post('services',                 [ServiceController::class, 'store'])->name('admin.services.store')->middleware('can:'.AdminPermission::CREATE_SERVICE->name);
    Route::get('services/{id}',             [ServiceController::class, 'show'])->name('admin.services.show')->middleware('can:'.AdminPermission::SHOW_SERVICE->name);
    Route::put('services/{id}',             [ServiceController::class, 'update'])->name('admin.services.update')->middleware('can:'.AdminPermission::UPDATE_SERVICE->name);
    Route::delete('services/{id}',          [ServiceController::class, 'destroy'])->name('admin.services.destroy')->middleware('can:'.AdminPermission::DELETE_SERVICE->name);
    Route::post('services/change-status',   [ServiceController::class, 'changeActiveStatus'])->name('admin.services.change_status')->middleware('can:'.AdminPermission::UPDATE_ADMIN->name);
    Route::post('services/all',             [ServiceController::class, 'getAllServices'])->name('admin.services.all')->middleware('can:'.AdminPermission::LIST_SERVICE->name);
    Route::post('services/bulk-action',     [ServiceController::class, 'updateBulkAction'])->name('admin.services.bulk_action')->middleware('can:'.AdminPermission::UPDATE_SERVICE->name);
    Route::get('services/{id}/pipeline',    [ServiceController::class, 'getServicePipelineInKanvan'])->name('admin.services.pipeline')->middleware('can:'.AdminPermission::SHOW_SERVICE->name);

    // Service Pipelines
    Route::get('service-pipelines/{service}',       [ServicePipelineController::class, 'index'])->name('admin.service_pipeline.index')->middleware('can:'.AdminPermission::LIST_SERVICE_PIPELINE->name);
    Route::post('service-pipeline',                 [ServicePipelineController::class, 'store'])->name('admin.service_pipeline.store')->middleware('can:'.AdminPermission::CREATE_SERVICE_PIPELINE->name);
    Route::get('service-pipeline/{id}',             [ServicePipelineController::class, 'show'])->name('admin.service_pipeline.show')->middleware('can:'.AdminPermission::SHOW_SERVICE_PIPELINE->name);
    Route::put('service-pipeline/{id}',             [ServicePipelineController::class, 'update'])->name('admin.service_pipeline.update')->middleware('can:'.AdminPermission::UPDATE_SERVICE_PIPELINE->name);
    Route::delete('service-pipeline/{id}',          [ServicePipelineController::class, 'destroy'])->name('admin.service_pipeline.destroy')->middleware('can:'.AdminPermission::DELETE_SERVICE_PIPELINE->name);
    Route::post('service-pipeline/change-default',  [ServicePipelineController::class, 'changeDefault'])->name('admin.services.change_default')->middleware('can:'.AdminPermission::UPDATE_SERVICE_PIPELINE->name);
    Route::post('service-pipelines/by-service',     [ServicePipelineController::class, 'getPipelinesByService'])->name('admin.service_pipeline.by_service')->middleware('can:'.AdminPermission::LIST_SERVICE_PIPELINE->name);


    // Customers
    Route::get('customers',                 [CustomerController::class, 'index'])->name('admin.customers.index')->middleware('can:'.AdminPermission::LIST_CUSTOMER->name);
    Route::post('customers',                [CustomerController::class, 'store'])->name('admin.customers.store')->middleware('can:'.AdminPermission::CREATE_CUSTOMER->name);
    Route::get('customers/{id}',            [CustomerController::class, 'show'])->name('admin.customers.show')->middleware('can:'.AdminPermission::SHOW_CUSTOMER->name);
    Route::put('customers/{id}',            [CustomerController::class, 'update'])->name('admin.customers.update')->middleware('can:'.AdminPermission::UPDATE_CUSTOMER->name);
    Route::delete('customers/{id}',         [CustomerController::class, 'destroy'])->name('admin.customers.destroy')->middleware('can:'.AdminPermission::DELETE_CUSTOMER->name);
    Route::post('customers/change-status',  [CustomerController::class, 'changeActiveStatus'])->name('admin.customers.change_status')->middleware('can:'.AdminPermission::UPDATE_CUSTOMER->name);
    Route::post('customers/bulk-action',    [CustomerController::class, 'updateBulkAction'])->name('admin.customers.bulk_action')->middleware('can:'.AdminPermission::UPDATE_CUSTOMER->name);
    Route::post('customers/search',         [CustomerController::class, 'searchCustomers'])->name('admin.customers.search')->middleware('can:'.AdminPermission::LIST_CUSTOMER->name);
    Route::post('customers/memberships',    [CustomerController::class, 'getMemberships'])->name('admin.customers.memberships')->middleware('can:'.AdminPermission::LIST_CUSTOMER->name);
    Route::post('customers/birthdays',      [CustomerController::class, 'getCustomerBirthdays'])->name('admin.customers.birthdays')->middleware('can:'.AdminPermission::LIST_BIRTHDAY_CALENDAR->name);
    Route::post('customers/products',       [CustomerController::class, 'getProductsByCustomer'])->name('admin.customers.products')->middleware('can:'.AdminPermission::LIST_CUSTOMER->name);
    Route::post('customers/sort-products',  [CustomerController::class, 'sortCustomerProducts'])->name('admin.customers.sort_products')->middleware('can:'.AdminPermission::LIST_CUSTOMER->name);
    Route::post('customers/download-document-pdf', [CustomerController::class, 'downloadCustomerDocumentPdf'])->name('admin.customers.download_document_pdf')->middleware('can:'.AdminPermission::SHOW_CUSTOMER->name);
    Route::post('customers/download-contract-doc',  [CustomerController::class, 'downloadContractDocument'])->name('admin.customers.download_contract_doc')->middleware('can:'.AdminPermission::UPDATE_LEAD->name);
    Route::post('customers/upload-contract-doc',    [CustomerController::class, 'uploadContractDocument'])->name('admin.customers.upload_contract_doc')->middleware('can:'.AdminPermission::UPDATE_LEAD->name);
    Route::post('customers/update-forms',           [CustomerController::class, 'updateCustomerForms'])->name('admin.customers.update_forms');
    Route::post('customers/update-invoice-setting', [CustomerController::class, 'updateInvoiceSetting'])->name('admin.customers.update_invoice_setting');


    Route::post('pipeline/list',            [PipelineController::class, 'list'])->name('admin.pipeline.list')->middleware('can:'.AdminPermission::LIST_PIPELINE->name);
    Route::post('pipeline/all',             [PipelineController::class, 'all'])->name('admin.pipeline.all')->middleware('can:'.AdminPermission::LIST_PIPELINE->name);
    Route::post('pipeline/store',           [PipelineController::class, 'store'])->name('admin.pipeline.store')->middleware('can:'.AdminPermission::CREATE_PIPELINE->name);
    Route::post('pipeline/delete',          [PipelineController::class, 'delete'])->name('admin.pipeline.delete')->middleware('can:'.AdminPermission::DELETE_PIPELINE->name);
    Route::post('pipeline/move',            [PipelineController::class, 'move'])->name('admin.pipeline.move')->middleware('can:'.AdminPermission::UPDATE_PIPELINE->name);
    Route::post('pipeline/sort',            [PipelineController::class, 'sort'])->name('admin.pipeline.sort')->middleware('can:'.AdminPermission::UPDATE_PIPELINE->name);
    Route::post('pipeline/add-customer',    [PipelineController::class, 'addCustomer'])->name('admin.pipeline.add_customer')->middleware('can:'.AdminPermission::UPDATE_PIPELINE->name);


    Route::get('orders/list',               [OrderController::class, 'list'])->name('admin.orders.list')->middleware('can:'.AdminPermission::LIST_ORDER->name);
    Route::post('orders/all',               [OrderController::class, 'all'])->name('admin.orders.all')->middleware('can:'.AdminPermission::LIST_ORDER->name);
    Route::post('orders/store',             [OrderController::class, 'store'])->name('admin.orders.store')->middleware('can:'.AdminPermission::CREATE_ORDER->name);
    Route::get('orders/show',               [OrderController::class, 'show'])->name('admin.orders.show')->middleware('can:'.AdminPermission::SHOW_ORDER->name);
    Route::post('orders/delete',            [OrderController::class, 'delete'])->name('admin.orders.delete')->middleware('can:'.AdminPermission::DELETE_ORDER->name);
    Route::post('orders/change-pipeline',   [OrderController::class, 'changePipeline'])->name('admin.orders.change_pipeline')->middleware('can:'.AdminPermission::UPDATE_ORDER->name);
    Route::post('orders/sort',              [OrderController::class, 'sortOrders'])->name('admin.orders.sort')->middleware('can:'.AdminPermission::UPDATE_ORDER->name);


    // Leads
    Route::get('leads',                         [LeadController::class, 'index'])->name('admin.leads.index')->middleware('can:'.AdminPermission::LIST_LEAD->name);
    Route::post('leads',                        [LeadController::class, 'store'])->name('admin.leads.store')->middleware('can:'.AdminPermission::CREATE_LEAD->name);
    Route::get('leads/{id}',                    [LeadController::class, 'show'])->name('admin.leads.show')->middleware('can:'.AdminPermission::SHOW_LEAD->name);
    Route::put('leads/{id}',                    [LeadController::class, 'update'])->name('admin.leads.update')->middleware('can:'.AdminPermission::UPDATE_LEAD->name);
    Route::delete('leads/{id}',                 [LeadController::class, 'destroy'])->name('admin.leads.destroy')->middleware('can:'.AdminPermission::DELETE_LEAD->name);


    Route::post('leads/locations',              [LeadController::class, 'getLeadsMapLocation'])->name('admin.leads.locations')->middleware('can:'.AdminPermission::SHOW_LEAD->name);
    Route::post('leads/import',                 [LeadController::class, 'importLeads'])->name('admin.leads.import')->middleware('can:'.AdminPermission::UPDATE_LEAD->name);
    Route::post('leads/get-status',             [LeadController::class, 'getLeadStatus'])->name('admin.leads.get_status')->middleware('can:'.AdminPermission::UPDATE_LEAD->name);
    Route::post('leads/update-salesperson',     [LeadController::class, 'updateSalesperson'])->name('admin.leads.update_salesperson')->middleware('can:'.AdminPermission::UPDATE_LEAD->name);
    Route::post('leads/update-objection',       [LeadController::class, 'updateObjection'])->name('admin.leads.update_objection')->middleware('can:'.AdminPermission::UPDATE_LEAD->name);
    Route::post('leads/remove-objection',       [LeadController::class, 'removeObjection'])->name('admin.leads.remove_objection')->middleware('can:'.AdminPermission::UPDATE_LEAD->name);
    Route::post('leads/get-contract',           [LeadController::class, 'getContractDetail'])->name('admin.leads.get_contract')->middleware('can:'.AdminPermission::UPDATE_LEAD->name);
    Route::post('leads/download-contract-doc',  [LeadController::class, 'downloadContractDocument'])->name('admin.leads.download_contract_doc')->middleware('can:'.AdminPermission::UPDATE_LEAD->name);
    Route::post('leads/upload-contract-doc',    [LeadController::class, 'uploadContractDocument'])->name('admin.leads.upload_contract_doc')->middleware('can:'.AdminPermission::UPDATE_LEAD->name);
    Route::post('leads/update-contract-membership', [LeadController::class, 'updateContractMembership'])->name('admin.leads.update_contract_membership')->middleware('can:'.AdminPermission::UPDATE_LEAD->name);
    Route::post('leads/update-contract-products',   [LeadController::class, 'updateContractProducts'])->name('admin.leads.update_contract_products')->middleware('can:'.AdminPermission::UPDATE_LEAD->name);
    Route::post('leads/request-new-customer',   [LeadController::class, 'requestNewCustomer'])->name('admin.leads.request_new_customer')->middleware('can:'.AdminPermission::UPDATE_LEAD->name);
    Route::post('leads/create-order',           [LeadController::class, 'createLeadOrder'])->name('admin.leads.create_order')->middleware('can:'.AdminPermission::UPDATE_LEAD->name);
    Route::post('leads/approve-new-customer',   [LeadController::class, 'approveLeadNewCustomer'])->name('admin.leads.approve_new_customer')->middleware('can:'.AdminPermission::UPDATE_LEAD->name);
    Route::post('leads/bulk-update-salesperson', [LeadController::class, 'updateBulkLeadSalespersons'])->name('admin.leads.update_bulk_salesperson')->middleware('can:'.AdminPermission::UPDATE_LEAD->name);
    Route::post('leads/bulk-update-status',     [LeadController::class, 'updateBulkLeadStatus'])->name('admin.leads.update_bulk_status')->middleware('can:'.AdminPermission::UPDATE_LEAD->name);
    Route::post('leads/save-preferences',       [LeadController::class, 'saveLeadTablePreferences'])->name('admin.leads.save_table_preference')->middleware('can:'.AdminPermission::UPDATE_LEAD->name);


    Route::post('leads/create-product',         [LeadController::class, 'createLeadProduct'])->name('admin.leads.create_product')->middleware('can:'.AdminPermission::UPDATE_LEAD->name);
    Route::post('leads/update-product',         [LeadController::class, 'updateLeadProduct'])->name('admin.leads.update_product')->middleware('can:'.AdminPermission::UPDATE_LEAD->name);
    Route::post('leads/create-product-category', [LeadController::class, 'createLeadProductCategory'])->name('admin.leads.create_product_category')->middleware('can:'.AdminPermission::UPDATE_LEAD->name);
    Route::post('leads/update-product-category', [LeadController::class, 'updateLeadProductCategory'])->name('admin.leads.update_product_category')->middleware('can:'.AdminPermission::UPDATE_LEAD->name);
    Route::post('leads/added-products',         [LeadController::class, 'getLeadAddedProducts'])->name('admin.leads.added_products')->middleware('can:'.AdminPermission::UPDATE_LEAD->name);
    Route::post('leads/delete-added-product',   [LeadController::class, 'deleteAddedProduct'])->name('admin.leads.delete_added_product')->middleware('can:'.AdminPermission::UPDATE_LEAD->name);

    Route::get('leads/notes/list',              [LeadController::class, 'getLeadNotes'])->name('admin.leads.notes')->middleware('can:'.AdminPermission::LIST_NOTE->name);
    Route::post('leads/notes/add',              [LeadController::class, 'addLeadNote'])->name('admin.leads.add_note')->middleware('can:'.AdminPermission::CREATE_NOTE->name);
    Route::post('leads/change-status',          [LeadController::class, 'changeStatus'])->name('admin.leads.change_status')->middleware('can:'.AdminPermission::UPDATE_LEAD->name);

    Route::post('leads/appointments/list',      [LeadAppointmentController::class, 'listAll'])->name('admin.lead.appointment.list')->middleware('can:'.AdminPermission::LIST_LEAD_APPOINTMENT->name);
    Route::post('leads/appointment/store',      [LeadAppointmentController::class, 'store'])->name('admin.lead.appointment.store')->middleware('can:'.AdminPermission::CREATE_LEAD_APPOINTMENT->name);
    Route::post('leads/appointment/show',       [LeadAppointmentController::class, 'show'])->name('admin.lead.appointment.show')->middleware('can:'.AdminPermission::SHOW_LEAD_APPOINTMENT->name);
    Route::post('leads/appointment/update',     [LeadAppointmentController::class, 'update'])->name('admin.lead.appointment.update')->middleware('can:'.AdminPermission::UPDATE_LEAD_APPOINTMENT->name);
    Route::post('leads/appointment/delete',     [LeadAppointmentController::class, 'destroy'])->name('admin.lead.appointment.destroy')->middleware('can:'.AdminPermission::DELETE_LEAD_APPOINTMENT->name);

    Route::post('leads/tasks/list',             [LeadTaskController::class, 'listAll'])->name('admin.lead.task.list')->middleware('can:'.AdminPermission::LIST_LEAD_TASK->name);
    Route::post('leads/task/store',             [LeadTaskController::class, 'store'])->name('admin.lead.task.store')->middleware('can:'.AdminPermission::CREATE_LEAD_TASK->name);
    Route::post('leads/task/show',              [LeadTaskController::class, 'show'])->name('admin.lead.task.show')->middleware('can:'.AdminPermission::SHOW_LEAD_TASK->name);
    Route::post('leads/task/update',            [LeadTaskController::class, 'update'])->name('admin.lead.task.update')->middleware('can:'.AdminPermission::UPDATE_LEAD_TASK->name);
    Route::post('leads/task/delete',            [LeadTaskController::class, 'destroy'])->name('admin.lead.task.destroy')->middleware('can:'.AdminPermission::DELETE_LEAD_TASK->name);

    Route::post('leads/documents/list',         [LeadDocumentController::class, 'listAll'])->name('admin.lead.document.list')->middleware('can:'.AdminPermission::LIST_LEAD_DOCUMENT->name);
    Route::post('leads/document/store',         [LeadDocumentController::class, 'store'])->name('admin.lead.document.store')->middleware('can:'.AdminPermission::CREATE_LEAD_DOCUMENT->name);
    Route::post('leads/document/delete',        [LeadDocumentController::class, 'destroy'])->name('admin.lead.document.destroy')->middleware('can:'.AdminPermission::DELETE_LEAD_DOCUMENT->name);
    Route::post('leads/document/download',      [LeadDocumentController::class, 'downloadDocument'])->name('admin.lead.document.download')->middleware('can:'.AdminPermission::DOWNLOAD_LEAD_DOCUMENT->name);

    Route::post('lead_status/all',              [LeadStatusController::class, 'getFilteredLeadStatus'])->name('admin.lead_status.all')->middleware('can:'.AdminPermission::LIST_LEAD_STATUS->name);
    Route::post('lead_status/create',           [LeadStatusController::class, 'store'])->name('admin.lead_status.create')->middleware('can:'.AdminPermission::CREATE_LEAD_STATUS->name);
    Route::post('lead_status/show',             [LeadStatusController::class, 'show'])->name('admin.lead_status.show')->middleware('can:'.AdminPermission::SHOW_LEAD_STATUS->name);
    Route::post('lead_status/update',           [LeadStatusController::class, 'update'])->name('admin.lead_status.update')->middleware('can:'.AdminPermission::UPDATE_LEAD_STATUS->name);
    Route::post('lead_status/delete',           [LeadStatusController::class, 'destroy'])->name('admin.lead_status.destroy')->middleware('can:'.AdminPermission::DELETE_LEAD_STATUS->name);
    Route::post('lead_status/set-default',      [LeadStatusController::class, 'setDefault'])->name('admin.lead_status.set_default')->middleware('can:'.AdminPermission::UPDATE_LEAD_STATUS->name);


    // Smart List
    Route::get('smart-list',                [SmartListController::class, 'list'])->name('admin.smart_list.list')->middleware('can:'.AdminPermission::SHOW_SMART_LIST->name);
    Route::get('smart-list/details',        [SmartListController::class, 'getDetails'])->name('admin.smart_list.details')->middleware('can:'.AdminPermission::SHOW_SMART_LIST->name);
    Route::post('smart-list',               [SmartListController::class, 'store'])->name('admin.smart_list.store')->middleware('can:'.AdminPermission::CREATE_SMART_LIST->name);
    Route::post('smart-list/show',          [SmartListController::class, 'show'])->name('admin.smart_list.show')->middleware('can:'.AdminPermission::OPEN_SMART_LIST->name);
    Route::post('smart-list/delete',        [SmartListController::class, 'destroy'])->name('admin.smart_list.destroy')->middleware('can:'.AdminPermission::DELETE_SMART_LIST->name);


    // Mails
    Route::get('mails',                     [MailController::class, 'list'])->name('admin.mails.list')->middleware('can:'.AdminPermission::LIST_MAIL->name);
    Route::get('mails/{id}',                [MailController::class, 'show'])->name('admin.mails.show')->middleware('can:'.AdminPermission::LIST_MAIL->name);
    Route::put('mails/{id}',                [MailController::class, 'update'])->name('admin.mails.update')->middleware('can:'.AdminPermission::UPDATE_MAIL->name);


    // Settings
    Route::get('settings',                  [SettingController::class, 'list'])->name('admin.settings.list')->middleware('can:'.AdminPermission::LIST_SETTING->name);
    Route::post('settings/update',          [SettingController::class, 'update'])->name('admin.settings.update')->middleware('can:'.AdminPermission::UPDATE_SETTING->name);


    // Notifications
    Route::post('notifications/all',            [NotificationController::class, 'getAllNotifications'])->name('admin.notifications.all')->middleware('can:'.AdminPermission::LIST_NOTIFICATION->name);
    Route::post('notifications/get-unread',     [NotificationController::class, 'getUnreadNotifications'])->name('admin.notifications.unread')->middleware('can:'.AdminPermission::LIST_NOTIFICATION->name);
    Route::post('notifications/get-read',       [NotificationController::class, 'getReadNotifications'])->name('admin.notifications.read')->middleware('can:'.AdminPermission::LIST_NOTIFICATION->name);
    Route::post('notifications/mark-read',      [NotificationController::class, 'markAsRead'])->name('admin.notifications.mark_read')->middleware('can:'.AdminPermission::LIST_NOTIFICATION->name);


    //Invoices
    Route::get('invoices/list',                 [InvoiceController::class, 'listInvoices'])->name('admin.invoices.list')->middleware('can:'.AdminPermission::LIST_INVOICE->name);
    Route::get('invoices/{id}',                 [InvoiceController::class, 'show'])->name('admin.invoices.show')->middleware('can:'.AdminPermission::LIST_INVOICE->name);
    Route::post('invoices/update',              [InvoiceController::class, 'update'])->name('admin.invoices.update')->middleware('can:'.AdminPermission::UPDATE_INVOICE->name);
    Route::delete('invoices/{id}',              [InvoiceController::class, 'destroy'])->name('admin.invoices.destroy')->middleware('can:'.AdminPermission::DELETE_INVOICE->name);
    Route::post('invoices/bulk-action',         [InvoiceController::class, 'updateBulkAction'])->name('admin.invoices.bulk_action')->middleware('can:'.AdminPermission::UPDATE_INVOICE->name);
    Route::post('invoices/download-invoice',    [InvoiceController::class, 'downloadInvoice'])->name('admin.invoices.download_invoice')->middleware('can:'.AdminPermission::LIST_INVOICE->name);
    Route::post('invoices/get-invoice-data',    [InvoiceController::class, 'getInvoiceData'])->name('admin.invoices.get_invoice_data')->middleware('can:'.AdminPermission::CREATE_INVOICE->name);
    Route::post('invoices/create-custom',       [InvoiceController::class, 'createCustomInvoice'])->name('admin.invoices.create_custom')->middleware('can:'.AdminPermission::CREATE_INVOICE->name);
    Route::post('invoices/invoice-no-by-date',  [InvoiceController::class, 'getInvoiceNoByDate'])->name('admin.invoices.invoice_no_by_date')->middleware('can:'.AdminPermission::CREATE_INVOICE->name);
    Route::post('invoices/set-paid',            [InvoiceController::class, 'setInvoicePaid'])->name('admin.invoices.set_paid')->middleware('can:'.AdminPermission::UPDATE_INVOICE->name);
    Route::post('invoices/set-unpaid',              [InvoiceController::class, 'setInvoiceUnpaid'])->name('admin.invoices.set_unpaid')->middleware('can:'.AdminPermission::UPDATE_INVOICE->name);
    Route::post('invoices/create-payment-reminder',     [InvoiceController::class, 'createPaymentReminder'])->name('admin.invoices.create_payment_reminder')->middleware('can:'.AdminPermission::UPDATE_INVOICE->name);
    Route::post('invoices/download-payment-reminder',   [InvoiceController::class, 'downloadPaymentReminder'])->name('admin.invoices.download_payment_reminder')->middleware('can:'.AdminPermission::UPDATE_INVOICE->name);
    Route::post('invoices/send-payment-reminder',       [InvoiceController::class, 'sendPaymentReminder'])->name('admin.invoices.send_payment_reminder')->middleware('can:'.AdminPermission::UPDATE_INVOICE->name);
    Route::post('invoices/create-payment-warning',      [InvoiceController::class, 'createPaymentWarning'])->name('admin.invoices.create_payment_warning')->middleware('can:'.AdminPermission::UPDATE_INVOICE->name);
    Route::post('invoices/download-payment-warning',    [InvoiceController::class, 'downloadPaymentWarning'])->name('admin.invoices.download_payment_warning')->middleware('can:'.AdminPermission::UPDATE_INVOICE->name);
    Route::post('invoices/send-payment-warning',        [InvoiceController::class, 'sendPaymentWarning'])->name('admin.invoices.send_payment_warning')->middleware('can:'.AdminPermission::UPDATE_INVOICE->name);

    Route::post('invoices/cancel-invoice',              [InvoiceController::class, 'cancelInvoice'])->name('admin.invoices.cancel_invoice')->middleware('can:'.AdminPermission::UPDATE_INVOICE->name);
    Route::post('invoices/download-cancelled-invoice',  [InvoiceController::class, 'downloadCancelledInvoice'])->name('admin.invoices.download_cancelled_invoice')->middleware('can:'.AdminPermission::UPDATE_INVOICE->name);
    Route::post('invoices/send-cancelled-invoice',      [InvoiceController::class, 'sendCancelledInvoice'])->name('admin.invoices.send_cancelled_invoice')->middleware('can:'.AdminPermission::UPDATE_INVOICE->name);
});


Route::prefix('admin')->middleware(['auth:admin', 'admin_permission_session', /*'cors'*/])->group( function () {

});


