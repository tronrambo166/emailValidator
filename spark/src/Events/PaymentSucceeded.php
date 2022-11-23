<?php

namespace Spark\Events;

use Laravel\Cashier\Invoice;

class PaymentSucceeded
{
    /**
     * The billable instance.
     *
     * @var \Spark\Billable
     */
    public $billable;

    /**
     * The invoice instance.
     *
     * @var \Laravel\Cashier\Invoice
     */
    public $invoice;

    /**
     * Create a new event instance.
     *
     * @param  \Spark\Billable  $billable
     * @param  \Laravel\Cashier\Invoice  $invoice
     * @return void
     */
    public function __construct($billable, Invoice $invoice)
    {
        $this->billable = $billable;
        $this->invoice = $invoice;
    }
}
