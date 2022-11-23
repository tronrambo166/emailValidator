<?php

namespace Spark;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Invoice;

class FrontendState
{
    /**
     * Get the data should be shared with the frontend.
     *
     * @param  string  $type
     * @param  \Illuminate\Database\Eloquent\Model  $billable
     * @return array
     */
    public function current($type, Model $billable)
    {
        /** @var \Laravel\Cashier\Subscription */
        $subscription = $billable->subscription('default');

        $plans = static::getPlans($type, $billable);

        $plan = $subscription && $subscription->active()
                    ? $plans->firstWhere('id', $subscription->stripe_price)
                    : null;

        $homeCountry = is_string(config('spark.collects_eu_vat'))
                        ? config('spark.collects_eu_vat')
                        : Features::option('eu-vat-collection', 'home-country');

        $upcomingInvoice = $subscription ? $subscription->upcomingInvoice() : null;

        return [
            'allowsTopUps' => Features::allowsTopUps() && Features::option('top-ups', 'price'),
            'appLogo' => $this->logo(),
            'appName' => config('app.name', 'Laravel'),
            'balance' => ltrim($billable->balance(), '-'),
            'billable' => $billable->toArray(),
            'billableId' => (string) $billable->id,
            'billableName' => $billable->name,
            'billableType' => $type,
            'billingAddressRequired' => Features::collectsBillingAddress() && (bool) Features::option('billing-address-collection', 'required'),
            'brandColor' => $this->brandColor(),
            'pmType' => $billable->pm_type,
            'pmExpirationDate' => $billable->pm_expiration,
            'pmLastFour' => $billable->pm_last_four,
            'cashierPath' => config('cashier.path'),
            'collectsVat' => Features::collectsEuVat(),
            'collectsBillingAddress' => Features::collectsBillingAddress(),
            'countries' => Features::collectsEuVat() || Features::collectsBillingAddress() ? Countries::all() : [],
            'dashboardUrl' => $this->dashboardUrl(),
            'defaultInterval' => config('spark.billables.'.$type.'.default_interval', 'monthly'),
            'enforcesAcceptingTerms' => Features::enforcesAcceptingTerms(),
            'genericTrialEndsAt' => $billable->onGenericTrial() ? $billable->genericTrialEndsAt()->format(config('spark.date_format', 'F j, Y')) : null,
            'homeCountry' => $homeCountry,
            'message' => request('message', ''),
            'monthlyPlans' => $plans->where('interval', 'monthly')->where('active', true)->values(),
            'nextPayment' => $upcomingInvoice ? ['amount' => $upcomingInvoice->amountDue(), 'date' => $upcomingInvoice->date()->format(config('spark.date_format', 'F j, Y'))] : null,
            'paymentMethod' => $billable->pm_last_four ? 'card' : null,
            'plan' => $plan,
            'raw_balance' => $billable->rawBalance(),
            'receipts' => fn () => $this->invoices($billable),
            'seatName' => Spark::seatName($type),
            'sendsReceiptsToCustomAddresses' => Features::optionEnabled('receipt-emails-sending', 'custom-addresses'),
            'sparkPath' => config('spark.path'),
            'state' => $this->state($billable, $subscription),
            'stripeKey' => config('cashier.key'),
            'stripeVersion' => Cashier::STRIPE_VERSION,
            'termsUrl' => $this->termsUrl(),
            'trialEndsAt' => $subscription && $subscription->onTrial() ? $subscription->trial_ends_at->format(config('spark.date_format', 'F j, Y')) : null,
            'userAvatar' => Auth::user()->profile_photo_url,
            'userName' => Auth::user()->name,
            'yearlyPlans' => $plans->where('interval', 'yearly')->where('active', true)->values(),
        ];
    }

    /**
     * Get the logo that is configured for the billing portal.
     *
     * @return string|null
     */
    protected function logo()
    {
        $logo = config('spark.brand.logo');

        if (! empty($logo) && file_exists(realpath($logo))) {
            return file_get_contents(realpath($logo));
        }

        return $logo;
    }

    /**
     * Get the brand color for the application.
     *
     * @return string
     */
    protected function brandColor()
    {
        $color = config('spark.brand.color', 'bg-gray-800');

        return strpos($color, '#') === 0 ? 'bg-custom-hex' : $color;
    }

    /**
     * Get the subscription plans.
     *
     * @param  string  $type
     * @param  \Illuminate\Database\Eloquent\Model  $billable
     * @return \Illuminate\Support\Collection
     */
    protected function getPlans($type, $billable)
    {
        $plans = Spark::plans($type);

        return $plans->map(function ($plan) {
            $stripePrice = Cashier::stripe()->prices->retrieve($plan->id);

            if (! $stripePrice) {
                throw new \RuntimeException('Price ['.$plan->id.'] does not exist in your Stripe account.');
            }

            $plan->rawPrice = $stripePrice->unit_amount;

            $price = Cashier::formatAmount($stripePrice->unit_amount, $stripePrice->currency);

            if (Str::endsWith($price, '.00')) {
                $price = substr($price, 0, -3);
            }

            if (Str::endsWith($price, '.0')) {
                $price = substr($price, 0, -2);
            }

            $plan->price = $price;

            $plan->currency = $stripePrice->currency;

            return $plan;
        });
    }

    /**
     * Get the current subscription state.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $billable
     * @param  \Laravel\Cashier\Subscription  $subscription
     * @return string
     */
    protected function state(Model $billable, $subscription)
    {
        if ($subscription && $subscription->onGracePeriod()) {
            return 'onGracePeriod';
        }

        if ($subscription && $subscription->active()) {
            return 'active';
        }

        return 'none';
    }

    /**
     * List all invoices of the given billable.
     *
     * @param  \Spark\Billable  $billable
     * @return array
     */
    protected function invoices($billable)
    {
        return $billable->invoicesIncludingPending(['limit' => 100])
            ->filter(fn (Invoice $invoice) => $invoice->isOpen() || $invoice->isPaid())
            ->map(function (Invoice $invoice) use ($billable) {
                return [
                    'amount' => $invoice->realTotal(),
                    'date' => $invoice->date()->format(config('spark.date_format', 'F j, Y')),
                    'id' => $invoice->id,
                    'receipt_url' => route('receipts.download', [
                        $billable->sparkConfiguration()['type'],
                        $billable->id,
                        $invoice->id,
                    ]),
                    'status' => $invoice->status,
                ];
            })
            ->values()
            ->toArray();
    }

    /**
     * List all receipts of the given billable.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $billable
     * @return array
     *
     * @deprecated Will be removed in a future Spark release.
     */
    protected function receipts(Model $billable)
    {
        return $billable->localReceipts
            ->map(function ($receipt) use ($billable) {
                $receipt->receipt_url = route('receipts.download', [
                    $billable->sparkConfiguration()['type'],
                    $billable->id,
                    $receipt->provider_id,
                ]);

                return $receipt;
            })
            ->values()
            ->toArray();
    }

    /**
     * Get the URL of the billing dashboard.
     *
     * @return string
     */
    protected function dashboardUrl()
    {
        if ($dashboardUrl = config('spark.dashboard_url')) {
            return $dashboardUrl;
        }

        return app('router')->has('dashboard') ? route('dashboard') : '/';
    }

    /**
     * Get the URL of the "terms of service" page.
     *
     * @return string
     */
    protected function termsUrl()
    {
        if ($termsUrl = config('spark.terms_url')) {
            return $termsUrl;
        }

        return app('router')->has('terms.show') ? route('terms.show') : null;
    }
}
