const adminUrl = "/admin";
const customerUrl = "/customer";
const salesPersonUrl = "/salesperson";

export default {

    super_admin_role: 'super_admin',
    admin_role: 'admin',
    customer_role: 'customer',
    salesperson_role: 'salesperson',

    admin: {
        loginUrl:               adminUrl+"/login",
        logoutUrl:              adminUrl+"/logout",
        registerUrl:            adminUrl+"/register",
        emailVerificationUrl:   adminUrl+"/email/verification-notification",
        forgotPasswordUrl:      adminUrl+"/forgot-password",
        resetPasswordUrl:       adminUrl+"/reset-password",
        fetchUserUrl:           adminUrl+"/user-detail",

        redirectAfterLoginUrl:  adminUrl+"/dashboard",
        redirectAfterLogoutUrl: adminUrl+"/login"
    },

    customer: {
        loginUrl:               "user/login",
        logoutUrl:              "user/logout",
        registerUrl:            customerUrl+"/register",
        emailVerificationUrl:   customerUrl+"/email/verification-notification",
        forgotPasswordUrl:      customerUrl+"/forgot-password",
        resetPasswordUrl:       customerUrl+"/reset-password",
        fetchUserUrl:           "user/detail",

        redirectAfterLoginUrl:  customerUrl+"/dashboard",
        redirectAfterLogoutUrl: "/login"
    },

    salesperson: {
        loginUrl:               salesPersonUrl+"/login",
        logoutUrl:              salesPersonUrl+"/logout",
        registerUrl:            salesPersonUrl+"/register",
        emailVerificationUrl:   salesPersonUrl+"/email/verification-notification",
        forgotPasswordUrl:      salesPersonUrl+"/forgot-password",
        resetPasswordUrl:       salesPersonUrl+"/reset-password",
        fetchUserUrl:           salesPersonUrl+"/user-detail",

        redirectAfterLoginUrl:  salesPersonUrl+"/dashboard",
        redirectAfterLogoutUrl: salesPersonUrl+"/login"
    }

}