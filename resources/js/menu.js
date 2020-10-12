export default [
    {
        name: _t('dashboard', "Dashboard"),
        url: {name: 'Dashboard'},
        icon: 'fa fa-home',
        active: false,
    },
    {
        name: _t('transactions', 'Transactions'),
        url: false,
        icon: 'fa fa-warehouse',
        active: false,
        children: [
            {
                name: _t('add', 'Add'),
                url: {name: 'TransactionsAdd'},
                icon: 'nav-icon fas fa-chevron-right',
                active: false
            },
        ]
    },
    {
        name: _t('main_inventory', 'Main Inventory'),
        url: false,
        icon: 'fa fa-warehouse',
        active: false,
        children: [
            {
                name: _t('products', 'Products'),
                url: {name: 'ProductList'},
                icon: 'nav-icon fas fa-chevron-right',
                active: false
            },
            // {
            //     name: _t('check_ins', 'Check Ins'),
            //     url: {name: 'CheckInsList'},
            //     icon: 'nav-icon fas fa-chevron-right',
            //     active: false
            // },
            // {
            //     name: _t('check_outs', 'Check Outs'),
            //     url: {name: 'CheckOutsList'},
            //     icon: 'nav-icon fas fa-chevron-right',
            //     active: false
            // },
            {
                name: _t('categories', 'Categories'),
                url: {name: 'ProductCategories'},
                icon: 'nav-icon fas fa-chevron-right',
                active: false
            },
            // {
            //     name: _t('sub_categories', 'Sub Categories'),
            //     url: {name: 'ProductSubcategories'},
            //     icon: 'nav-icon fas fa-chevron-right',
            //     active: false
            // },
            {
                name: _t('brands', 'Brands'),
                url: {name: 'ProductBrands'},
                icon: 'nav-icon fas fa-chevron-right',
                active: false
            },
            {
                name: _t('units', 'Units'),
                url: {name: 'ProductUnits'},
                icon: 'nav-icon fas fa-chevron-right',
                active: false
            }
        ]
    },

    {
        name: _t('sales', 'Sales'),
        url: false,
        icon: 'fa fa-store-alt',
        active: false,
        children: [
            {
                name: _t('new_sale', 'New Sale'),
                url: {name: 'SalesAdd'},
                icon: 'nav-icon fas fa-chevron-right',
                active: false
            },
            {
                name: _t('list_sales', 'List Sales'),
                url: {name: 'SalesList'},
                icon: 'nav-icon fas fa-chevron-right',
                active: false
            },
            {
                name: _t('reports', "Reports"),
                url: {name: 'SalesReport'},
                icon: 'nav-icon fas fa-chevron-right',
                active: false
            },
        ]
    },
    {
        name: _t('purchases', 'Purchases'),
        url: false,
        icon: 'fa fa-cart-plus',
        active: false,
        children: [
            {
                name: _t('new_purchase', 'New Purchase'),
                url: {name: 'PurchasesAdd'},
                icon: 'nav-icon fas fa-chevron-right',
                active: false
            },
            {
                name: _t('list_purchases', 'List Purchases'),
                url: {name: 'PurchasesList'},
                icon: 'nav-icon fas fa-chevron-right',
                active: false
            }
        ]
    },
    {
        name: _t('contacts', 'Contacts'),
        url: false,
        icon: 'fa fa-address-book',
        active: false,
        children: [
            {
                name: _t('customers', 'Customers'),
                url: {name: 'ContactCustomers'},
                icon: 'nav-icon fas fa-chevron-right',
                active: false
            },
            {
                name: _t('suppliers', 'Suppliers'),
                url: {name: 'ContactSuppliers'},
                icon: 'nav-icon fas fa-chevron-right',
                active: false
            },
            {
                name: _t('employees', 'Employees'),
                url: {name: 'ContactEmployees'},
                icon: 'nav-icon fas fa-chevron-right',
                active: false
            },
        ]
    },
    {
        name: _t('sms', 'SMS'),
        url: false,
        icon: 'fa fa-address-book',
        active: false,
        children: [
            {
                name: _t('sms', 'SMS'),
                url: {name: 'SMSList'},
                icon: 'nav-icon fas fa-chevron-right',
                active: false
            },
        ]
    },
    // {
    //     name: _t('balance_sheet', 'Balance Sheet'),
    //     url: false,
    //     icon: 'fa fa-money-check-alt',
    //     active: false,
    //     children: [
    //         {
    //             name: _t('customers_balance', 'Customers Balance'),
    //             url: {name: 'CustomersBalanceSheet'},
    //             icon: 'nav-icon fas fa-chevron-right',
    //             active: false
    //         },
    //         {
    //             name: _t('suppliers_balance', 'Suppliers Balance'),
    //             url: {name: 'SuppliersBalanceSheet'},
    //             icon: 'nav-icon fas fa-chevron-right',
    //             active: false
    //         }
    //     ]
    // },
    {
        name: _t('capital_funds', 'Capital Funds'),
        url: false,
        icon: 'fa fa-money-check',
        active: false,
        children: [
            {
                name: _t('balance', 'Balance'),
                url: {name: 'CapitalBalance'},
                icon: 'nav-icon fas fa-chevron-right',
                active: false
            },
            {
                name: _t('deposits', 'Deposits') + " (" + _t('debit', 'Debit') + ")",
                url: {name: 'CapitalFundDeposits'},
                icon: 'nav-icon fas fa-chevron-right',
                active: false
            },
            {
                name: _t('withdraws', 'Withdraws') + " (" + _t('credit', 'Credit') + ")",
                url: {name: 'CapitalFundWithdraws'},
                icon: 'nav-icon fas fa-chevron-right',
                active: false
            }
        ]
    },
    {
        name: _t('expenses', 'Expenses'),
        url: false,
        icon: 'fa fa-hand-holding-usd',
        active: false,
        children: [
            {
                name: _t('categories', 'Categories'),
                url: {name: 'ExpenseCategories'},
                icon: 'nav-icon fas fa-chevron-right',
                active: false
            },
            {
                name: _t('list', 'List'),
                url: {name: 'ExpensesList'},
                icon: 'nav-icon fas fa-chevron-right',
                active: false
            },
        ]
    },
    {
        name: _t("user_management", "User Management"),
        url: false,
        icon: 'fa fa-users',
        active: false,
        children: [
            {
                name: _t('list', "list"),
                url: {name: 'UsersList'},
                icon: 'nav-icon fas fa-chevron-right',
                active: false
            },
            {
                name: _t('roles', "Roles"),
                url: {name: 'UserRoles'},
                icon: 'nav-icon fas fa-chevron-right',
                active: false
            },
            {
                name: _t("permissions", 'Permissions'),
                url: {name: 'UserPermissions'},
                icon: 'nav-icon fas fa-chevron-right',
                active: false
            },
            {
                name: _t('user_abilities', 'User Abilities'),
                url: {name: 'UserAbilityTest'},
                icon: 'nav-icon fas fa-chevron-right',
                active: false
            },
            {
                name: _t('role_abilities', 'Role Abilities'),
                url: {name: 'RoleAbilityTest'},
                icon: 'nav-icon fas fa-chevron-right',
                active: false
            },
        ]
    },
    {
        name: _t('reports', 'Reports'),
        url: false,
        icon: 'fa fa-wrench',
        active: false,
        children: [
            {
                name: _t('product_report', 'Product Report'),
                url: {name: 'DailyProductReport'},
                icon: 'nav-icon fas fa-chevron-right',
                active: false,
            },
            {
                name: _t('customer_collection', 'Customer Collection'),
                url: {name: 'DailyCustomerCollectionReport'},
                icon: 'nav-icon fas fa-chevron-right',
                active: false,
            },
            {
                name: _t('customer_sales', 'Customer Sales'),
                url: {name: 'DailyCustomerSalesReport'},
                icon: 'nav-icon fas fa-chevron-right',
                active: false,
            },
        ]
    },
    {
        name: _t('settings', 'Settings'),
        url: false,
        icon: 'fa fa-wrench',
        active: false,
        children: [
            {
                name: _t('preferences', 'Preferences'),
                url: {name: 'SettingsIndex'},
                icon: 'nav-icon fas fa-chevron-right',
                active: false,
            },
            {
                name: _t('languages', 'Languages'),
                url: {name: 'LanguagesList'},
                icon: 'nav-icon fas fa-chevron-right',
                active: false
            },

        ]
    },
]
