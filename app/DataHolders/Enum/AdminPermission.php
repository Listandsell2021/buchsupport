<?php

namespace App\DataHolders\Enum;

enum AdminPermission: string
{
    case LIST_ADMIN = 'List Admin';
    case CREATE_ADMIN = 'Create Admin';
    case SHOW_ADMIN = 'Show Admin';
    case UPDATE_ADMIN = 'Update Admin';
    case DELETE_ADMIN = 'Delete Admin';

    case LIST_ROLE = 'List Admin Role';
    case CREATE_ROLE = 'Create Admin Role';
    case SHOW_ROLE = 'Show Admin Role';
    case UPDATE_ROLE = 'Edit Admin Role';
    case DELETE_ROLE = 'Delete Admin Role';

    case LIST_SALESPERSON = 'List Salesperson';
    case CREATE_SALESPERSON = 'Create Salesperson';
    case SHOW_SALESPERSON = 'Show Salesperson';
    case UPDATE_SALESPERSON = 'Edit Salesperson';
    case DELETE_SALESPERSON = 'Delete Salesperson';

    case LIST_PRODUCT_CATEGORY = 'List Product Category';
    case CREATE_PRODUCT_CATEGORY = 'Create Product Category';
    case SHOW_PRODUCT_CATEGORY = 'Show Product Category';
    case UPDATE_PRODUCT_CATEGORY = 'Edit Product Category';
    case DELETE_PRODUCT_CATEGORY = 'Delete Product Category';

    case LIST_PRODUCT = 'List Product';
    case CREATE_PRODUCT = 'Create Product';
    case SHOW_PRODUCT = 'Show Product';
    case UPDATE_PRODUCT = 'Edit Product';
    case DELETE_PRODUCT = 'Delete Product';

    case LIST_CUSTOMER = 'List Customer';
    case CREATE_CUSTOMER = 'Create Customer';
    case SHOW_CUSTOMER = 'Show Customer';
    case UPDATE_CUSTOMER = 'Edit Customer';
    case DELETE_CUSTOMER = 'Delete Customer';

    case LIST_LEAD = 'List Lead';
    case CREATE_LEAD = 'Create Lead';
    case SHOW_LEAD = 'Show Lead';
    case UPDATE_LEAD = 'Edit Lead';
    case DELETE_LEAD = 'Delete Lead';

    case LIST_LEAD_STATUS = 'List Lead Status';
    case CREATE_LEAD_STATUS = 'Create Lead Status';
    case SHOW_LEAD_STATUS = 'Show Lead Status';
    case UPDATE_LEAD_STATUS = 'Edit Lead Status';
    case DELETE_LEAD_STATUS = 'Delete Lead Status';

    case LIST_LEAD_APPOINTMENT = 'List Lead Appointment';
    case CREATE_LEAD_APPOINTMENT = 'Create Lead Appointment';
    case SHOW_LEAD_APPOINTMENT = 'Show Lead Appointment';
    case UPDATE_LEAD_APPOINTMENT = 'Edit Lead Appointment';
    case DELETE_LEAD_APPOINTMENT = 'Delete Lead Appointment';

    case LIST_LEAD_TASK = 'List Lead Task';
    case CREATE_LEAD_TASK = 'Create Lead Task';
    case SHOW_LEAD_TASK = 'Show Lead Task';
    case UPDATE_LEAD_TASK = 'Edit Lead Task';
    case DELETE_LEAD_TASK = 'Delete Lead Task';

    case LIST_LEAD_DOCUMENT = 'List Lead Document';
    case CREATE_LEAD_DOCUMENT = 'Create Lead Document';
    case DOWNLOAD_LEAD_DOCUMENT = 'Download Lead Document';
    case UPDATE_LEAD_DOCUMENT = 'Edit Lead Document';
    case DELETE_LEAD_DOCUMENT = 'Delete Lead Document';

    case LIST_NOTE = 'List Note';
    case CREATE_NOTE = 'Create Note';

    case SHOW_SMART_LIST = 'Show Smart List';
    case CREATE_SMART_LIST = 'Create Smart List';
    case OPEN_SMART_LIST = 'Open Smart List';
    case DELETE_SMART_LIST = 'Delete Smart List';

    case LIST_MAIL = 'Show Mail List';
    case UPDATE_MAIL = 'Edit Mail';

    case LIST_SETTING = 'Show Settings';
    case UPDATE_SETTING = 'Edit Setting';

    case LIST_BIRTHDAY_CALENDAR = 'Show Birthday Calendar';

    case LIST_NOTIFICATION = 'List Notification';
    case UPDATE_NOTIFICATION = 'Update Notification';

    case LIST_COMMENT = 'List Comment';
    case UPDATE_COMMENT = 'Update Comment';
    case DELETE_COMMENT = 'Delete Comment';

    case LIST_USER_INQUIRY = 'List User Inquiry';
    case UPDATE_USER_INQUIRY = 'Update User Inquiry';
    case DELETE_USER_INQUIRY = 'Delete User Inquiry';

    case LIST_INVOICE = 'List Invoice';
    case CREATE_INVOICE = 'Create Invoice';
    case UPDATE_INVOICE = 'Update Invoice';
    case DELETE_INVOICE = 'Delete Invoice';

    case LIST_PIPELINE = 'List Pipeline';
    case CREATE_PIPELINE = 'Create Pipeline';
    case SHOW_PIPELINE = 'Show Pipeline';
    case UPDATE_PIPELINE = 'Edit Pipeline';
    case DELETE_PIPELINE = 'Delete Pipeline';

    public static function all(): array
    {
        $permissions = [];
        foreach (self::cases() as $case) {
            $permissions[$case->name] = $case->value;
        }
        return $permissions;
    }

    public static function onlyNames(): array
    {
        $permissions = [];
        foreach (self::cases() as $case) {
            $permissions[$case->name] = $case->name;
        }
        return $permissions;
    }

}
