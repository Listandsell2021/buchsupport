const Ziggy = {"url":"http:\/\/loc_buchsupport","port":null,"defaults":{},"routes":{"debugbar.openhandler":{"uri":"_debugbar\/open","methods":["GET","HEAD"]},"debugbar.clockwork":{"uri":"_debugbar\/clockwork\/{id}","methods":["GET","HEAD"]},"debugbar.assets.css":{"uri":"_debugbar\/assets\/stylesheets","methods":["GET","HEAD"]},"debugbar.assets.js":{"uri":"_debugbar\/assets\/javascript","methods":["GET","HEAD"]},"debugbar.cache.delete":{"uri":"_debugbar\/cache\/{key}\/{tags?}","methods":["DELETE"]},"sanctum.csrf-cookie":{"uri":"sanctum\/csrf-cookie","methods":["GET","HEAD"]},"ignition.healthCheck":{"uri":"_ignition\/health-check","methods":["GET","HEAD"]},"ignition.executeSolution":{"uri":"_ignition\/execute-solution","methods":["POST"]},"ignition.updateConfig":{"uri":"_ignition\/update-config","methods":["POST"]},"admin.dashboard.cards":{"uri":"api\/admin\/dashboard\/cards","methods":["POST"]},"admin.admins.index":{"uri":"api\/admin\/admins","methods":["GET","HEAD"]},"admin.admins.store":{"uri":"api\/admin\/admins","methods":["POST"]},"admin.admins.show":{"uri":"api\/admin\/admins\/{id}","methods":["GET","HEAD"]},"admin.admins.update":{"uri":"api\/admin\/admins\/{id}","methods":["PUT"]},"admin.admins.destroy":{"uri":"api\/admin\/admins\/{id}","methods":["DELETE"]},"admin.admins.auth_roles":{"uri":"api\/admin\/admins\/auth-roles","methods":["POST"]},"admin.admins.roles.list":{"uri":"api\/admin\/admins\/admin-roles","methods":["POST"]},"admin.admins.change_status":{"uri":"api\/admin\/admins\/change-status","methods":["POST"]},"admin.admins.bulk_action":{"uri":"api\/admin\/admins\/bulk-action","methods":["POST"]},"admin.admins.create_commission_pdf":{"uri":"api\/admin\/admins\/create-commission-pdf","methods":["POST"]},"admin.admins.commissions":{"uri":"api\/admin\/admins\/get-commissions","methods":["POST"]},"admin.admins.update_commission_paid_status":{"uri":"api\/admin\/admins\/update-commission-paid-status","methods":["POST"]},"admin.admins.download_commission":{"uri":"api\/admin\/admins\/download-commission","methods":["POST"]},"admin.roles.index":{"uri":"api\/admin\/roles","methods":["GET","HEAD"]},"admin.roles.store":{"uri":"api\/admin\/roles","methods":["POST"]},"admin.roles.show":{"uri":"api\/admin\/roles\/{id}","methods":["GET","HEAD"]},"admin.roles.update":{"uri":"api\/admin\/roles\/{id}","methods":["PUT"]},"admin.roles.destroy":{"uri":"api\/admin\/roles\/{id}","methods":["DELETE"]},"admin.roles.bulk_action":{"uri":"api\/admin\/roles\/bulk-action","methods":["POST"]},"admin.roles.change_status":{"uri":"api\/admin\/roles\/change-status","methods":["POST"]},"admin.roles.get_permissions":{"uri":"api\/admin\/roles\/get-permissions","methods":["POST"]},"admin.salespersons.get_active":{"uri":"api\/admin\/salespersons\/get-active","methods":["POST"]},"admin.salespersons.commission_graph":{"uri":"api\/admin\/salespersons\/commission-graph-data","methods":["POST"]},"admin.services.index":{"uri":"api\/admin\/services","methods":["GET","HEAD"]},"admin.services.store":{"uri":"api\/admin\/services","methods":["POST"]},"admin.services.show":{"uri":"api\/admin\/services\/{id}","methods":["GET","HEAD"]},"admin.services.update":{"uri":"api\/admin\/services\/{id}","methods":["PUT"]},"admin.services.destroy":{"uri":"api\/admin\/services\/{id}","methods":["DELETE"]},"admin.services.change_status":{"uri":"api\/admin\/services\/change-status","methods":["POST"]},"admin.services.all":{"uri":"api\/admin\/services\/all","methods":["POST"]},"admin.services.bulk_action":{"uri":"api\/admin\/services\/bulk-action","methods":["POST"]},"admin.customers.index":{"uri":"api\/admin\/customers","methods":["GET","HEAD"]},"admin.customers.store":{"uri":"api\/admin\/customers","methods":["POST"]},"admin.customers.show":{"uri":"api\/admin\/customers\/{id}","methods":["GET","HEAD"]},"admin.customers.update":{"uri":"api\/admin\/customers\/{id}","methods":["PUT"]},"admin.customers.destroy":{"uri":"api\/admin\/customers\/{id}","methods":["DELETE"]},"admin.customers.change_status":{"uri":"api\/admin\/customers\/change-status","methods":["POST"]},"admin.customers.bulk_action":{"uri":"api\/admin\/customers\/bulk-action","methods":["POST"]},"admin.customers.search":{"uri":"api\/admin\/customers\/search","methods":["POST"]},"admin.customers.memberships":{"uri":"api\/admin\/customers\/memberships","methods":["POST"]},"admin.customers.birthdays":{"uri":"api\/admin\/customers\/birthdays","methods":["POST"]},"admin.customers.products":{"uri":"api\/admin\/customers\/products","methods":["POST"]},"admin.customers.sort_products":{"uri":"api\/admin\/customers\/sort-products","methods":["POST"]},"admin.customers.download_document_pdf":{"uri":"api\/admin\/customers\/download-document-pdf","methods":["POST"]},"admin.customers.download_contract_doc":{"uri":"api\/admin\/customers\/download-contract-doc","methods":["POST"]},"admin.customers.upload_contract_doc":{"uri":"api\/admin\/customers\/upload-contract-doc","methods":["POST"]},"admin.customers.update_forms":{"uri":"api\/admin\/customers\/update-forms","methods":["POST"]},"admin.customers.update_invoice_setting":{"uri":"api\/admin\/customers\/update-invoice-setting","methods":["POST"]},"admin.pipeline.list":{"uri":"api\/admin\/pipeline\/list","methods":["POST"]},"admin.pipeline.all":{"uri":"api\/admin\/pipeline\/all","methods":["POST"]},"admin.pipeline.store":{"uri":"api\/admin\/pipeline\/store","methods":["POST"]},"admin.pipeline.delete":{"uri":"api\/admin\/pipeline\/delete","methods":["POST"]},"admin.pipeline.move":{"uri":"api\/admin\/pipeline\/move","methods":["POST"]},"admin.pipeline.sort":{"uri":"api\/admin\/pipeline\/sort","methods":["POST"]},"admin.pipeline.add_customer":{"uri":"api\/admin\/pipeline\/add-customer","methods":["POST"]},"admin.leads.index":{"uri":"api\/admin\/leads","methods":["GET","HEAD"]},"admin.leads.store":{"uri":"api\/admin\/leads","methods":["POST"]},"admin.leads.show":{"uri":"api\/admin\/leads\/{id}","methods":["GET","HEAD"]},"admin.leads.update":{"uri":"api\/admin\/leads\/{id}","methods":["PUT"]},"admin.leads.destroy":{"uri":"api\/admin\/leads\/{id}","methods":["DELETE"]},"admin.leads.locations":{"uri":"api\/admin\/leads\/locations","methods":["POST"]},"admin.leads.import":{"uri":"api\/admin\/leads\/import","methods":["POST"]},"admin.leads.get_status":{"uri":"api\/admin\/leads\/get-status","methods":["POST"]},"admin.leads.update_salesperson":{"uri":"api\/admin\/leads\/update-salesperson","methods":["POST"]},"admin.leads.update_objection":{"uri":"api\/admin\/leads\/update-objection","methods":["POST"]},"admin.leads.remove_objection":{"uri":"api\/admin\/leads\/remove-objection","methods":["POST"]},"admin.leads.get_contract":{"uri":"api\/admin\/leads\/get-contract","methods":["POST"]},"admin.leads.download_contract_doc":{"uri":"api\/admin\/leads\/download-contract-doc","methods":["POST"]},"admin.leads.upload_contract_doc":{"uri":"api\/admin\/leads\/upload-contract-doc","methods":["POST"]},"admin.leads.update_contract_membership":{"uri":"api\/admin\/leads\/update-contract-membership","methods":["POST"]},"admin.leads.update_contract_products":{"uri":"api\/admin\/leads\/update-contract-products","methods":["POST"]},"admin.leads.request_new_customer":{"uri":"api\/admin\/leads\/request-new-customer","methods":["POST"]},"admin.leads.approve_new_customer":{"uri":"api\/admin\/leads\/approve-new-customer","methods":["POST"]},"admin.leads.update_bulk_salesperson":{"uri":"api\/admin\/leads\/bulk-update-salesperson","methods":["POST"]},"admin.leads.update_bulk_status":{"uri":"api\/admin\/leads\/bulk-update-status","methods":["POST"]},"admin.leads.save_table_preference":{"uri":"api\/admin\/leads\/save-preferences","methods":["POST"]},"admin.leads.create_product":{"uri":"api\/admin\/leads\/create-product","methods":["POST"]},"admin.leads.update_product":{"uri":"api\/admin\/leads\/update-product","methods":["POST"]},"admin.leads.create_product_category":{"uri":"api\/admin\/leads\/create-product-category","methods":["POST"]},"admin.leads.update_product_category":{"uri":"api\/admin\/leads\/update-product-category","methods":["POST"]},"admin.leads.added_products":{"uri":"api\/admin\/leads\/added-products","methods":["POST"]},"admin.leads.delete_added_product":{"uri":"api\/admin\/leads\/delete-added-product","methods":["POST"]},"admin.leads.notes":{"uri":"api\/admin\/leads\/notes\/list","methods":["GET","HEAD"]},"admin.leads.add_note":{"uri":"api\/admin\/leads\/notes\/add","methods":["POST"]},"admin.leads.change_status":{"uri":"api\/admin\/leads\/change-status","methods":["POST"]},"admin.lead.appointment.list":{"uri":"api\/admin\/leads\/appointments\/list","methods":["POST"]},"admin.lead.appointment.store":{"uri":"api\/admin\/leads\/appointment\/store","methods":["POST"]},"admin.lead.appointment.show":{"uri":"api\/admin\/leads\/appointment\/show","methods":["POST"]},"admin.lead.appointment.update":{"uri":"api\/admin\/leads\/appointment\/update","methods":["POST"]},"admin.lead.appointment.destroy":{"uri":"api\/admin\/leads\/appointment\/delete","methods":["POST"]},"admin.lead.task.list":{"uri":"api\/admin\/leads\/tasks\/list","methods":["POST"]},"admin.lead.task.store":{"uri":"api\/admin\/leads\/task\/store","methods":["POST"]},"admin.lead.task.show":{"uri":"api\/admin\/leads\/task\/show","methods":["POST"]},"admin.lead.task.update":{"uri":"api\/admin\/leads\/task\/update","methods":["POST"]},"admin.lead.task.destroy":{"uri":"api\/admin\/leads\/task\/delete","methods":["POST"]},"admin.lead.document.list":{"uri":"api\/admin\/leads\/documents\/list","methods":["POST"]},"admin.lead.document.store":{"uri":"api\/admin\/leads\/document\/store","methods":["POST"]},"admin.lead.document.destroy":{"uri":"api\/admin\/leads\/document\/delete","methods":["POST"]},"admin.lead.document.download":{"uri":"api\/admin\/leads\/document\/download","methods":["POST"]},"admin.lead_status.all":{"uri":"api\/admin\/lead_status\/all","methods":["POST"]},"admin.lead_status.create":{"uri":"api\/admin\/lead_status\/create","methods":["POST"]},"admin.lead_status.show":{"uri":"api\/admin\/lead_status\/show","methods":["POST"]},"admin.lead_status.update":{"uri":"api\/admin\/lead_status\/update","methods":["POST"]},"admin.lead_status.destroy":{"uri":"api\/admin\/lead_status\/delete","methods":["POST"]},"admin.lead_status.set_default":{"uri":"api\/admin\/lead_status\/set-default","methods":["POST"]},"admin.smart_list.list":{"uri":"api\/admin\/smart-list","methods":["GET","HEAD"]},"admin.smart_list.details":{"uri":"api\/admin\/smart-list\/details","methods":["GET","HEAD"]},"admin.smart_list.store":{"uri":"api\/admin\/smart-list","methods":["POST"]},"admin.smart_list.show":{"uri":"api\/admin\/smart-list\/show","methods":["POST"]},"admin.smart_list.destroy":{"uri":"api\/admin\/smart-list\/delete","methods":["POST"]},"admin.mails.list":{"uri":"api\/admin\/mails","methods":["GET","HEAD"]},"admin.mails.show":{"uri":"api\/admin\/mails\/{id}","methods":["GET","HEAD"]},"admin.mails.update":{"uri":"api\/admin\/mails\/{id}","methods":["PUT"]},"admin.settings.list":{"uri":"api\/admin\/settings","methods":["GET","HEAD"]},"admin.settings.update":{"uri":"api\/admin\/settings\/update","methods":["POST"]},"admin.notifications.all":{"uri":"api\/admin\/notifications\/all","methods":["POST"]},"admin.notifications.unread":{"uri":"api\/admin\/notifications\/get-unread","methods":["POST"]},"admin.notifications.read":{"uri":"api\/admin\/notifications\/get-read","methods":["POST"]},"admin.notifications.mark_read":{"uri":"api\/admin\/notifications\/mark-read","methods":["POST"]},"admin.invoices.list":{"uri":"api\/admin\/invoices\/list","methods":["GET","HEAD"]},"admin.invoices.show":{"uri":"api\/admin\/invoices\/{id}","methods":["GET","HEAD"]},"admin.invoices.update":{"uri":"api\/admin\/invoices\/update","methods":["POST"]},"admin.invoices.destroy":{"uri":"api\/admin\/invoices\/{id}","methods":["DELETE"]},"admin.invoices.bulk_action":{"uri":"api\/admin\/invoices\/bulk-action","methods":["POST"]},"admin.invoices.download_invoice":{"uri":"api\/admin\/invoices\/download-invoice","methods":["POST"]},"admin.invoices.get_invoice_data":{"uri":"api\/admin\/invoices\/get-invoice-data","methods":["POST"]},"admin.invoices.create_custom":{"uri":"api\/admin\/invoices\/create-custom","methods":["POST"]},"admin.invoices.invoice_no_by_date":{"uri":"api\/admin\/invoices\/invoice-no-by-date","methods":["POST"]},"admin.invoices.set_paid":{"uri":"api\/admin\/invoices\/set-paid","methods":["POST"]},"admin.invoices.set_unpaid":{"uri":"api\/admin\/invoices\/set-unpaid","methods":["POST"]},"admin.invoices.create_payment_reminder":{"uri":"api\/admin\/invoices\/create-payment-reminder","methods":["POST"]},"admin.invoices.download_payment_reminder":{"uri":"api\/admin\/invoices\/download-payment-reminder","methods":["POST"]},"admin.invoices.send_payment_reminder":{"uri":"api\/admin\/invoices\/send-payment-reminder","methods":["POST"]},"admin.invoices.create_payment_warning":{"uri":"api\/admin\/invoices\/create-payment-warning","methods":["POST"]},"admin.invoices.download_payment_warning":{"uri":"api\/admin\/invoices\/download-payment-warning","methods":["POST"]},"admin.invoices.send_payment_warning":{"uri":"api\/admin\/invoices\/send-payment-warning","methods":["POST"]},"admin.invoices.cancel_invoice":{"uri":"api\/admin\/invoices\/cancel-invoice","methods":["POST"]},"admin.invoices.download_cancelled_invoice":{"uri":"api\/admin\/invoices\/download-cancelled-invoice","methods":["POST"]},"admin.invoices.send_cancelled_invoice":{"uri":"api\/admin\/invoices\/send-cancelled-invoice","methods":["POST"]},"salesperson.dashboard.cards":{"uri":"api\/salesperson\/dashboard\/card-info","methods":["POST"]},"salesperson.user.profile":{"uri":"api\/salesperson\/user\/profile","methods":["POST"]},"salesperson.user.update_profile":{"uri":"api\/salesperson\/user\/update-profile","methods":["POST"]},"salesperson.leads.all":{"uri":"api\/salesperson\/leads\/all","methods":["POST"]},"salesperson.leads.detail":{"uri":"api\/salesperson\/leads\/get-detail","methods":["POST"]},"salesperson.leads.create":{"uri":"api\/salesperson\/leads\/create","methods":["POST"]},"salesperson.leads.update":{"uri":"api\/salesperson\/leads\/update\/{id}","methods":["POST"]},"salesperson.leads.change_status":{"uri":"api\/salesperson\/leads\/change-status","methods":["POST"]},"salesperson.leads.status":{"uri":"api\/salesperson\/leads\/get-status","methods":["POST"]},"salesperson.activities.all":{"uri":"api\/salesperson\/leads\/activities","methods":["POST"]},"salesperson.appointments.all":{"uri":"api\/salesperson\/leads\/appointments","methods":["POST"]},"salesperson.leads.locations":{"uri":"api\/salesperson\/leads\/locations","methods":["POST"]},"salesperson.leads.get_contract":{"uri":"api\/salesperson\/leads\/get-contract","methods":["POST"]},"salesperson.leads.download_contract_doc":{"uri":"api\/salesperson\/leads\/download-contract-doc","methods":["POST"]},"salesperson.leads.upload_contract_doc":{"uri":"api\/salesperson\/leads\/upload-contract-doc","methods":["POST"]},"salesperson.leads.update_contract_membership":{"uri":"api\/salesperson\/leads\/update-contract-membership","methods":["POST"]},"salesperson.leads.update_contract_products":{"uri":"api\/salesperson\/leads\/update-contract-products","methods":["POST"]},"salesperson.leads.request_new_customer":{"uri":"api\/salesperson\/leads\/request-new-customer","methods":["POST"]},"salesperson.contract.products":{"uri":"api\/salesperson\/contract\/products","methods":["POST"]},"salesperson.contract.product_categories":{"uri":"api\/salesperson\/contract\/product-categories","methods":["POST"]},"salesperson.contract.memberships":{"uri":"api\/salesperson\/contract\/memberships","methods":["POST"]},"salesperson.contract.create_product_category":{"uri":"api\/salesperson\/contract\/create-product-category","methods":["POST"]},"salesperson.contract.create_product":{"uri":"api\/salesperson\/contract\/create-product","methods":["POST"]},"salesperson.leads.notes":{"uri":"api\/salesperson\/leads\/notes\/list","methods":["POST"]},"salesperson.leads.add_note":{"uri":"api\/salesperson\/leads\/notes\/add","methods":["POST"]},"salesperson.leads.delete_note":{"uri":"api\/salesperson\/leads\/notes\/delete","methods":["POST"]},"salesperson.smart_list.list":{"uri":"api\/salesperson\/smart-list\/list","methods":["POST"]},"salesperson.smart_list.store":{"uri":"api\/salesperson\/smart-list\/store","methods":["POST"]},"salesperson.smart_list.show":{"uri":"api\/salesperson\/smart-list\/show","methods":["POST"]},"salesperson.smart_list.destroy":{"uri":"api\/salesperson\/smart-list\/delete","methods":["POST"]},"salesperson.lead.task.list":{"uri":"api\/salesperson\/leads\/tasks\/list","methods":["POST"]},"salesperson.lead.task.store":{"uri":"api\/salesperson\/leads\/task\/store","methods":["POST"]},"salesperson.lead.task.update":{"uri":"api\/salesperson\/leads\/task\/update","methods":["POST"]},"salesperson.lead.task.destroy":{"uri":"api\/salesperson\/leads\/task\/delete","methods":["POST"]},"salesperson.lead.document.list":{"uri":"api\/salesperson\/leads\/documents\/list","methods":["POST"]},"salesperson.lead.document.store":{"uri":"api\/salesperson\/leads\/document\/store","methods":["POST"]},"salesperson.lead.document.destroy":{"uri":"api\/salesperson\/leads\/document\/delete","methods":["POST"]},"salesperson.lead.document.download":{"uri":"api\/salesperson\/leads\/document\/download","methods":["POST"]},"salesperson.lead.appointment.list":{"uri":"api\/salesperson\/leads\/appointments\/list","methods":["POST"]},"salesperson.lead.appointment.store":{"uri":"api\/salesperson\/leads\/appointment\/store","methods":["POST"]},"salesperson.lead.appointment.update":{"uri":"api\/salesperson\/leads\/appointment\/update","methods":["POST"]},"salesperson.lead.appointment.destroy":{"uri":"api\/salesperson\/leads\/appointment\/delete","methods":["POST"]},"salesperson.lead_status.add":{"uri":"api\/salesperson\/lead-status\/create","methods":["POST"]},"admin.login":{"uri":"admin\/login","methods":["POST"]},"admin.logout":{"uri":"admin\/logout","methods":["POST"]},"salesperson.login":{"uri":"salesperson\/login","methods":["POST"]},"salesperson.logout":{"uri":"salesperson\/logout","methods":["POST"]}}};

if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}

export { Ziggy };
