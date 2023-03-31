<?php

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
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LoanDocumentsController;
use App\Http\Controllers\NomineesController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfitCollectionController;
use App\Http\Controllers\ResizeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SavingsCollectionController;
use App\Http\Controllers\SpecialDpsController;
use App\Http\Controllers\SpecialDpsLoanController;
use App\Http\Controllers\SpecialDpsPackageController;
use App\Http\Controllers\SpecialDpsPackageValueController;
use App\Http\Controllers\SpecialLoanTakenController;
use App\Http\Controllers\TakenLoanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Main Page Route
Route::get('/', [DashboardController::class, 'dashboardEcommerce'])->name('dashboard-ecommerce');

Route::get('send_sms', [DashboardController::class, 'send_sms']);

// locale Route
Route::get('lang/{locale}', [LanguageController::class, 'swap']);


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::prefix('/')->middleware('auth')->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('users', UserController::class);

Route::get('userData', [UserController::class, 'userData']);
Route::get('allUsers', [UserController::class, 'allUsers']);
Route::post('users-import', [UserController::class, 'import'])->name('users.import');
Route::get('userInfo/{id}', [UserController::class, 'userInfo']);
Route::get('userProfile/{id}', [UserController::class, 'userProfile']);
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

Route::get('allProfits',[AddProfitController::class,'allProfits']);
Route::get('profitDetails/{id}',[AddProfitController::class,'profitDetails']);
Route::get('getProfitById/{id}',[AddProfitController::class,'getProfitById']);
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
Route::post('daily-loan-collection-import', [DailyLoanCollectionController::class, 'import']);
Route::get('getPackageInfo/{id}', [DailyLoanPackageController::class, 'getPackageInfo']);
Route::get('daily-reset/{id}', [DailySavingsController::class, 'reset']);



/*
|--------------------------------------------------------------------------
|                          DPS
|--------------------------------------------------------------------------
*/


Route::resource('all-dps', DpsController::class);
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
Route::get('dataDpsCollection/{account}', [DpsCollectionController::class, 'dataDpsCollection']);
Route::get('reset-dps/{id}', [DpsController::class, 'resetDps']);
Route::get('reset-loan/{id}', [DpsLoanController::class, 'resetLoan']);

Route::post('dps-import', [DpsController::class, 'import']);
Route::post('dps-loan-import', [DpsLoanController::class, 'import']);

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
Route::get('dataCashins',[CashInController::class,'dataCashins']);
Route::get('dataCashouts',[CashoutController::class,'dataCashouts']);
Route::get('allIncomes',[IncomeController::class,'allIncomes']);
Route::get('allExpenses',[ExpenseController::class,'allExpenses']);
Route::get('getIncomeById/{id}',[IncomeController::class,'getIncomeById']);
Route::get('getExpenseById/{id}',[ExpenseController::class,'getExpenseById']);

Route::get('cashinByCategory',[CashInController::class,'cashinByCategory']);
Route::get('cashoutByCategory',[CashoutController::class,'cashoutByCategory']);


/*
|--------------------------------------------------------------------------
|                          Reports
|--------------------------------------------------------------------------
*/

Route::get('cashbook',[\App\Http\Controllers\ReportController::class,'cashbook']);
Route::get('dataCashbook',[\App\Http\Controllers\ReportController::class,'dataCashbook']);


/*
|--------------------------------------------------------------------------
|                          Documents, Nominee & Guarantor
|--------------------------------------------------------------------------
*/

Route::resource('guarantors', GuarantorController::class);
Route::resource('all-loan-documents', LoanDocumentsController::class);
Route::resource('all-nominees', NomineesController::class);


/*
|--------------------------------------------------------------------------
|                          Accounts
|--------------------------------------------------------------------------
*/
    Route::resource('accounts',\App\Http\Controllers\AccountController::class);
    Route::resource('transactions',\App\Http\Controllers\TransactionController::class);
    Route::get('allAccounts',[\App\Http\Controllers\AccountController::class,'allAccounts']);
    Route::get('dataTransactions',[\App\Http\Controllers\TransactionController::class,'dataTransactions']);
































    });
