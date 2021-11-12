<?php

namespace Vanguard\Http\Controllers\Api;

use Vanguard\Http\Requests\Api\REST\ListRequest;
use Vanguard\Http\Resources\CarsResource;
use Vanguard\Http\Resources\JobsResource;
use Vanguard\Http\Resources\MechanicsResource;
use Vanguard\Http\Resources\OrdersResource;
use Vanguard\Http\Resources\ServicesResource;
use Vanguard\MMechanics;
use Vanguard\MCars;
use Vanguard\MServices;
use Vanguard\TJobs;
use Vanguard\TOrders;
use Vanguard\TOrdersDetail;

class RESTController extends ApiController
{
     /**
     * Type List
     */
    public function getTypeList($type)
    {
        $arrays = [
            1   => "Mechanics",
            2   => "Car Owners",
            3   => "Services",
            4   => "Car Management",
            5   => "Job Management"
        ];

        foreach($arrays as $key => $array)
        {
            if($key == $type)
            {
                return $array;
            }
        }

        return abort(422);
    }

    /**
     * List All
     */
    public function listAll(ListRequest $request)
    {
        $inputs = $request->only(['list']);
        $list = $inputs['list'];

        $type = $this->getTypeList($list);

        if($list == 1)
        {
            $queries = MMechanics::get();

            return MechanicsResource::collection($queries);
        }
        elseif($list == 2)
        {
            $queries = MCars::get();

            return CarsResource::collection($queries);
        }
        elseif($list == 3)
        {
            $queries = MServices::get();

            return ServicesResource::collection($queries);
        }
        elseif($list == 4)
        {
            $queries = TOrders::with('car')->get();

            return OrdersResource::collection($queries);
        }
        elseif($list == 5)
        {
            $queries = TJobs::with(['mechanic', 'order'])->get();

            return JobsResource::collection($queries);
        }
    }
}
