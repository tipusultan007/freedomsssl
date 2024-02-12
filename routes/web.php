<?php

use App\Http\Controllers\ExportController;
use App\Http\Controllers\GeneratedReportController;
use App\Http\Controllers\SavingsCollectionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\laravel_example\UserManagement;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\dashboard\Crm;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\layouts\CollapsedMenu;
use App\Http\Controllers\layouts\ContentNavbar;
use App\Http\Controllers\layouts\ContentNavSidebar;
use App\Http\Controllers\layouts\NavbarFull;
use App\Http\Controllers\layouts\NavbarFullSidebar;
use App\Http\Controllers\layouts\Horizontal;
use App\Http\Controllers\layouts\Vertical;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\front_pages\Landing;
use App\Http\Controllers\front_pages\Pricing;
use App\Http\Controllers\front_pages\Payment;
use App\Http\Controllers\front_pages\Checkout;
use App\Http\Controllers\front_pages\HelpCenter;
use App\Http\Controllers\front_pages\HelpCenterArticle;
use App\Http\Controllers\apps\Email;
use App\Http\Controllers\apps\Chat;
use App\Http\Controllers\apps\Calendar;
use App\Http\Controllers\apps\Kanban;
use App\Http\Controllers\apps\EcommerceDashboard;
use App\Http\Controllers\apps\EcommerceProductList;
use App\Http\Controllers\apps\EcommerceProductAdd;
use App\Http\Controllers\apps\EcommerceProductCategory;
use App\Http\Controllers\apps\EcommerceOrderList;
use App\Http\Controllers\apps\EcommerceOrderDetails;
use App\Http\Controllers\apps\EcommerceCustomerAll;
use App\Http\Controllers\apps\EcommerceCustomerDetailsOverview;
use App\Http\Controllers\apps\EcommerceCustomerDetailsSecurity;
use App\Http\Controllers\apps\EcommerceCustomerDetailsBilling;
use App\Http\Controllers\apps\EcommerceCustomerDetailsNotifications;
use App\Http\Controllers\apps\EcommerceManageReviews;
use App\Http\Controllers\apps\EcommerceReferrals;
use App\Http\Controllers\apps\EcommerceSettingsDetails;
use App\Http\Controllers\apps\EcommerceSettingsPayments;
use App\Http\Controllers\apps\EcommerceSettingsCheckout;
use App\Http\Controllers\apps\EcommerceSettingsShipping;
use App\Http\Controllers\apps\EcommerceSettingsLocations;
use App\Http\Controllers\apps\EcommerceSettingsNotifications;
use App\Http\Controllers\apps\AcademyDashboard;
use App\Http\Controllers\apps\AcademyCourse;
use App\Http\Controllers\apps\AcademyCourseDetails;
use App\Http\Controllers\apps\LogisticsDashboard;
use App\Http\Controllers\apps\LogisticsFleet;
use App\Http\Controllers\apps\InvoiceList;
use App\Http\Controllers\apps\InvoicePreview;
use App\Http\Controllers\apps\InvoicePrint;
use App\Http\Controllers\apps\InvoiceEdit;
use App\Http\Controllers\apps\InvoiceAdd;
use App\Http\Controllers\apps\UserList;
use App\Http\Controllers\apps\UserViewAccount;
use App\Http\Controllers\apps\UserViewSecurity;
use App\Http\Controllers\apps\UserViewBilling;
use App\Http\Controllers\apps\UserViewNotifications;
use App\Http\Controllers\apps\UserViewConnections;
use App\Http\Controllers\apps\AccessRoles;
use App\Http\Controllers\apps\AccessPermission;
use App\Http\Controllers\pages\UserProfile;
use App\Http\Controllers\pages\UserTeams;
use App\Http\Controllers\pages\UserProjects;
use App\Http\Controllers\pages\UserConnections;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsSecurity;
use App\Http\Controllers\pages\AccountSettingsBilling;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\Faq;
use App\Http\Controllers\pages\Pricing as PagesPricing;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\pages\MiscComingSoon;
use App\Http\Controllers\pages\MiscNotAuthorized;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\LoginCover;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\RegisterCover;
use App\Http\Controllers\authentications\RegisterMultiSteps;
use App\Http\Controllers\authentications\VerifyEmailBasic;
use App\Http\Controllers\authentications\VerifyEmailCover;
use App\Http\Controllers\authentications\ResetPasswordBasic;
use App\Http\Controllers\authentications\ResetPasswordCover;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\authentications\ForgotPasswordCover;
use App\Http\Controllers\authentications\TwoStepsBasic;
use App\Http\Controllers\authentications\TwoStepsCover;
use App\Http\Controllers\wizard_example\Checkout as WizardCheckout;
use App\Http\Controllers\wizard_example\PropertyListing;
use App\Http\Controllers\wizard_example\CreateDeal;
use App\Http\Controllers\modal\ModalExample;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\cards\CardAdvance;
use App\Http\Controllers\cards\CardStatistics;
use App\Http\Controllers\cards\CardAnalytics;
use App\Http\Controllers\cards\CardGamifications;
use App\Http\Controllers\cards\CardActions;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\Avatar;
use App\Http\Controllers\extended_ui\BlockUI;
use App\Http\Controllers\extended_ui\DragAndDrop;
use App\Http\Controllers\extended_ui\MediaPlayer;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\StarRatings;
use App\Http\Controllers\extended_ui\SweetAlert;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\extended_ui\TimelineBasic;
use App\Http\Controllers\extended_ui\TimelineFullscreen;
use App\Http\Controllers\extended_ui\Tour;
use App\Http\Controllers\extended_ui\Treeview;
use App\Http\Controllers\extended_ui\Misc;
use App\Http\Controllers\icons\Tabler;
use App\Http\Controllers\icons\FontAwesome;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_elements\CustomOptions;
use App\Http\Controllers\form_elements\Editors;
use App\Http\Controllers\form_elements\FileUpload;
use App\Http\Controllers\form_elements\Picker;
use App\Http\Controllers\form_elements\Selects;
use App\Http\Controllers\form_elements\Sliders;
use App\Http\Controllers\form_elements\Switches;
use App\Http\Controllers\form_elements\Extras;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\form_layouts\StickyActions;
use App\Http\Controllers\form_wizard\Numbered as FormWizardNumbered;
use App\Http\Controllers\form_wizard\Icons as FormWizardIcons;
use App\Http\Controllers\form_validation\Validation;
use App\Http\Controllers\tables\Basic as TablesBasic;
use App\Http\Controllers\tables\DatatableBasic;
use App\Http\Controllers\tables\DatatableAdvanced;
use App\Http\Controllers\tables\DatatableExtensions;
use App\Http\Controllers\charts\ApexCharts;
use App\Http\Controllers\charts\ChartJs;
use App\Http\Controllers\maps\Leaflet;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\ManagerLoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\AddProfitController;
use App\Http\Controllers\AdjustAmountController;
use App\Http\Controllers\CashInController;
use App\Http\Controllers\CashinCategoryController;
use App\Http\Controllers\CashoutCategoryController;
use App\Http\Controllers\CashoutController;
use App\Http\Controllers\ClosingAccountController;
use App\Http\Controllers\DailyCollectionController;
use App\Http\Controllers\DailyLoanCollectionController;
use App\Http\Controllers\DailyLoanController;
use App\Http\Controllers\DailyLoanPackageController;
use App\Http\Controllers\DailySavingsClosingController;
use App\Http\Controllers\DailySavingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DpsCollectionController;
use App\Http\Controllers\DpsController;
use App\Http\Controllers\DpsInstallmentController;
use App\Http\Controllers\DpsLoanCollectionController;
use App\Http\Controllers\DpsLoanController;
use App\Http\Controllers\DpsPackageController;
use App\Http\Controllers\DpsPackageValueController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FdrController;
use App\Http\Controllers\FdrDepositController;
use App\Http\Controllers\FdrPackageController;
use App\Http\Controllers\FdrPackageValueController;
use App\Http\Controllers\FdrProfitController;
use App\Http\Controllers\FdrWithdrawController;
use App\Http\Controllers\GuarantorController;
use App\Http\Controllers\IncomeCategoryController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\LoanDocumentsController;
use App\Http\Controllers\NomineesController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfitCollectionController;
use App\Http\Controllers\ResizeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SpecialDpsController;
use App\Http\Controllers\SpecialDpsLoanController;
use App\Http\Controllers\SpecialDpsPackageController;
use App\Http\Controllers\SpecialDpsPackageValueController;
use App\Http\Controllers\SpecialLoanTakenController;
use App\Http\Controllers\TakenLoanController;
use App\Http\Controllers\UserController;
// Admin routes
Route::prefix('admin')->group(function () {
  Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
  Route::post('login', [AdminLoginController::class, 'login']);
  Route::post('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
});
Route::get('login', [ManagerLoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [ManagerLoginController::class, 'login']);
Route::post('logout', [ManagerLoginController::class, 'logout'])->name('logout');
// Manager routes
/*Route::prefix('manager')->group(function () {
  Route::get('login', [ManagerLoginController::class, 'showLoginForm'])->name('manager.login');
  Route::post('login', [ManagerLoginController::class, 'login']);
  Route::post('logout', [ManagerLoginController::class, 'logout'])->name('manager.logout');
});*/
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard-crm');
// Admin routes
// Manager routes
Route::middleware(['web', 'manager'])->group(function () {
  //Route::get('/', [ManagerController::class, 'index'])->name('manager.home');

  //Route::get('/dashboard/analytics', [Analytics::class, 'index'])->name('dashboard');
  //Route::get('/dashboard/crm', [Crm::class, 'index'])->name('dashboard-crm');

  Route::resource('roles', RoleController::class);
  Route::resource('permissions', PermissionController::class);
  Route::resource('users', UserController::class);

  Route::get('userData', [UserController::class, 'userData']);
  Route::get('allUsers', [UserController::class, 'allUsers']);
  Route::post('users-import', [UserController::class, 'import'])->name('users.import');
  Route::get('userInfo/{id}', [UserController::class, 'userInfo']);
  Route::get('userProfile/{id}', [UserController::class, 'userProfile'])->name('user.profile.data');
  Route::get('userAccounts/{id}', [UserController::class, 'userAccounts']);
  Route::get('userLoans/{id}', [UserController::class, 'userLoans']);
  Route::get('/file-resize', [ResizeController::class, 'index']);
  Route::post('/resize-file', [ResizeController::class, 'resizeImage'])->name('resizeImage');
  Route::get('installment-panel', [DashboardController::class, 'installment']);

  /*
  |--------------------------------------------------------------------------
  |                          Daily Savings
  |--------------------------------------------------------------------------
  */


  Route::resource('daily-savings', DailySavingsController::class);
  Route::resource('adjust-amounts', AdjustAmountController::class);
  Route::resource('daily-collections', DailyCollectionController::class);
  Route::resource('daily-loans', DailyLoanController::class);
  Route::resource('daily-loan-collections', DailyLoanCollectionController::class);
  Route::resource('daily-loan-packages', DailyLoanPackageController::class);
  Route::resource('savings-collections', SavingsCollectionController::class);
  Route::resource('daily-savings-closings', DailySavingsClosingController::class);
  Route::resource('add-profits', AddProfitController::class);

  Route::get('allProfits', [AddProfitController::class, 'allProfits']);
  Route::get('profitDetails/{id}', [AddProfitController::class, 'profitDetails']);
  Route::get('getProfitById/{id}', [AddProfitController::class, 'getProfitById']);
  Route::get('savingsInfoByAccount/{account_no}', [DailySavingsController::class, 'savingsInfoByAccount']);
  Route::get('isSavingsExist/{account_no}', [DailySavingsController::class, 'isSavingsExist']);
  Route::get('dailySavingsData', [DailySavingsController::class, 'dailySavingsData']);
  Route::get('dailyLoanPackageData', [DailyLoanPackageController::class, 'dailyLoanPackageData']);
  Route::get('dailyLoanData', [DailyLoanController::class, 'dailyLoanData']);
  Route::get('dataByAccount/{account}', [DailyCollectionController::class, 'dataByAccount'])->name('data.savings.account');
  Route::get('dataSavingsCollection', [SavingsCollectionController::class, 'dataSavingsCollection']);
  Route::get('getSavingsCollectionData/{id}', [SavingsCollectionController::class, 'getData']);
  Route::get('getLoanCollectionData/{id}', [DailyLoanCollectionController::class, 'getLoanCollectionData']);
  Route::get('dataDailyLoanCollection', [DailyLoanCollectionController::class, 'dataDailyLoanCollection']);
  Route::get('getLoanCollectionDataByLoan', [DailyLoanController::class, 'getLoanCollectionDataByLoan']);
  Route::post('savings-collection-import', [SavingsCollectionController::class, 'import']);
  Route::post('dps-installment-import', [DpsInstallmentController::class, 'import']);
  Route::post('special-installment-import', [\App\Http\Controllers\SpecialInstallmentController::class, 'import']);
  Route::post('daily-loan-collection-import', [DailyLoanCollectionController::class, 'import']);
  Route::post('daily-loan-import', [DailyLoanController::class, 'import']);
  Route::get('getPackageInfo/{id}', [DailyLoanPackageController::class, 'getPackageInfo']);
  Route::get('daily-reset/{id}', [DailySavingsController::class, 'reset']);


  /*
  |--------------------------------------------------------------------------
  |                          DPS
  |--------------------------------------------------------------------------
  */


  Route::resource('dps', DpsController::class);
  Route::resource('dps-collections', DpsCollectionController::class);
  Route::resource('dps-installments', DpsInstallmentController::class);
  Route::resource('dps-loan-collections', DpsLoanCollectionController::class);
  Route::resource('dps-loans', DpsLoanController::class);
  Route::resource('dps-packages', DpsPackageController::class);
  Route::resource('dps-package-values', DpsPackageValueController::class);
  Route::resource('taken-loans', TakenLoanController::class);

  Route::get('dataDpsPackages', [DpsPackageController::class, 'dataDpsPackages']);
  Route::get('dps-exist/{account}', [DpsController::class, 'isExist']);
  Route::get('dataTakenLoanTransaction', [TakenLoanController::class, 'dataTakenLoanTransaction']);
  Route::get('deleteInterestByLoanId/{id}', [TakenLoanController::class, 'deleteInterestByLoanId']);
  Route::get('deleteLoanPaymentByLoanId/{id}', [TakenLoanController::class, 'deleteLoanPaymentByLoanId']);
  Route::get('dataTakenLoans', [TakenLoanController::class, 'dataTakenLoans']);
  Route::get('loanList/{id}', [DpsLoanController::class, 'loanList']);
  Route::get('dpsInfoByAccount/{account_no}', [DpsController::class, 'dpsInfoByAccount']);
  Route::get('dpsData', [DpsController::class, 'dpsData']);
  Route::get('dataDpsLoans', [DpsLoanController::class, 'dataDpsLoans']);
  Route::get('dataDpsLoanCollection', [DpsLoanCollectionController::class, 'dataDpsLoanCollection']);
  Route::get('dps-info', [DpsInstallmentController::class, 'dataByAccount']);
  Route::get('getDpsCollectionData/{id}', [DpsInstallmentController::class, 'getDpsCollectionData']);
  Route::get('getDpsLoanCollectionData/{id}', [DpsInstallmentController::class, 'getLoanCollectionData']);
  Route::get('dataDpsInstallment', [DpsInstallmentController::class, 'dataDpsInstallment']);
  Route::get('dataDpsCollection', [DpsCollectionController::class, 'dataDpsCollection']);
  Route::get('reset-dps/{id}', [DpsController::class, 'resetDps']);
  Route::get('reset-loan/{id}', [DpsLoanController::class, 'resetLoan']);

  Route::post('dps-import', [DpsController::class, 'import']);
  Route::post('dps-loan-import', [DpsLoanController::class, 'import']);

  Route::get('fetch-dps-installment/{id}',[DpsInstallmentController::class,'fetchInstallment']);
  /*
  |--------------------------------------------------------------------------
  |                          Special DPS
  |--------------------------------------------------------------------------
  */
  Route::resource('special-loan-collections', \App\Http\Controllers\SpecialLoanCollectionController::class);
  Route::resource('special-dps', SpecialDpsController::class);
  Route::resource('special-dps-loans', SpecialDpsLoanController::class);
  Route::resource('special-dps-packages', SpecialDpsPackageController::class);
  Route::resource('special-dps-package-values', SpecialDpsPackageValueController::class);
  Route::resource('special-loan-takens', SpecialLoanTakenController::class);
  Route::resource('special-installments', \App\Http\Controllers\SpecialInstallmentController::class);

  Route::get('fetch-special-dps-installment/{id}',[\App\Http\Controllers\SpecialInstallmentController::class,'fetchInstallment']);
  Route::get('dataSpecialTakenLoanTransaction', [SpecialLoanTakenController::class, 'dataTakenLoanTransaction']);
  Route::get('deleteSpecialInterestByLoanId/{id}', [SpecialLoanTakenController::class, 'deleteInterestByLoanId']);
  Route::get('deleteSpecialLoanPaymentByLoanId/{id}', [SpecialLoanTakenController::class, 'deleteLoanPaymentByLoanId']);
  Route::get('special-dps-exist/{account}', [SpecialDpsController::class, 'isExist']);
  Route::get('dataSpecialTakenLoans', [SpecialLoanTakenController::class, 'dataSpecialTakenLoans']);
  Route::get('dataSpecialLoanCollection', [\App\Http\Controllers\SpecialLoanCollectionController::class, 'dataDpsLoanCollection']);
  Route::get('dataSpecialDpsLoans', [SpecialDpsLoanController::class, 'dataSpecialDpsLoans']);

  Route::get('specialDpsInfoByAccount/{account_no}', [SpecialDpsController::class, 'specialDpsInfoByAccount']);
  Route::get('specialDpsData', [SpecialDpsController::class, 'specialDpsData']);
  Route::get('specialLoanList/{id}', [SpecialDpsLoanController::class, 'loanList']);
  Route::get('reset-special-dps/{id}', [SpecialDpsController::class, 'resetDps']);
  Route::get('reset-special-loan/{id}', [SpecialDpsLoanController::class, 'resetLoan']);
  Route::get('special-dps-info', [\App\Http\Controllers\SpecialInstallmentController::class, 'dataByAccount']);
  Route::get('dataSpecialDpsInstallment', [\App\Http\Controllers\SpecialInstallmentController::class, 'dataSpecialDpsInstallment']);
  Route::get('dataSpecialDpsCollection/{account}', [\App\Http\Controllers\SpecialDpsCollectionController::class, 'dataDpsCollection']);
  Route::get('getSpecialDpsCollectionData/{id}', [\App\Http\Controllers\SpecialInstallmentController::class, 'getDpsCollectionData']);
  Route::get('getSpecialDpsLoanCollectionData/{id}', [\App\Http\Controllers\SpecialInstallmentController::class, 'getLoanCollectionData']);
  /*
  |--------------------------------------------------------------------------
  |                          FDR
  |--------------------------------------------------------------------------
  */

  Route::resource('fdrs', FdrController::class);
  Route::resource('fdr-deposits', FdrDepositController::class);
  Route::resource('fdr-packages', FdrPackageController::class);
  Route::resource('fdr-package-values', FdrPackageValueController::class);
  Route::resource('fdr-profits', FdrProfitController::class);
  Route::resource('fdr-withdraws', FdrWithdrawController::class);
  Route::resource('profit-collections', ProfitCollectionController::class);

  Route::get('allPackages', [FdrPackageController::class, 'allPackages']);
  Route::get('allFdrDeposits', [FdrDepositController::class, 'allFdrDeposits']);
  Route::get('fdrDeposits/{id}', [FdrDepositController::class, 'fdrDeposits']);
  Route::get('allFdrs', [FdrController::class, 'allFdrs']);
  Route::get('is-fdr-exist/{account}', [FdrController::class, 'isExist']);
  Route::get('allFdrWithdraws', [FdrWithdrawController::class, 'allFdrWithdraws']);
  Route::get('profitInfo', [FdrProfitController::class, 'profitInfo']);
  Route::get('allFdrProfits', [FdrProfitController::class, 'allFdrProfits']);
  Route::get('getProfitList/{id}', [FdrProfitController::class, 'getProfitList']);
  Route::get('getFdrDeposit/{id}', [FdrDepositController::class, 'getFdrDeposit']);
  Route::get('getFdrWithdrawData/{id}', [FdrWithdrawController::class, 'getFdrWithdrawData']);

  /*
  |--------------------------------------------------------------------------
  |                          Settings
  |--------------------------------------------------------------------------
  */


  /*
  |--------------------------------------------------------------------------
  |                          Cash Management
  |--------------------------------------------------------------------------
  */

  Route::resource('cash-ins', CashInController::class);
  Route::resource('cashin-categories', CashinCategoryController::class);
  Route::resource('cashouts', CashoutController::class);
  Route::resource('cashout-categories', CashoutCategoryController::class);
  Route::resource('closing-accounts', ClosingAccountController::class);
  Route::resource('expenses', ExpenseController::class);
  Route::resource('expense-categories', ExpenseCategoryController::class);
  Route::resource('incomes', IncomeController::class);
  Route::resource('income-categories', IncomeCategoryController::class);
  Route::get('dataCashins', [CashInController::class, 'dataCashins']);
  Route::get('dataCashouts', [CashoutController::class, 'dataCashouts']);
  Route::get('allIncomes', [IncomeController::class, 'allIncomes']);
  Route::get('allExpenses', [ExpenseController::class, 'allExpenses']);
  Route::get('getIncomeById/{id}', [IncomeController::class, 'getIncomeById']);
  Route::get('getExpenseById/{id}', [ExpenseController::class, 'getExpenseById']);

  Route::get('cashinByCategory', [CashInController::class, 'cashinByCategory']);
  Route::get('cashoutByCategory', [CashoutController::class, 'cashoutByCategory']);


  /*
  |--------------------------------------------------------------------------
  |                          Reports
  |--------------------------------------------------------------------------
  */

  Route::get('cashbook', [\App\Http\Controllers\ReportController::class, 'cashbook']);
  Route::get('dataCashbook', [\App\Http\Controllers\ReportController::class, 'dataCashbook']);


  /*
  |--------------------------------------------------------------------------
  |                          Documents, Nominee & Guarantor
  |--------------------------------------------------------------------------
  */

  Route::resource('guarantors', GuarantorController::class);
  Route::resource('all-loan-documents', LoanDocumentsController::class);
  Route::resource('all-nominees', NomineesController::class);
  Route::get('getDetails/{id}', [GuarantorController::class, 'getDetails']);

  /*
  |--------------------------------------------------------------------------
  |                          Accounts
  |--------------------------------------------------------------------------
  */
  Route::resource('closing-accounts', \App\Http\Controllers\ClosingAccountController::class);
  Route::resource('accounts', \App\Http\Controllers\AccountController::class);
  Route::resource('transactions', \App\Http\Controllers\TransactionController::class);
  Route::get('allAccounts', [\App\Http\Controllers\AccountController::class, 'allAccounts']);
  Route::get('dataTransactions', [\App\Http\Controllers\TransactionController::class, 'dataTransactions'])->name('data.transactions');
  Route::get('allClosings', [ClosingAccountController::class, 'allClosings']);

  Route::get('activity-log', [\App\Http\Controllers\ActivityLogController::class,'index'])->name('activity-log.index');

  Route::get('test',[\App\Http\Controllers\TestController::class,'test']);

  Route::get('cash-report',[\App\Http\Controllers\TransactionController::class,'cashReport'])->name('cash.report');
  Route::get('cash-report-manager',[\App\Http\Controllers\TransactionController::class,'managerReport'])->name('manager.cash.report');
  Route::get('manager-transaction',[\App\Http\Controllers\TransactionController::class,'transactionByManager'])->name('manager.transactions');
  Route::get('cashin',[\App\Http\Controllers\TransactionController::class,'cashIn'])->name('cashin');
  Route::get('cashout',[\App\Http\Controllers\TransactionController::class,'cashOut'])->name('cashout');
  Route::get('data-manager-transactions',[\App\Http\Controllers\TransactionController::class,'dataManagerTransaction'])->name('data.manager.transactions');
  Route::get('data-cashin',[\App\Http\Controllers\TransactionController::class,'dataCashin'])->name('data.cashin');
  Route::get('data-cashout',[\App\Http\Controllers\TransactionController::class,'dataCashout'])->name('data.cashout');


  Route::resource('daily-savings-complete',\App\Http\Controllers\DailySavingsCompleteController::class);
  Route::resource('dps-complete',\App\Http\Controllers\DpsCompleteController::class);
  Route::resource('special-dps-complete',\App\Http\Controllers\SpecialDpsCompleteController::class);
  Route::resource('fdr-complete',\App\Http\Controllers\FdrCompleteController::class);

  Route::get('active-dps/{id}',[DpsController::class,'activeDps'])->name('active.dps');
  Route::get('active-special-dps/{id}',[SpecialDpsController::class,'activeDps'])->name('active.special.dps');
  Route::get('active-daily-savings/{id}',[DailySavingsController::class,'activeSavings'])->name('active.daily.savings');


  Route::get('summary-report',[\App\Http\Controllers\ReportController::class,'summaryReport'])->name('summary.report');

  Route::get('reset-daily-savings/{id}',[\App\Http\Controllers\ResetController::class,'dailySavings']);
  Route::get('reset-daily-loan/{id}',[\App\Http\Controllers\ResetController::class,'dailyLoan']);
  Route::get('reset-monthly-dps/{id}',[\App\Http\Controllers\ResetController::class,'monthly']);
  Route::get('reset-dps-loan/{id}',[\App\Http\Controllers\ResetController::class,'dpsLoan']);
  Route::get('reset-special-dps/{id}',[\App\Http\Controllers\ResetController::class,'special']);
  Route::get('reset-special-loan/{id}',[\App\Http\Controllers\ResetController::class,'specialLoan']);
  Route::get('reset-fdr/{id}',[\App\Http\Controllers\ResetController::class,'fdr']);



  Route::get('/daily-loan-chart-data', [Crm::class, 'getDailyLoanChartData'])->name('dailyLoanChartData');
  Route::get('/savings-chart-data', [Crm::class, 'getSavingsChartData'])->name('savingsChartData');
  Route::get('/dps-chart-data', [Crm::class, 'getDpsChartData'])->name('dpsChartData');


  Route::get('dpsImport',[\App\Http\Controllers\ImportController::class,'dpsInstallment']);
  Route::get('print-dps-form/{id}',[DpsController::class,'print'])->name('print.dps.form');

  //Route::resource('dps-completes',\App\Http\Controllers\DpsCompleteController::class);
  Route::get('notifications',[\App\Http\Controllers\NotificationController::class,'index'])->name('notifications.index');

  Route::get('/check-report-progress/{id}', [GeneratedReportController::class, 'checkReportProgress']);

  Route::get('/generate-pdf', [GeneratedReportController::class, 'generatePDF']);
  Route::get('/download/{filename}', [ExportController::class,'download'])->name('download.export');

  Route::resource('exports', ExportController::class);
  Route::get('exports/{export}/download', [ExportController::class, 'download'])->name('exports.download');

  Route::get('generate-report',[ExportController::class,'generateReport'])->name('generate.report');

  Route::resource('profits',\App\Http\Controllers\ProfitItemController::class);
  /*Route::post('profits',[\App\Http\Controllers\ProfitItemController::class,'store'])->name('profits.store');
  Route::post('profits-update',[\App\Http\Controllers\ProfitItemController::class,'update'])->name('profits.update');
  Route::post('profits-update',[\App\Http\Controllers\ProfitItemController::class,'update'])->name('profits.update');*/

  Route::get('accountList/{type}',[\App\Http\Controllers\ProfitItemController::class,'accountList']);
});


//Auth::routes();

//Route::get('/home', [Analytics::class, 'index'])->name('dashboard-analytics');
