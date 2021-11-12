<?php

namespace Vanguard\Http\Controllers\Web\MasterData;

use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Requests\MasterData\CarsCreatedUpdatedRequest;
use Vanguard\MCars;
use Vanguard\User;
use DataTables;

class CarsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:master-data.manage');
    }

    public function getCars()
    {
        $queries = MCars::with('user:id,first_name,last_name,email')->get();

        $cars = [];
        foreach($queries as $query)
        {
            $cars[] = [
                'id'            => $query->id,
                'name'          => $query->user->first_name.' '.$query->user->last_name,
                'type'          => $query->name,
                'licence_plate' => $query->licence_plate
            ];
        }

        return DataTables::of($cars)
        ->addIndexColumn()
        ->addColumn('action', function($cars) {
            $edit = '
                <a data-toggle="tooltip" title="Edit Data" href="'.route('cars.edit',['car' => $cars['id']]).'" class="btn btn-outline-info btn-sm"><i class="fas fa-edit"></i></a>
                <a data-toggle="tooltip" data-placement="top" data-method="DELETE" data-confirm-title="Confirm" data-confirm-text="Are you sure to delete this data?" data-confirm-delete="Delete" title="Delete" href="'.route('cars.destroy',['car' => $cars['id']]).'" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></a>
            ';
            return $edit;
        })
        ->rawColumns(['action'])
        ->toJson();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master-data.cars.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $edit = false;
        $users = User::select('id', 'first_name', 'last_name')
                ->where('role_id', 2)
                ->get();

        return view('master-data.cars.add-edit', compact('edit', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CarsCreatedUpdatedRequest $request)
    {
        $inputs = $request->all();
        MCars::create($inputs);

        return redirect()->route('cars.index')
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
        $car = MCars::findOrFail($id);
        $users = User::select('id', 'first_name', 'last_name')
                ->where('role_id', 2)
                ->get();

        return view('master-data.cars.add-edit', compact('car', 'edit', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CarsCreatedUpdatedRequest $request, $id)
    {
        $inputs = $request->all();
        $car = MCars::find($id);
        $car->update($inputs);

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
        $car = MCars::findOrFail($id);
        $car->delete();

        return redirect()->route('cars.index')
            ->withSuccess('Data deleted!');
    }
}
