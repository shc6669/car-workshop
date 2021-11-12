<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class CarsManagement extends Plugin
{
    public function sidebar()
    {
        return Item::create(__('Cars Management'))
            ->route('orders.index')
            ->icon('fas fa-car')
            ->active("orders*")
            ->permissions('cars.list.show');
    }
}
