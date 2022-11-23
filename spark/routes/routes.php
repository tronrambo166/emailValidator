<?php

use Illuminate\Support\Facades\Route;
use Spark\Http\Middleware\HandleInertiaRequests;

Route::group([
    'namespace' => 'Spark\Http\Controllers',
    'prefix' => 'spark',
], function () {
    // Stripe Webhook Controller...
    Route::post('webhook', 'WebhookController@handleWebhook');

    Route::group(['middleware' => config('spark.middleware', ['web', 'auth'])], function () {
        // Subscription...
        Route::post('/subscription', 'NewSubscriptionController');
        Route::put('/subscription', 'UpdateSubscriptionController');
        Route::put('/subscription/cancel', 'CancelSubscriptionController');
        Route::put('/subscription/resume', 'ResumeSubscriptionController');

        // Payment Method...
        Route::put('/subscription/payment-method', 'UpdatePaymentMethodController');

        // Invoice Controller...
        Route::post('/{invoiceId}/pay', 'PayInvoiceController');

        // Billing Information...
        Route::put('/billing-information', 'UpdateBillingInformationController');

        // Top Ups...
        Route::put('/top-up', 'TopUpBalanceController');

        // Receipt Emails...
        Route::put('/receipt-emails', 'UpdateReceiptEmailsController');

        // Apply a Coupon...
        Route::put('/coupon', 'ApplyCouponController');

        // Stripe Setup Intent Tokens...
        Route::get('/token', 'StripeTokenController');

        // Vat Rate Controller...
        Route::post('/tax-rate', 'TaxController');

        // Billing Information...
        Route::get('/{type}/{id}/receipts/{receiptId}/download', 'DownloadReceiptController')->name('receipts.download');
    });
});

Route::group([
    'middleware' => array_merge(config('spark.middleware', ['web', 'auth']), [HandleInertiaRequests::class]),
    'namespace' => 'Spark\Http\Controllers',
    'prefix' => config('spark.path'),
], function () {
    Route::get('/{type?}/{id?}', 'BillingPortalController')->name('spark.portal');
});
