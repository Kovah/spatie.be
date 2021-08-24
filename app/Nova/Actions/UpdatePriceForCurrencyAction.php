<?php

namespace App\Nova\Actions;

use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\PurchasablePrice;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class UpdatePriceForCurrencyAction extends Action
{
    use InteractsWithQueue;
    use Queueable;

    public $name = 'Update prices for currency';

    public function handle(ActionFields $fields, Collection $models)
    {
        if (! $fields->currency_code) {
            return Action::danger('Currency code is required');
        }

        if ($fields->currency_code === 'USD') {
            return Action::danger('You should define the USD price on the purchasable itself');
        }

        if (! $fields->amount_in_cents) {
            return Action::danger('Amount is required');
        }

        if (! PurchasablePrice::where('currency_code', $fields->currency_code)->exists()) {
            return Action::danger("No purchasable price found for currency code {$fields->currency_code}");
        }

        $models->each(function (Purchasable $purchasable) use ($fields) {
            $purchasable
                ->prices()
                ->where('currency_code', $fields->currency_code)
                ->update([
                    'amount' => $fields->amount_in_cents,
                    'overridden' => true,
                ]);
        });

        return Action::message('Price updated!');
    }

    public function fields()
    {
        return [
            Number::make('Amount in cents'),

            Select::make('Currency code')->options(PurchasablePrice::pluck('currency_code', 'currency_code')->unique()->sort()),
        ];
    }
}
