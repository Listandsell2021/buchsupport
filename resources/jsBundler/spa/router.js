import { createRouter, createWebHistory } from 'vue-router'
import guestAdmin from "@/middleware/guest-admin";
import authAdmin from "@/middleware/auth-admin";
import ziggyRoute from "@/libraries/utils/ZiggyRoute";
import ResourceFinder from "@/middleware/finder-resource";
import {useAuthStore} from "@/storage/store/auth";

const routes = [

    // Admin Routes
    {
        path: '/admin/login',
        beforeEnter: [guestAdmin],
        component: () => import('./pages/admin/login.vue'),
    },
    {
        path: '/admin',
        name: 'admin_section',
        beforeEnter: [authAdmin],
        component: () => import('./layouts/admin-panel.vue'),
        redirect: '/admin/dashboard',
        children: [
            {
                path: 'dashboard',
                name: 'admin_dashboard',
                component: () => import('./pages/admin/dashboard.vue'),
            },
            {
                path: 'administrators',
                name: 'administrator_list',
                component: () => import('./pages/admin/administrators/index.vue'),
            },
            {
                path: 'administrators/create',
                name: 'administrator_create',
                component: () => import('./pages/admin/administrators/create.vue'),
            },
            {
                path: 'administrators/:id',
                name: 'administrator_edit',
                props: route => ({ data: route.meta.data }),
                beforeEnter: [(route) => ResourceFinder(ziggyRoute('admin.admins.show', {id: route.params.id}), route)],
                component: () => import('./pages/admin/administrators/[id].vue'),
            },


            {
                path: 'roles',
                name: 'admin_roles',
                component: () => import('./pages/admin/roles/index.vue'),
            },
            {
                path: 'roles/create',
                name: 'admin_role_create',
                component: () => import('./pages/admin/roles/create.vue'),
            },
            {
                path: 'roles/:id',
                name: 'admin_role_edit',
                props: route => ({ data: route.meta.data }),
                beforeEnter: (route) => ResourceFinder(ziggyRoute('admin.roles.show', {id: route.params.id}), route),
                component: () => import('./pages/admin/roles/[id].vue'),
            },

            {
                path: 'settings',
                name: 'admin_settings',
                component: () => import('./pages/admin/settings/index.vue'),
            },


            {
                path: 'mail-management',
                name: 'admin_mail_list',
                component: () => import('./pages/admin/mail-management/index.vue'),
            },
            {
                path: 'mail-management/:id',
                name: 'admin_mail_edit',
                props: route => ({ data: route.meta.data }),
                beforeEnter: (route) => ResourceFinder(ziggyRoute('admin.mails.show', {id: route.params.id}), route),
                component: () => import('./pages/admin/mail-management/[id].vue'),
            },
            {
                path: 'notifications',
                name: 'admin_notifications',
                component: () => import('./pages/admin/notifications/index.vue'),
            },

            {
                path: 'services',
                name: 'admin_services',
                component: () => import('./pages/admin/services/index.vue'),
            },
            {
                path: 'services/create',
                name: 'admin_service_create',
                component: () => import('./pages/admin/services/create.vue'),
            },
            {
                path: 'services/:id',
                name: 'admin_service_edit',
                props: route => ({ data: route.meta.data }),
                beforeEnter: (route) => ResourceFinder(ziggyRoute('admin.services.show', {id: route.params.id}), route),
                component: () => import('./pages/admin/services/[id].vue'),
            },

            {
                path: 'customers',
                name: 'admin_customer_list',
                component: () => import('./pages/admin/customers/index.vue'),
            },
            {
                path: 'customers/create',
                name: 'admin_customer_create',
                component: () => import('./pages/admin/customers/create.vue'),
            },
            {
                path: 'customers/:id',
                name: 'admin_customer_edit',
                props: route => ({ data: route.meta.data }),
                beforeEnter: (route) => ResourceFinder(ziggyRoute('admin.customers.show', {id: route.params.id}), route),
                component: () => import('./pages/admin/customers/[id].vue'),
            },
            {
                path: 'customers/pipeline',
                name: 'admin_customer_pipeline',
                component: () => import('./pages/admin/customers/pipeline.vue'),
            },

            {
                path: 'orders',
                name: 'admin_orders',
                component: () => import('./pages/admin/orders/index.vue'),
            },
            {
                path: 'orders/create',
                name: 'admin_order_create',
                component: () => import('./pages/admin/orders/create.vue'),
            },
            {
                path: 'orders/detail/:id',
                name: 'admin_order_detail',
                props: route => ({ data: route.meta.data }),
                beforeEnter: (route) => ResourceFinder(ziggyRoute('admin.orders.show', {id: route.params.id}), route),
                component: () => import('./pages/admin/orders/[id].vue'),
            },
            {
                path: 'orders/pipeline/:id',
                name: 'admin_pipeline_edit',
                props: route => ({ data: route.meta.data }),
                beforeEnter: (route) => ResourceFinder(ziggyRoute('admin.orders.pipeline', {id: route.params.id}), route),
                component: () => import('./pages/admin/orders/kanban.vue'),
            },
            /*{
                path: 'orders/testing',
                name: 'admin_order_create2',
                component: () => import('./pages/admin/services/pipeline2.vue'),
            },*/


            {
                path: 'customers/birthday-calendar',
                name: 'admin_birthday_calendar',
                component: () => import('./pages/admin/customers/birthday_calendar.vue'),
            },

            {
                path: 'leads',
                name: 'admin_leads',
                component: () => import('./pages/admin/leads/index.vue'),
            },
            {
                path: 'leads/:id',
                name: 'admin_lead_detail',
                props: route => ({ data: route.meta.data }),
                beforeEnter: (route) => ResourceFinder(ziggyRoute('admin.leads.show', {id: route.params.id}), route),
                component: () => import('./pages/admin/leads/[id].vue'),
            },

            {
                path: 'invoices',
                name: 'admin_invoices',
                component: () => import('./pages/admin/invoices/index.vue'),
            },
            {
                path: 'invoices/create',
                name: 'admin_invoice_create',
                component: () => import('./pages/admin/invoices/create.vue'),
            },
            {
                path: 'invoices/:id',
                name: 'admin_invoice_edit',
                props: route => ({ data: route.meta.data }),
                beforeEnter: (route) => ResourceFinder(ziggyRoute('admin.invoices.show', {id: route.params.id}), route),
                component: () => import('./pages/admin/invoices/[id].vue'),
            },
        ],
    },
    {   path: "/admin/:pathMatch(.*)*",
        name: 'NotFound',
        component: () => import('./pages/error-404.vue'),
    },

];


const router = createRouter({
    routes,
    history: createWebHistory()
});

router.beforeEach((to, from, next) => {
    if (useAuthStore().hasAuth()) {
        useAuthStore().refreshAuthCookie();
    }

    next();
});

export default router;