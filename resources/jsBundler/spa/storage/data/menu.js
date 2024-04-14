import Permissions from "./AdminPermissions";
import {useServiceStore} from "@/storage/store/services";

const services = useServiceStore().services
    .filter((service) => service.is_active)
    .map((service) => {
        return {
            title: service.name,
            path: "/admin/orders/pipeline/" + service.id,
            active: false,
        }
    });

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
            "title": "Services",
            "icon": "fa fa-book",
            "type": "link",
            "path": "/admin/services",
            "active": false,
            "permission": Permissions.LIST_SERVICE,
            "skip_permission": false,
            "related": [
                "/admin/products/create",
                "/admin/products/*"
            ]
        },
        {
            "title": "Customers",
            "icon": "fa fa-user-plus",
            "type": "sub",
            "path": "/admin/customers",
            "active": false,
            "permission": Permissions.LIST_CUSTOMER,
            "skip_permission": false,
            "children": [
                {
                    title: "List",
                    path: "/admin/customers",
                    active: false,
                },
                {
                    title: "Birthday Calendar",
                    path: "/admin/customers/birthday-calendar",
                    active: false,
                }
            ],
            "related": [
                "/admin/customers/create",
                "/admin/customers/*",
                "/admin/customers/birthday-calendar"
            ]
        },
        {
            "title": "Orders",
            "icon": "fa fa-database",
            "type": "sub",
            "path": "/admin/orders",
            "active": false,
            "permission": Permissions.LIST_ORDER,
            "skip_permission": false,
            "children": [...[
                {
                    title: "List",
                    path: "/admin/orders",
                    active: false,
                },
            ], ...services],
            "related": [
                "/admin/orders/create",
                "/admin/orders/*"
            ]
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