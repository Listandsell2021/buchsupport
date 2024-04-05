export default {
    admin: {
        list() {
            return [
                {
                    "url": "/admin/administrators",
                    "name": "Administrator",
                    "active": 0
                },
                {
                    "url": "",
                    "name": "List",
                    "active": 1
                }
            ];
        },
        create() {
            return [
                {
                    "url": "/admin/administrators",
                    "name": "Administrator",
                    "active": 0
                },
                {
                    "url": "",
                    "name": "Create",
                    "active": 1
                }
            ];
        },
        edit: (id) => {
            return [
                {
                    "url": "/admin/administrators",
                    "name": "Administrator",
                    "active": 0
                },
                {
                    "url": "/admin/administrators/" + id,
                    "name": "Edit",
                    "active": 0
                },
                {
                    "url": "",
                    "name": id,
                    "active": 1
                }
            ];
        }
    },

    role: {
        list() {
            return [
                {
                    "url": "/admin/roles",
                    "name": "Roles",
                    "active": 0
                },
                {
                    "url": "",
                    "name": "List",
                    "active": 1
                }
            ];
        },
        create() {
            return [
                {
                    "url": "/admin/roles",
                    "name": "Roles",
                    "active": 0
                },
                {
                    "url": "",
                    "name": "Create",
                    "active": 1
                }
            ];
        },
        edit: (id) => {
            return [
                {
                    "url": "/admin/roles",
                    "name": "Roles",
                    "active": 0
                },
                {
                    "url": "/admin/roles/" + id,
                    "name": "Edit",
                    "active": 0
                },
                {
                    "url": "",
                    "name": id,
                    "active": 1
                }
            ];
        }
    },

    product_category: {
        list() {
            return [
                {
                    "url": "/admin/product-categories",
                    "name": "Product Categories",
                    "active": 0
                },
                {
                    "url": "",
                    "name": "List",
                    "active": 1
                }
            ];
        },
        create() {
            return [
                {
                    "url": "/admin/product-categories",
                    "name": "Product Categories",
                    "active": 0
                },
                {
                    "url": "",
                    "name": "Create",
                    "active": 1
                }
            ];
        },
        edit: (id) => {
            return [
                {
                    "url": "/admin/product-categories",
                    "name": "Product Categories",
                    "active": 0
                },
                {
                    "url": "/admin/product-categories/" + id,
                    "name": "Edit",
                    "active": 0
                },
                {
                    "url": "",
                    "name": id,
                    "active": 1
                }
            ];
        }
    },
    service: {
        list() {
            return [
                {
                    "url": "/admin/services",
                    "name": "Services",
                    "active": 0
                },
                {
                    "url": "",
                    "name": "List",
                    "active": 1
                }
            ];
        },
        create() {
            return [
                {
                    "url": "/admin/products",
                    "name": "Products",
                    "active": 0
                },
                {
                    "url": "",
                    "name": "Create",
                    "active": 1
                }
            ];
        },
        edit: (id) => {
            return [
                {
                    "url": "/admin/products",
                    "name": "Products",
                    "active": 0
                },
                {
                    "url": "/admin/products/" + id,
                    "name": "Edit",
                    "active": 0
                },
                {
                    "url": "",
                    "name": id,
                    "active": 1
                }
            ];
        }
    },

    customer: {
        list() {
            return [
                {
                    "url": "/admin/customers",
                    "name": "Customers",
                    "active": 0
                },
                {
                    "url": "",
                    "name": "List",
                    "active": 1
                }
            ];
        },
        pipeline() {
            return [
                {
                    "url": "/admin/customers",
                    "name": "Customers",
                    "active": 0
                },
                {
                    "url": "",
                    "name": "Pipeline",
                    "active": 0
                }
            ];
        },
        create() {
            return [
                {
                    "url": "/admin/customers",
                    "name": "Customers",
                    "active": 0
                },
                {
                    "url": "",
                    "name": "Create",
                    "active": 1
                }
            ];
        },
        edit: (id) => {
            return [
                {
                    "url": "/admin/customers",
                    "name": "Customers",
                    "active": 0
                },
                {
                    "url": "/admin/customers/" + id,
                    "name": "Edit",
                    "active": 0
                },
                {
                    "url": "",
                    "name": id,
                    "active": 1
                }
            ];
        }
    },

    order: {
        list() {
            return [
                {
                    "url": "/admin/orders",
                    "name": "Orders",
                    "active": 0
                },
                {
                    "url": "",
                    "name": "List",
                    "active": 1
                }
            ];
        },
        create() {
            return [
                {
                    "url": "/admin/orders",
                    "name": "Orders",
                    "active": 0
                },
                {
                    "url": "",
                    "name": "Create",
                    "active": 1
                }
            ];
        },
        edit: (id) => {
            return [
                {
                    "url": "/admin/orders",
                    "name": "Orders",
                    "active": 0
                },
                {
                    "url": "/admin/orders/" + id,
                    "name": "Edit",
                    "active": 0
                },
                {
                    "url": "",
                    "name": id,
                    "active": 1
                }
            ];
        },
        view: (id) => {
            return [
                {
                    "url": "/admin/orders",
                    "name": "Orders",
                    "active": 0
                },
                {
                    "url": "/admin/orders/" + id,
                    "name": "View",
                    "active": 0
                },
                {
                    "url": "",
                    "name": id,
                    "active": 1
                }
            ];
        }
    },

    leads: {
        list() {
            return [
                {
                    "url": "/admin/leads",
                    "name": "Leads",
                    "active": 0
                },
                {
                    "url": "",
                    "name": "List",
                    "active": 1
                }
            ];
        },
        create() {
            return [
                {
                    "url": "/admin/leads",
                    "name": "Leads",
                    "active": 0
                },
                {
                    "url": "",
                    "name": "Create",
                    "active": 1
                }
            ];
        },
        edit: (id) => {
            return [
                {
                    "url": "/admin/leads",
                    "name": "Leads",
                    "active": 0
                },
                {
                    "url": "/admin/leads/" + id,
                    "name": "Detail",
                    "active": 0
                },
                {
                    "url": "",
                    "name": id,
                    "active": 1
                }
            ];
        }
    },
    mail: {
        list() {
            return [
                {
                    "url": "/admin/mail-management",
                    "name": "Mails",
                    "active": 0
                },
                {
                    "url": "",
                    "name": "List",
                    "active": 1
                }
            ];
        },
        edit: (id) => {
            return [
                {
                    "url": "/admin/mail-management",
                    "name": "Mails",
                    "active": 0
                },
                {
                    "url": "/admin/mail-management/" + id,
                    "name": "Edit",
                    "active": 0
                },
                {
                    "url": "",
                    "name": id,
                    "active": 1
                }
            ];
        }
    },
    setting: {
        list() {
            return [
                {
                    "url": "/admin/settings",
                    "name": "Settings",
                    "active": 0
                },
                {
                    "url": "",
                    "name": "List",
                    "active": 1
                }
            ];
        },
    },
    notification: {
        list() {
            return [
                {
                    "url": "/admin/notifications",
                    "name": "Notifications",
                    "active": 0
                },
                {
                    "url": "",
                    "name": "List",
                    "active": 1
                }
            ];
        },
    },
    comment: {
        list() {
            return [
                {
                    "url": "/admin/comments",
                    "name": "Comments",
                    "active": 0
                },
                {
                    "url": "",
                    "name": "List",
                    "active": 1
                }
            ];
        },
    },
    invoice: {
        list() {
            return [
                {
                    "url": "/admin/invoices",
                    "name": "Invoices",
                    "active": 0
                },
                {
                    "url": "",
                    "name": "List",
                    "active": 1
                }
            ];
        },
        create() {
            return [
                {
                    "url": "/admin/invoices/create",
                    "name": "Invoices",
                    "active": 0
                },
                {
                    "url": "",
                    "name": "Create",
                    "active": 1
                }
            ];
        },
        edit: (id) => {
            return [
                {
                    "url": "/admin/invoices",
                    "name": "Invoices",
                    "active": 0
                },
                {
                    "url": "/admin/invoices/" + id,
                    "name": "Edit",
                    "active": 0
                },
                {
                    "url": "",
                    "name": id,
                    "active": 1
                }
            ];
        }
    },
}