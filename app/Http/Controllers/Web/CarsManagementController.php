<?php

namespace Vanguard\Http\Controllers\Web;

use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Requests\Orders\CreateRequest;
use Vanguard\Http\Requests\Orders\UpdateRequest;
use Vanguard\MCars;
use Vanguard\MMechanics;
use Vanguard\MServices;
use Vanguard\TJobs;
use Vanguard\TOrders;
use Vanguard\TOrdersDetail;
use DataTables;

class CarsManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:cars.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:cars.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:cars.list.show', ['only' => ['index', 'show']]);
        $this->middleware('permission:cars.destroy', ['only' => 'destroy']);
    }

    public function getOrders()
    {
        if(auth()->user()->hasRole('Admin'))
        {
            $orders = TOrders::with('cars')->get();

            return DataTables::of($orders)
            ->addIndexColumn()
            ->addColumn('action', function($orders) {
                $edit = '
                    <a data-toggle="tooltip" title="Edit Data" href="'.route('orders.edit',['order' => $orders->id]).'" class="btn btn-outline-info btn-sm"><i class="fas fa-edit"></i></a>
                    <a data-toggle="tooltip" data-placement="top" data-method="DELETE" data-confirm-title="Confirm" data-confirm-text="Are you sure to delete this data?" data-confirm-delete="Delete" title="Delete" href="'.route('orders.destroy',['order' => $orders->id]).'" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></a>
                ';
                return $edit;
            })
            ->make(true);
        }
        elseif(auth()->user()->hasRole('User'))
        {
            $orders = TOrders::with('cars')
                    ->whereHas('cars', function($query) {
                        $query->where('user_id', auth()->user()->id);
                    })
                    ->get();

            return DataTables::of($orders)
            ->addIndexColumn()
            ->addColumn('action', function($orders) {
                $edit = '
                    <a data-toggle="tooltip" title="View Data" href="'.route('orders.show',['order' => $orders->id]).'" class="btn btn-outline-info btn-sm"><i class="fas fa-eye"></i></a>
                ';
                return $edit;
            })
            ->make(true);
        }
        else
        {
            return abort(403);
        }
    }

    public function addDetail($index)
    {
        $services = MServices::pluck('name', 'id');

        return view('ajax.details', compact('index', 'services'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('orders.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $edit = false;
        $cars = MCars::with('user:id,first_name,last_name,email')->get();
        $mechanics = MMechanics::with('user:id,first_name,last_name')
                    ->where('job_status', 0)
                    ->get();

        return view('orders.add-edit', compact('cars', 'edit', 'mechanics'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $inputs = $request->all();
        $mechanic = $inputs['mechanic_id'];
        
        $order = new TOrders;
        $order->car_id      = $inputs['car_id'];
        $order->notes       = $inputs['notes_order'];
        $order->start_at    = $inputs['start_at'];
        $order->save();

        // Create order details
        if(!empty($inputs['service_id']))
        {
            $services = $inputs['service_id'];
            foreach($services as $k => $service)
            {
                $detail = new TOrdersDetail;
                $detail->order_id   = $order->id;
                $detail->service_id = $inputs['service_id'][$k];
                $detail->qty        = $inputs['qty'][$k];
                $detail->notes      = $inputs['notes'][$k];
                $detail->save();
            }
        }

        // Create new job to mechanics
        if($mechanic)
        {
            $job = new TJobs;
            $job->mechanic_id   = $mechanic;
            $job->order_id      = $order->id;
            $job->save();

            // Update mechanic status
            $update_mechanic = MMechanics::find($mechanic);
            $update_mechanic->job_status = 1;
            $update_mechanic->save();
        }

        return redirect()->route('orders.index')
            ->withSuccess('Success submited data');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = TOrders::find($id);
        $order_detail = TOrdersDetail::whereOrderId($id)
                        ->with('service')
                        ->get();

        return view('orders.show', compact('order', 'order_detail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit = true;
        $cars = MCars::with('user:id,first_name,last_name,email')->get();
        $order = TOrders::findOrFail($id);
        $order_detail = TOrdersDetail::whereOrderId($id)
                        ->with('service')
                        ->get();

        return view('orders.add-edit', compact('cars', 'edit', 'order', 'order_detail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $inputs = $request->all();
        $order = TOrders::find($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = TOrders::findOrFail($id);
        $order->delete();

        TOrdersDetail::whereOrderId($id)->delete();

        return redirect()->route('orders.index')
            ->withSuccess('Data deleted!');
    }
}
