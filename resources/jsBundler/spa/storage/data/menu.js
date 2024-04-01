import Permissions from "./AdminPermissions";

export default {
    "data": [
        {
            "title": "Dashboard",
            "icon": "fa fa-home",
            "type": "link",
            "path": "/admin/dashboard",
            "active": false,
            "permission": "",
            "skip_permission": true
        },
        {
            "title": "Administrators",
            "icon": "fa fa-user",
            "type": "link",
            "path": "/admin/administrators",
            "active": false,
            "permission": Permissions.LIST_ADMIN,
            "skip_permission": false,
            "related": [
                "/admin/administrators/create",
                "/admin/administrators/*"
            ]
        },
        {
            "title": "Roles",
            "icon": "fa fa-tasks",
            "type": "link",
            "path": "/admin/roles",
            "active": false,
            "permission": Permissions.LIST_ROLE,
            "skip_permission": false,
            "related": [
                "/admin/roles/create",
                "/admin/roles/*"
            ]
        },
        {
            "title": "Settings",
            "icon": "fa fa-cog",
            "type": "link",
            "path": "/admin/settings",
            "active": false,
            "permission": Permissions.LIST_SETTING,
            "skip_permission": false
        },
        {
            "title": "Mail Management",
            "icon": "fa fa-envelope",
            "type": "link",
            "path": "/admin/mail-management",
            "active": false,
            "permission": Permissions.LIST_MAIL,
            "skip_permission": false,
            "related": ["/admin/mail-management/*"]
        },
        {
            "title": "Comments",
            "icon": "fa fa-comments",
            "type": "link",
            "path": "/admin/comments",
            "active": false,
            "permission": Permissions.LIST_NOTIFICATION,
            "skip_permission": false,
            "related": ["/admin/comments/*"]
        },
        {
            "title": "User Inquiries",
            "icon": "fa fa-anchor",
            "type": "link",
            "path": "/admin/inquiries",
            "active": false,
            "permission": Permissions.LIST_USER_INQUIRY,
            "skip_permission": false,
            "related": ["/admin/inquiries/*"]
        },
        {
            "title": "Notifications",
            "icon": "fa fa-inbox",
            "type": "link",
            "path": "/admin/notifications",
            "active": false,
            "permission": Permissions.LIST_NOTIFICATION,
            "skip_permission": false,
            "related": ["/admin/notifications/*"]
        },
        {
            "type": "breakline",
            "skip_permission": true
        },
        {
            "title": "Product Categories",
            "icon": "fa fa-list-alt",
            "type": "link",
            "path": "/admin/product-categories",
            "active": false,
            "permission": Permissions.LIST_PRODUCT_CATEGORY,
            "skip_permission": false,
            "related": [
                "/admin/product-categories/create",
                "/admin/product-categories/*"
            ]
        },
        {
            "title": "Products",
            "icon": "fa fa-book",
            "type": "link",
            "path": "/admin/products",
            "active": false,
            "permission": Permissions.LIST_PRODUCT,
            "skip_permission": false,
            "related": [
                "/admin/products/create",
                "/admin/products/*"
            ]
        },
        {
            "title": "Customers",
            "icon": "fa fa-user-plus",
            "type": "link",
            "path": "/admin/customers",
            "active": false,
            "permission": Permissions.LIST_CUSTOMER,
            "skip_permission": false,
            "related": [
                "/admin/customers/create",
                "/admin/customers/*"
            ]
        },
        {
            "title": "Birthday Calendar",
            "icon": "fa fa-birthday-cake",
            "type": "link",
            "path": "/admin/birthday-calendar",
            "active": false,
            "permission": Permissions.LIST_BIRTHDAY_CALENDAR,
            "skip_permission": false
        },
        {
            "type": "breakline",
            "skip_permission": true
        },
        {
            "title": "Lead Management",
            "icon": "fa fa-bullhorn",
            "type": "link",
            "path": "/admin/leads",
            "active": false,
            "permission": Permissions.LIST_LEAD,
            "skip_permission": false,
            "related": [
                "/admin/leads/create",
                "/admin/leads/*"
            ]
        },
        {
            "title": "Invoices",
            "icon": "fa fa-money",
            "type": "link",
            "path": "/admin/invoices",
            "active": false,
            "permission": Permissions.LIST_INVOICE,
            "skip_permission": false,
            "related": [
                "/admin/invoices/*"
            ]
        }
    ]
}