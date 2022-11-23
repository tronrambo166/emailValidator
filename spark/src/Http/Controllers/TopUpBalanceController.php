<?php

namespace Spark\Http\Controllers;

use Spark\Features;
use Spark\SparkManager;

class TopUpBalanceController
{
    use RetrievesBillableModels;

    /**
     * Create a pay link for the customer to top up its balance with the given amount.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke()
    {
        if (Features::allowsTopUps() && $price = Features::option('top-ups', 'price')) {
            $billable = $this->billable();

            $checkout = $billable->checkout($price, [
                'success_url' => route('spark.portal'),
                'cancel_url' => route('spark.portal'),
                'metadata' => [SparkManager::BALANCE_TOP_UP => true],
            ]);

            return response()->json([
                'url' => $checkout->url,
            ]);
        }
    }
}
