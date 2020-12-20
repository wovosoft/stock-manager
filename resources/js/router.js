import Vue from 'vue'
import VueRouter from "vue-router";

Vue.use(VueRouter);
const SalesAdd = () => import("@/components/sales/Add");
const PurchasesAdd = () => import("@/components/purchases/Add");
const ExpensesAdd = () => import("@/components/expenses/Add");
const ExpenseCategoriesAdd = () => import("@/components/expense_categories/Add");
const SMSAdd = () => import("@/components/sms/Add");
const ProductsAdd = () => import("@/components/products/Add");
const BrandsAdd = () => import("@/components/brands/Add");
// const SubcategoriesAdd = () => import("@/components/subcategories/Add");
const UnitsAdd = () => import("@/components/units/Add");
const LanguagesAdd = () => import("@/components/languages/Add");
export default new VueRouter({
    mode: 'history', // https://router.vuejs.org/api/#mode
    linkActiveClass: 'open active',
    scrollBehavior: () => ({y: 0}),
    base: '/',
    routes: [
        {
            path: '/',
            name: 'Dashboard',
            component: () => import('@/components/Dashboard'),
            meta: {
                disable_breadcrumb: true,
                title: _t('dashboard', 'Dashboard')
            }
        },
        {
            path: '/history/:model',
            name: 'ModelHistory',
            meta: {
                breadcrumb: 'History',
                title: _t('history', 'History'),
            },
            component: () => import('@/components/history/List')
        },
        {
            name: "Users",
            path: '/users',
            redirect: "/users/list",
            meta: {
                title: _t('users', 'Users')
            },
            component: () => import(/* webpackChunkName: "UsersRouted" */ "@/../wovosoft/laravel-permissions/js/src/MainRouted"),
            children: [
                {
                    path: 'list',
                    name: 'UsersList',
                    meta: {breadcrumb: 'List', title: _t('list', 'List')},
                    component: () => import("@/../wovosoft/laravel-permissions/js/src/components/users/List")
                },
                {
                    path: 'roles',
                    name: 'UserRoles',
                    meta: {breadcrumb: 'Roles', title: _t('roles', 'Roles')},
                    component: () => import("@/../wovosoft/laravel-permissions/js/src/components/roles/List")
                },
                {
                    path: 'permissions',
                    name: 'UserPermissions',
                    meta: {breadcrumb: 'Permissions', title: _t('permissions', 'Permissions')},
                    component: () => import("@/../wovosoft/laravel-permissions/js/src/components/permissions/List")
                },
                {
                    path: 'user-ability-test',
                    name: 'UserAbilityTest',
                    meta: {breadcrumb: 'User Abilities', title: _t('user_abilities', 'User Abilities')},
                    component: () => import("@/../wovosoft/laravel-permissions/js/src/components/ability_test/UserAbility")
                },
                {
                    path: 'role-ability-test',
                    name: 'RoleAbilityTest',
                    meta: {breadcrumb: 'Role Abilities', title: _t('role_abilities', 'Role Abilities')},
                    component: () => import("@/../wovosoft/laravel-permissions/js/src/components/ability_test/RoleAbility")
                },

            ]
        },
        {
            name: "Sales",
            path: '/sales',
            redirect: "/sales/list",
            meta: {title: _t('sales', 'Sales')},
            component: {
                render: (c) => c('router-view')
            },
            children: [
                {
                    path: 'add/:id?',
                    name: 'SalesAdd',
                    meta: {breadcrumb: 'Add', title: _t('new_sale', 'New Sale')},
                    component: SalesAdd
                },
                {
                    path: 'edit/:id?',
                    name: 'SalesEdit',
                    meta: {breadcrumb: 'Edit', title: _t('sales_edit', 'Sales Edit')},
                    component: SalesAdd
                },
                {
                    path: 'list',
                    name: 'SalesList',
                    meta: {breadcrumb: 'Sales List', title: _t('list_sales', 'Sales List')},
                    component: () => import("@/components/sales/List"),
                    children: [
                        {
                            path: 'view/:id?',
                            name: 'SalesView',
                            meta: {breadcrumb: 'View', title: _t('view_sale', 'View Sale')},
                            component: () => import("@/components/sales/View")
                        },
                    ]
                },
                {
                    path: 'returns_list',
                    name: 'ReturnsList',
                    meta: {breadcrumb: 'Returns List', title: _t('list_returns', 'List Returns')},
                    component: () => import("@/components/sales/returns/List"),
                    children: [
                        {
                            path: 'view/:id?',
                            name: 'ReturnsView',
                            meta: {breadcrumb: 'View Return', title: _t('view_return', 'View Return')},
                            component: () => import("@/components/sales/returns/View")
                        },
                    ]
                },
                {
                    path: 'order_list',
                    name: 'OrdersList',
                    meta: {breadcrumb: 'Orders List', title: _t('order_returns', 'List Orders')},
                    component: () => import("@/components/sales/orders/List"),
                    children: [
                        {
                            path: 'add',
                            name: 'OrdersAdd',
                            meta: {breadcrumb: 'Add', title: _t('new_order', 'New Order')},
                            component: () => import("@/components/sales/orders/Add")
                        },
                        {
                            path: 'add/:id?',
                            name: 'OrdersEdit',
                            meta: {breadcrumb: 'Add', title: _t('edit_order', 'Edit Order')},
                            component: () => import("@/components/sales/orders/Add")
                        },
                        {
                            path: 'view/:id?',
                            name: 'OrdersView',
                            meta: {breadcrumb: 'View Return', title: _t('view_order', 'View Order')},
                            component: () => import("@/components/sales/orders/View")
                        },
                    ]
                }
            ]
        },
        {
            name: "Purchases",
            path: '/purchases',
            redirect: "/purchases/list",
            component: {
                render: (c) => c('router-view')
            },
            children: [
                {
                    path: 'add/:id?',
                    name: 'PurchasesAdd',
                    meta: {breadcrumb: 'Add', title: _t('new_purchase', 'New Purchase')},
                    component: PurchasesAdd
                },
                {
                    path: 'edit/:id?',
                    name: 'PurchasesEdit',
                    meta: {breadcrumb: 'Edit', title: _t('edit_purchase', 'Edit Purchase')},
                    component: PurchasesAdd
                },
                {
                    path: 'list',
                    name: 'PurchasesList',
                    meta: {breadcrumb: 'Purchases List', title: _t('list_purchases', 'List Purchases')},
                    component: () => import("@/components/purchases/List"),
                    children: [
                        {
                            path: 'view/:id?',
                            name: 'PurchasesView',
                            meta: {breadcrumb: 'View', title: _t('view_purchase', 'View Purchase')},
                            component: () => import("@/components/purchases/View")
                        },
                    ]
                },
                {
                    path: 'returns_list',
                    name: 'PurchaseReturnsList',
                    meta: {breadcrumb: 'Returns', title: _t('list_returns', 'List Returns')},
                    component: () => import("@/components/purchases/returns/List"),
                    children: [
                        {
                            path: 'view/:id?',
                            name: 'PurchaseReturnsView',
                            meta: {breadcrumb: 'View Return', title: _t('view_return', 'View Return')},
                            component: () => import("@/components/purchases/returns/View")
                        },
                    ]
                }
            ]
        },
        {
            name: "Contacts",
            path: '/contact',
            redirect: "/contact/suppliers",
            component: {
                render: (c) => c('router-view')
            },
            children: [
                {
                    path: 'suppliers',
                    name: 'ContactSuppliers',
                    meta: {breadcrumb: 'Suppliers'},
                    component: () => import("@/components/suppliers/List"),
                    children: [
                        {
                            path: 'add/:id?',
                            name: 'SuppliersAdd',
                            meta: {breadcrumb: 'Add'},
                            component: () => import("@/components/suppliers/Add")
                        },
                        {
                            path: 'view/:id?',
                            name: 'SuppliersView',
                            meta: {breadcrumb: 'View'},
                            component: () => import("@/components/suppliers/View")
                        },
                    ]
                },
                {
                    path: 'customers',
                    name: 'ContactCustomers',
                    meta: {breadcrumb: 'Customers'},
                    component: () => import("@/components/customers/List"),
                    children: [
                        {
                            path: 'add/:id?',
                            name: 'CustomersAdd',
                            meta: {breadcrumb: 'Add'},
                            component: () => import("@/components/customers/Add")
                        },
                        {
                            path: 'view/:id?',
                            name: 'CustomersView',
                            meta: {breadcrumb: 'View'},
                            component: () => import("@/components/customers/View")
                        },
                    ]
                },
                {
                    path: 'employees',
                    name: 'ContactEmployees',
                    meta: {breadcrumb: 'Employees'},
                    component: () => import("@/components/employees/List"),
                    children: [
                        {
                            path: 'add/:id?',
                            name: 'EmployeesAdd',
                            meta: {breadcrumb: 'Add'},
                            component: () => import("@/components/employees/Add")
                        },
                        {
                            path: 'view/:id?',
                            name: 'EmployeesView',
                            meta: {breadcrumb: 'View'},
                            component: () => import("@/components/employees/View")
                        },
                    ]
                }
            ]
        },
        {
            name: "Transactions",
            path: '/collections',
            redirect: "/transactions/collections",
            component: {
                render: (c) => c('router-view')
            },
            meta: {
                breadcrumb: 'Transactions'
            },
            children: [
                //show verified payments here
                {
                    path: 'list',
                    name: 'CollectionsList',
                    meta: {breadcrumb: 'List Collections', title: 'List Collections'},
                    component: () => import("@/components/collections/List"),
                    children: [
                        {
                            path: 'add',
                            name: 'CollectionsAdd',
                            meta: {breadcrumb: 'Add'},
                            component: () => import("@/components/collections/Add")
                        },
                        {
                            path: ':id/edit',
                            name: 'CollectionsEdit',
                            meta: {breadcrumb: 'Edit'},
                            component: () => import("@/components/collections/Add")
                        },
                        {
                            path: ':id/view',
                            name: 'CollectionsView',
                            meta: {breadcrumb: 'View'},
                            component: () => import("@/components/collections/View")
                        },
                    ]
                },
            ]
        },
        {
            name: "CapitalFunds",
            path: '/capital',
            redirect: "/capital/balance",
            component: {
                render: (c) => c('router-view')
            },
            meta: {
                breadcrumb: 'Capital Funds'
            },
            children: [
                {
                    path: 'balance',
                    name: 'CapitalBalance',
                    meta: {breadcrumb: 'Balance', title: 'Capital Fund Balance'},
                    component: () => import("@/components/capital/Balance"),
                },
                {
                    path: 'deposits',
                    name: 'CapitalFundDeposits',
                    meta: {breadcrumb: 'Deposits', title: 'Capital Fund Deposits'},
                    component: () => import("@/components/capital/capital_deposits/List"),
                    children: [
                        {
                            path: 'add',
                            name: 'CapitalDepositsAdd',
                            meta: {breadcrumb: 'Add'},
                            component: () => import("@/components/capital/capital_deposits/Add")
                        },
                        {
                            path: ':id/edit',
                            name: 'CapitalDepositsEdit',
                            meta: {breadcrumb: 'Edit'},
                            component: () => import("@/components/capital/capital_deposits/Add")
                        },
                        {
                            path: ':id/view',
                            name: 'CapitalDepositsView',
                            meta: {breadcrumb: 'View'},
                            component: () => import("@/components/capital/capital_deposits/View")
                        },
                    ]
                },
                {
                    path: 'withdraws',
                    name: 'CapitalFundWithdraws',
                    meta: {breadcrumb: 'Withdraws', title: 'Capital Fund Withdraws'},
                    component: () => import("@/components/capital/capital_withdraws/List"),
                    children: [
                        {
                            path: 'add',
                            name: 'CapitalWithdrawsAdd',
                            meta: {breadcrumb: 'Add'},
                            component: () => import("@/components/capital/capital_withdraws/Add")
                        },
                        {
                            path: ':id/edit',
                            name: 'CapitalWithdrawsEdit',
                            meta: {breadcrumb: 'Edit'},
                            component: () => import("@/components/capital/capital_withdraws/Add")
                        },
                        {
                            path: ':id/view',
                            name: 'CapitalWithdrawsView',
                            meta: {breadcrumb: 'View'},
                            component: () => import("@/components/capital/capital_withdraws/View")
                        },
                    ]
                }
            ]
        },
        {
            name: "Expenses",
            path: '/expenses',
            redirect: "/expenses/categories",
            component: {
                render: (c) => c('router-view')
            },
            meta: {
                breadcrumb: 'Expenses'
            },
            children: [
                {
                    path: 'list',
                    name: 'ExpensesList',
                    meta: {
                        breadcrumb: _t('list', 'List'),
                        title: _t('expense_list', 'Expense List')
                    },
                    component: () => import("@/components/expenses/List"),
                    children: [
                        {
                            path: 'add',
                            name: 'ExpensesAdd',
                            meta: {breadcrumb: 'Add'},
                            component: ExpensesAdd
                        },
                        {
                            path: ':id/edit',
                            name: 'ExpensesEdit',
                            meta: {breadcrumb: 'Edit'},
                            component: ExpensesAdd
                        },
                        {
                            path: ':id/view',
                            name: 'ExpensesView',
                            meta: {breadcrumb: 'View'},
                            component: () => import("@/components/expenses/View")
                        },
                    ]
                },
                {
                    path: 'categories',
                    name: 'ExpenseCategories',
                    meta: {breadcrumb: 'Categories', title: 'Expense Categories'},
                    component: () => import("@/components/expense_categories/List"),
                    children: [
                        {
                            path: 'add',
                            name: 'ExpenseCategoriesAdd',
                            meta: {breadcrumb: 'Add'},
                            component: ExpenseCategoriesAdd
                        },
                        {
                            path: ':id/edit',
                            name: 'ExpenseCategoriesEdit',
                            meta: {breadcrumb: 'Edit'},
                            component: ExpenseCategoriesAdd
                        },
                        {
                            path: ':id/view',
                            name: 'ExpenseCategoriesView',
                            meta: {breadcrumb: 'View'},
                            component: () => import("@/components/expense_categories/View")
                        },
                    ]
                }
            ]
        },
        {
            name: "SMS",
            path: '/sms',
            redirect: "/sms/list",
            component: {
                render: (c) => c('router-view')
            },
            meta: {
                breadcrumb: 'SMS'
            },
            children: [
                {
                    path: 'list',
                    name: 'SMSList',
                    meta: {breadcrumb: 'List', title: 'SMS List'},
                    component: () => import("@/components/sms/List"),
                    children: [
                        {
                            path: 'add',
                            name: 'SMSAdd',
                            meta: {breadcrumb: 'Add'},
                            component: SMSAdd
                        },
                        {
                            path: ':id/edit',
                            name: 'SMSEdit',
                            meta: {breadcrumb: 'Edit'},
                            component: SMSAdd
                        },
                        {
                            path: ':id/view',
                            name: 'SMSView',
                            meta: {breadcrumb: 'View'},
                            component: () => import("@/components/sms/View")
                        },
                    ]
                }
            ]
        },
        {
            name: "Main Inventory",
            path: '/product',
            redirect: "/product/list",
            component: {
                render: (c) => c('router-view')
            },
            children: [
                {
                    path: 'list',
                    name: 'ProductList',
                    meta: {breadcrumb: 'Products'},
                    component: () => import("@/components/products/List"),
                    children: [
                        {
                            path: 'add',
                            name: 'ProductsAdd',
                            meta: {breadcrumb: 'Add', title: _t('add_product', 'Add Product')},
                            component: ProductsAdd
                        },
                        {
                            path: ':id/edit',
                            name: 'ProductsEdit',
                            meta: {breadcrumb: 'Edit', title: _t('edit_product', 'Edit Product')},
                            component: ProductsAdd
                        },
                        {
                            path: ':id/view',
                            name: 'ProductsView',
                            meta: {breadcrumb: 'View', title: _t('view_product', 'View Product')},
                            component: () => import("@/components/products/View")
                        },
                    ]
                },
                {
                    path: 'categories',
                    name: 'ProductCategories',
                    meta: {breadcrumb: 'Categories'},
                    component: () => import("@/components/categories/List"),
                    children: [
                        {
                            path: 'add/:id?',
                            name: 'CategoriesAdd',
                            meta: {breadcrumb: 'Add'},
                            component: () => import("@/components/categories/Add")
                        },
                        {
                            path: 'view/:id?',
                            name: 'CategoriesView',
                            meta: {breadcrumb: 'View'},
                            component: () => import("@/components/categories/View")
                        },
                    ]
                },
                {
                    path: 'brands',
                    name: 'ProductBrands',
                    meta: {breadcrumb: 'Brands'},
                    component: () => import("@/components/brands/List"),
                    children: [
                        {
                            path: 'add',
                            name: 'BrandsAdd',
                            meta: {breadcrumb: 'Add'},
                            component: BrandsAdd
                        },
                        {
                            path: ':id/edit',
                            name: 'BrandsEdit',
                            meta: {breadcrumb: 'Edit'},
                            component: BrandsAdd
                        },
                        {
                            path: ':id/view',
                            name: 'BrandsView',
                            meta: {breadcrumb: 'View'},
                            component: () => import("@/components/brands/View")
                        },
                    ]
                },
                {
                    path: 'units',
                    name: 'ProductUnits',
                    meta: {breadcrumb: 'Units'},
                    component: () => import("@/components/units/List"),
                    children: [
                        {
                            path: 'add/:id?',
                            name: 'UnitsAdd',
                            meta: {breadcrumb: 'Add'},
                            component: UnitsAdd
                        },
                        {
                            path: ':id/edit',
                            name: 'UnitsEdit',
                            meta: {breadcrumb: 'Edit'},
                            component: UnitsAdd
                        },
                        {
                            path: ':id/view',
                            name: 'UnitsView',
                            meta: {breadcrumb: 'View'},
                            component: () => import("@/components/units/View")
                        },
                    ]
                },
            ]
        },
        {
            path: '/reports',
            redirect: '/reports/short_financial',
            name: 'Reports',
            component: {
                render: (c) => c('router-view')
            },
            children: [
                {
                    path: 'products',
                    name: 'DailyProductReport',
                    meta: {breadcrumb: 'Daily Products Report'},
                    component: () => import("@/components/reports/products/daily/List")
                },
                {
                    path: 'customer_sales',
                    name: 'DailyCustomerSalesReport',
                    meta: {breadcrumb: 'Sales Report'},
                    component: () => import("@/components/reports/customers/sales/List")
                },
                {
                    path: 'supplier_purchases',
                    name: 'DailySupplierPurchasesReport',
                    meta: {breadcrumb: 'Purchases Report'},
                    component: () => import("@/components/reports/suppliers/purchases/List")
                },
                {
                    path: 'income_expense',
                    name: 'IncomeExpenseReport',
                    meta: {breadcrumb: 'Income - Expense Report'},
                    component: () => import("@/components/reports/collection/InvomeExpense")
                },
                {
                    path: 'short_financial',
                    name: 'ShortFinancialReport',
                    meta: {breadcrumb: 'Short Financial Report'},
                    component: () => import("@/components/reports/accounts/ShortFinancialReport")
                }
            ]
        },
        {
            path: '/settings',
            name: 'Settings',
            component: {
                render: (c) => c('router-view')
            },
            children: [
                {
                    path: 'preferences',
                    name: 'SettingsIndex',
                    meta: {breadcrumb: 'Settings'},
                    component: () => import('@/components/settings/Index'),
                },
                {
                    path: 'languages',
                    name: 'LanguagesList',
                    meta: {breadcrumb: 'Languages List'},
                    component: () => import("@/components/languages/List"),
                    children: [
                        {
                            path: 'view/:id?',
                            name: 'LanguagesView',
                            meta: {breadcrumb: 'View'},
                            component: () => import("@/components/languages/View")
                        },
                        {
                            path: 'add/:id?',
                            name: 'LanguagesAdd',
                            meta: {breadcrumb: 'Add'},
                            component: LanguagesAdd
                        },
                        {
                            path: 'edit/:id?',
                            name: 'LanguagesEdit',
                            meta: {breadcrumb: 'Edit'},
                            component: LanguagesAdd
                        },
                    ]
                },
            ]
        }
    ]
});
