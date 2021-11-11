<?php

namespace Vanguard\Http\Controllers\Web\MasterData;

use Illuminate\Support\Arr;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Requests\MasterData\CarsCreatedRequest;
use Vanguard\Http\Requests\MasterData\CarsUpdatedRequest;
use Vanguard\MCars;
use DataTables;
use Hash;

class CarsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:master-data.manage');
    }

    public function getCars()
    {
        $cars = MCars::get();

        return DataTables::of($cars)
        ->addIndexColumn()
        ->addColumn('action', function($cars) {
            $edit = '
                <a data-toggle="tooltip" title="Edit Data" href="'.route('cars.edit',['car' => $cars->id]).'" class="btn btn-outline-info btn-sm"><i class="fas fa-edit"></i></a>
                <a data-toggle="tooltip" data-placement="top" data-method="DELETE" data-confirm-title="Confirm" data-confirm-text="Are you sure to delete this data?" data-confirm-delete="Delete" title="Delete" href="'.route('cars.destroy',['car' => $cars->id]).'" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></a>
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

        return view('master-data.cars.add-edit', compact('edit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CarsCreatedRequest $request)
    {
        $inputs = $request->all();
        $inputs['password'] = Hash::make($inputs['password']);
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

        return view('master-data.cars.add-edit', compact('car', 'edit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CarsUpdatedRequest $request, $id)
    {
        $inputs = $request->all();
        if(!empty($inputs['password']))
        {
            $inputs['password'] = Hash::make($inputs['password']);
        }
        else
        {
            $inputs = Arr::except($inputs, ['password']);
        }

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
