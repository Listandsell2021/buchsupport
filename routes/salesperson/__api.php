<?php

use App\Http\Controllers\API\Admin\CustomerController;
use App\Http\Controllers\API\Admin\LeadAppointmentController;
use App\Http\Controllers\API\Admin\LeadController;
use App\Http\Controllers\API\Admin\LeadDocumentController;
use App\Http\Controllers\API\Admin\LeadTaskController;
use App\Http\Controllers\API\Admin\ProductCategoryController;
use App\Http\Controllers\API\Admin\ServiceController;
use App\Http\Controllers\API\Admin\SmartListController;
use App\Http\Controllers\API\Salesperson\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('salesperson')->middleware(['auth:sanctum'])->group( function () {

    // Dashboard Cards
    Route::post('dashboard/card-info',              [DashboardController::class, 'getCardDetails'])->name('salesperson.dashboard.cards');
    Route::post('user/profile',                     [DashboardController::class, 'getUserProfile'])->name('salesperson.user.profile');
    Route::post('user/update-profile',              [DashboardController::class, 'updateUserProfile'])->name('salesperson.user.update_profile');

    Route::post('leads/all',                        [DashboardController::class, 'getFilteredLeads'])->name('salesperson.leads.all');
    Route::post('leads/get-detail',                 [DashboardController::class, 'getLeadDetail'])->name('salesperson.leads.detail');
    Route::post('leads/create',                     [LeadController::class, 'store'])->name('salesperson.leads.create');
    Route::post('leads/update/{id}',                [LeadController::class, 'update'])->name('salesperson.leads.update');
    Route::post('leads/change-status',              [LeadController::class, 'changeStatus'])->name('salesperson.leads.change_status');
    Route::post('leads/get-status',                 [LeadController::class, 'getLeadStatus'])->name('salesperson.leads.status');
    Route::post('leads/activities',                 [DashboardController::class, 'getAdminLeadActivities'])->name('salesperson.activities.all');
    Route::post('leads/appointments',               [DashboardController::class, 'getAdminAppointments'])->name('salesperson.appointments.all');
    Route::post('leads/locations',                  [LeadController::class, 'getLeadsMapLocation'])->name('salesperson.leads.locations');

    Route::post('leads/get-contract',               [LeadController::class, 'getContractDetail'])->name('salesperson.leads.get_contract');
    Route::post('leads/request-new-customer',       [LeadController::class, 'requestNewCustomer'])->name('salesperson.leads.request_new_customer');
    Route::post('leads/get-services',               [ServiceController::class, 'getAllServices'])->name('salesperson.leads.get_contract');


    // Lead Notes
    Route::post('leads/notes/list',             [LeadController::class, 'getLeadNotes'])->name('salesperson.leads.notes');
    Route::post('leads/notes/add',              [LeadController::class, 'addLeadNote'])->name('salesperson.leads.add_note');
    Route::post('leads/notes/delete',           [LeadController::class, 'deleteLeadNote'])->name('salesperson.leads.delete_note');

    // Smart List
    Route::post('smart-list/list',              [SmartListController::class, 'list'])->name('salesperson.smart_list.list');
    Route::post('smart-list/store',             [SmartListController::class, 'store'])->name('salesperson.smart_list.store');
    Route::post('smart-list/show',              [SmartListController::class, 'show'])->name('salesperson.smart_list.show');
    Route::post('smart-list/delete',            [SmartListController::class, 'destroy'])->name('salesperson.smart_list.destroy');

    // Lead Tasks
    Route::post('leads/tasks/list',             [LeadTaskController::class, 'listAll'])->name('salesperson.lead.task.list');
    Route::post('leads/task/store',             [LeadTaskController::class, 'store'])->name('salesperson.lead.task.store');
    Route::post('leads/task/update',            [LeadTaskController::class, 'update'])->name('salesperson.lead.task.update');
    Route::post('leads/task/delete',            [LeadTaskController::class, 'destroy'])->name('salesperson.lead.task.destroy');

    // Lead Documents
    Route::post('leads/documents/list',         [LeadDocumentController::class, 'listAll'])->name('salesperson.lead.document.list');
    Route::post('leads/document/store',         [LeadDocumentController::class, 'store'])->name('salesperson.lead.document.store');
    Route::post('leads/document/delete',        [LeadDocumentController::class, 'destroy'])->name('salesperson.lead.document.destroy');
    Route::post('leads/document/download',      [LeadDocumentController::class, 'downloadDocument'])->name('salesperson.lead.document.download');

    // Lead Appointments
    Route::post('leads/appointments/list',      [LeadAppointmentController::class, 'listAll'])->name('salesperson.lead.appointment.list');
    Route::post('leads/appointment/store',      [LeadAppointmentController::class, 'store'])->name('salesperson.lead.appointment.store');
    Route::post('leads/appointment/update',     [LeadAppointmentController::class, 'update'])->name('salesperson.lead.appointment.update');
    Route::post('leads/appointment/delete',     [LeadAppointmentController::class, 'destroy'])->name('salesperson.lead.appointment.destroy');

    // Lead Status
    Route::post('lead-status/create',           [LeadController::class, 'addLeadStatus'])->name('salesperson.lead_status.add');
    Route::post('lead/pipelines',               [LeadController::class, 'getLeadCustomerOrder'])->name('salesperson.lead_status.add');
});



