<?php

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
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\ExtensionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;


Route::middleware(['set.locale'])->group(function () {
  Route::get('/', function () {
      return redirect('login');
  });
  Route::get('/login', [AuthController::class, 'login']);
  Route::post('/login', [AuthController::class, 'authenticate'])->name('login');
  Route::get('/register', [AuthController::class, 'register']);
  Route::post('/register', [AuthController::class, 'createUser'])->name('register');
  Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
  Route::get('/email/verify', [AuthController::class, 'verifyEmail'])->middleware(['auth'])->name('verification.notice');
  Route::get('/email/verify/{id}/{hash}',  [AuthController::class, 'verifyUser'])->middleware(['auth', 'signed'])->name('verification.verify');
  Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');
  Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
  Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('password.reset');
  Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('password.update');
  Route::get('/locale/{locale}',[AuthController::class, 'setLocale'] );
  Route::get('/terms-and-conditions',[AuthController::class, 'termsConditions'] );
  Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationEmail'])->middleware(['auth','throttle:6,1'])->name('verification.send');

  Route::get('/form/{uuid}', [FormController::class, 'viewForm']);
  Route::post('/form/{uuid}', [FormController::class, 'formRecord']);

  Route::post('/extension/payment/webhook', [PaymentController::class, 'paymentWebhook']);

  Route::group(['middleware' => ['role:super-admin|member']], function () {
    //Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/user', [ProfileController::class, 'index']);
    Route::post('/user', [ProfileController::class, 'updateProfile']);
    Route::get('/account', [ProfileController::class, 'account']);
    Route::post('/account', [ProfileController::class, 'updateAccount']);
    Route::get('/new/email/verify/{id}', [ProfileController::class, 'verifyNewMail'])->name('verify.newmail')->middleware('signed');
    Route::get('/delete-account', [ProfileController::class, 'deleteAccount']);
    Route::get('/get-user-auth/{token}', [SuperAdminController::class, 'getUserAuth']);
    Route::get('/manual/email/verify/{token}', [SuperAdminController::class, 'manualEmailVerify']);

    Route::get('/accounts', [AccountController::class, 'index']);
    Route::get('/get-accounts', [AccountController::class, 'getAccounts'])->name('user.accounts');
    Route::post('/accounts/add', [AccountController::class, 'addAccount']);
    Route::get('/accounts/{uuid}', [AccountController::class, 'viewAccount'])->name('accounts.view');
    Route::post('/update-account/{id}', [AccountController::class, 'updateAccount']);
    Route::get('/delete-account/{id}', [AccountController::class, 'deleteAccount']);
    Route::post('/accounts/{uuid}/contact/add', [AccountController::class, 'createContact']);
    Route::get('/get-account-contacts/{id}', [AccountController::class, 'getAccountContacts'])->name('user.account.contacts');
    Route::post('/accounts/{uuid}/contact/delete', [AccountController::class, 'deleteContact']);
    Route::get('/accounts/{uuid}/contact/edit/{id}', [AccountController::class, 'editContact']);
    Route::post('/accounts/{uuid}/contact/edit/{id}', [AccountController::class, 'updateContact']);
    Route::post('/accounts/{uuid}/contact/duplicate', [AccountController::class, 'duplicateContact']);
    Route::post('/accounts/{uuid}/contact/move', [AccountController::class, 'moveContact']);

    Route::get('/deals', [DealController::class, 'index'])->name('deals.view');
    Route::post('deals/account/contacts', [DealController::class, 'getAccountContacts']);
    Route::post('/deals/add', [DealController::class, 'createDeal']);
    Route::post('/deals/update/status', [DealController::class, 'updateDealStatus']);
    Route::get('/deals/{id}/delete', [DealController::class, 'deleteDeal']);
    Route::get('/deals/{id}/duplicate', [DealController::class, 'duplicateDeal']);
    Route::get('/deals/{id}/edit', [DealController::class, 'editDeal']);
    Route::post('/deals/{id}/edit', [DealController::class, 'updateDeal']);
    Route::post('/deals/settings', [DealController::class, 'dealSettings']);
    Route::get('/deals/status', [DealController::class, 'dealsListing']);
    Route::get('/deals/won-lost', [DealController::class, 'getWonLostDeals'])->name('deals.listing');
    Route::post('/deals/{id}/comments/add', [DealController::class, 'createDealComment']);
    Route::get('/get-deal-comments/{id}', [DealController::class, 'getDealComments'])->name('deal.comments');
    Route::get('/deals/comment/{id}/delete', [DealController::class, 'deleteDealComment']);
    Route::get('/deals/{id}/comment/get', [DealController::class, 'getDealComment']);
    Route::post('/deals/{id}/comment/update', [DealController::class, 'updateDealComment']);

    Route::get('/forms', [FormController::class, 'index'])->name('forms.view');
    Route::get('/forms/add', [FormController::class, 'addForm']);
    Route::post('/forms/add', [FormController::class, 'saveForm']);
    Route::get('/get-forms', [FormController::class, 'getForms'])->name('user.forms');
    Route::get('/forms/{uuid}/edit', [FormController::class, 'editForm']);
    Route::post('/forms/{uuid}/edit', [FormController::class, 'updateForm']);
    Route::post('/forms/{id}/delete', [FormController::class, 'deleteForm']);
    Route::post('/forms/{id}/duplicate', [FormController::class, 'duplicateForm']);
    Route::get('/forms/{uuid}/responses', [FormController::class, 'viewFormResponses']);
    Route::post('/forms/{id}/submission/delete', [FormController::class, 'deleteFormSubmission']);
    Route::post('/forms/{id}/add-customized-fields', [FormController::class, 'saveCustomizedFields']);
    Route::get('/forms/{id}/delete-customized-fields', [FormController::class, 'deleteCustomizedFields']);
    Route::get('/forms/{id}/update-customized-fields', [FormController::class, 'editCustomizedFields']);
    Route::post('/forms/{id}/update-customized-fields', [FormController::class, 'updateCustomizedFields']);
    Route::post('/forms/update', [FormController::class, 'createUpdateForm']);

    Route::post('/notifications/mark-read', [NotificationController::class, 'markRead']);
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead']);
    Route::get('/notifications/read', [NotificationController::class, 'index']);
    Route::get('/notifications/see-read', [NotificationController::class, 'seeRead'])->name('notifications.seeRead');
    Route::post('/notifications/mark-unread', [NotificationController::class, 'markUnread']);

    Route::get('/extensions', [ExtensionController::class, 'index']);
    Route::get('/extensions/accounts/settings', [ExtensionController::class, 'accountSettings'])->name('extensions.accounts.settings');
    Route::get('/extensions/deals/settings', [ExtensionController::class, 'dealSettings'])->name('extensions.deals.settings');
    Route::post('/extensions/deals/categories/settings', [ExtensionController::class, 'addDealCategories']);
    Route::post('/extensions/deals/categories/settings/update', [ExtensionController::class, 'updateDealCategories']);
    Route::get('/extensions/deals/categories/settings/{id}/delete', [ExtensionController::class, 'deleteDealCategories']);
    Route::post('/extensions/deals/settings', [ExtensionController::class, 'addDealSettingsSources']);
    Route::post('/extensions/deals/settings/{id}/update', [ExtensionController::class, 'updateDealSettingsSources']);
    Route::get('/extensions/deals/settings/{id}/delete', [ExtensionController::class, 'deleteDealSettingsSources']);
    Route::post('/extensions/access', [ExtensionController::class, 'updateExtensionStatus']);
    Route::get('/extensions/forms/settings', [ExtensionController::class, 'formsSettings'])->name('extensions.forms.settings');
    Route::get('/extensions/categories/settings', [ExtensionController::class, 'categoriesSettings'])->name('extensions.categories.settings');
    Route::post('/extensions/categories/settings', [ExtensionController::class, 'addCategories']);
    Route::post('/extensions/categories/settings/update', [ExtensionController::class, 'updateCategories']);
    Route::get('/extensions/categories/settings/{id}/delete', [ExtensionController::class, 'deleteCategories']);
    Route::post('/extensions/get-checkout-price', [ExtensionController::class, 'getCheckoutPrice']);
    Route::post('/extensions/delete-payment-method', [ExtensionController::class, 'deletePaymentMethod']);

    Route::POST('/extension/payment/subscription', [PaymentController::class, 'payment']);
  });

  Route::group(['middleware' => ['role:super-admin']], function () {
    Route::get('/owners', [SuperAdminController::class, 'index']);
    Route::get('/get-owners', [SuperAdminController::class, 'getOwners'])->name('super_admin.users');
    Route::post('/delete-user', [SuperAdminController::class, 'deleteUser']);
    Route::get('/translations/authentication/login', [TranslationController::class, 'login']);
    Route::post('/translations/authentication/login', [TranslationController::class, 'saveLoginTranslations']);
    Route::get('/translations/authentication/forgot-password', [TranslationController::class, 'forgotPassword']);
    Route::post('/translations/authentication/forgot-password', [TranslationController::class, 'saveForgotPassword']);
    Route::get('/translations/authentication/register', [TranslationController::class, 'register']);
    Route::post('/translations/authentication/register', [TranslationController::class, 'saveRegister']);
    Route::get('/translations/email/verifyemail', [TranslationController::class, 'verifyEmail']);
    Route::post('/translations/email/verifyemail', [TranslationController::class, 'saveVerifyEmail']);
    Route::get('/translations/email/preview/verifyemail', [TranslationController::class, 'previewVerifyEmail']);
    Route::get('/translations/email/forgotpassword', [TranslationController::class, 'forgotPasswordEmail']);
    Route::post('/translations/email/forgotpassword', [TranslationController::class, 'saveForgotPasswordEmail']);
    Route::get('/translations/email/preview/forgotpassword', [TranslationController::class, 'previewForgotPasswordEmail']);
    Route::get('/translations/page/terms-conditions', [TranslationController::class, 'termsConditions']);
    Route::post('/translations/page/terms-conditions', [TranslationController::class, 'saveTermsConditions']);
    Route::get('/translations/page/menu-items', [TranslationController::class, 'menuItems']);
    Route::post('/translations/page/menu-items', [TranslationController::class, 'saveMenuItems']);
    Route::get('/translations/page/account', [TranslationController::class, 'account'])->name('account');
    Route::post('/translations/page/account', [TranslationController::class, 'saveAccount']);
    Route::get('/translations/page/user', [TranslationController::class, 'user']);
    Route::post('/translations/page/user', [TranslationController::class, 'saveUser']);
    Route::get('/translations/page/dashboard', [TranslationController::class, 'dashboard']);
    Route::post('/translations/page/dashboard', [TranslationController::class, 'saveDashboard']);
    Route::get('/translations/page/accounts', [TranslationController::class, 'accountsExt']);
    Route::post('/translations/page/accounts', [TranslationController::class, 'saveAccountsExt']);
    Route::get('/translations/page/deals', [TranslationController::class, 'dealsExt']);
    Route::post('/translations/page/deals', [TranslationController::class, 'saveDealsExt']);
  });
});
