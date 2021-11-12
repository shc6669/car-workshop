<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class JobsManagement extends Plugin
{
    public function sidebar()
    {
        return Item::create(__('Jobs Management'))
            ->route('jobs.index')
            ->icon('fas fa-tasks')
            ->active("jobs*")
            ->permissions('jobs.list.show');
    }
}
