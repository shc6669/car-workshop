<?php

namespace Vanguard\Http\Controllers\Web\MasterData;

use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Requests\MasterData\ServicesCreatedUpdatedRequest;
use Vanguard\MServices;
use DataTables;

class ServicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:master-data.manage');
    }

    public function getServices()
    {
        $queries = MServices::get();

        $services = [];
        foreach($queries as $query)
        {
            $services[] = [
                'id'    => $query->id,
                'name'  => $query->name,
                'price' => 'Rp '.$query->price
            ];
        }

        return DataTables::of($services)
        ->addIndexColumn()
        ->addColumn('action', function($services) {
            $edit = '
                <a data-toggle="tooltip" title="Edit Data" href="'.route('services.edit',['service' => $services['id']]).'" class="btn btn-outline-info btn-sm"><i class="fas fa-edit"></i></a>
                <a data-toggle="tooltip" data-placement="top" data-method="DELETE" data-confirm-title="Confirm" data-confirm-text="Are you sure to delete this data?" data-confirm-delete="Delete" title="Delete" href="'.route('services.destroy',['service' => $services['id']]).'" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></a>
            ';
            return $edit;
        })
        ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master-data.services.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $edit = false;

        return view('master-data.services.add-edit', compact('edit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServicesCreatedUpdatedRequest $request)
    {
        $inputs = $request->all();
        MServices::create($inputs);

        return redirect()->route('services.index')
            ->withSuccess('Success submited data');
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
        $service = MServices::findOrFail($id);

        return view('master-data.services.add-edit', compact('edit', 'service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServicesCreatedUpdatedRequest $request, $id)
    {
        $inputs = $request->all();
        $service = MServices::find($id);
        $service->update($inputs);

        return redirect()->back()
            ->withSuccess('Success updated data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = MServices::findOrFail($id);
        $service->delete();

        return redirect()->route('services.index')
            ->withSuccess('Data deleted!');
    }
}
