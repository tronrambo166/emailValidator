<?php

namespace Spark\Listeners;

use Laravel\Cashier\Cashier;
use Laravel\Cashier\Events\WebhookReceived;
use Spark\SparkManager;

class TopUpBalanceListener
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(WebhookReceived $event)
    {
        if ($event->payload['type'] !== 'checkout.session.completed') {
            return;
        }

        // Make sure we only listen to top up events...
        if (($event->payload['data']['object']['metadata'][SparkManager::BALANCE_TOP_UP] ?? null) !== 'true') {
            return;
        }

        if ($user = Cashier::findBillable($event->payload['data']['object']['customer'])) {
            $user->applyBalance(-($event->payload['data']['object']['amount_total']), 'Spark Balance Top Up', [
                'metadata' => [SparkManager::BALANCE_TOP_UP => true],
            ]);
        }
    }
}
