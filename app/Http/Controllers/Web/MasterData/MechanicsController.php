<?php

namespace Vanguard\Http\Controllers\Web\MasterData;

use Illuminate\Support\Arr;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Requests\MasterData\MechanicsCreatedUpdatedRequest;
use Vanguard\MMechanics;
use DataTables;
use Hash;

class MechanicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:master-data.manage');
    }

    public function getMechanics()
    {
        $mechanics = MMechanics::get();

        return DataTables::of($mechanics)
        ->addIndexColumn()
        ->addColumn('action', function($mechanics) {
            $edit = '
                <a data-toggle="tooltip" title="Edit Data" href="'.route('mechanics.edit',['mechanic' => $mechanics->id]).'" class="btn btn-outline-info btn-sm"><i class="fas fa-edit"></i></a>
                <a data-toggle="tooltip" data-placement="top" data-method="DELETE" data-confirm-title="Confirm" data-confirm-text="Are you sure to delete this data?" data-confirm-delete="Delete" title="Delete" href="'.route('mechanics.destroy',['mechanic' => $mechanics->id]).'" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></a>
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
        return view('master-data.mechanics.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $edit = false;

        return view('master-data.mechanics.add-edit', compact('edit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MechanicsCreatedUpdatedRequest $request)
    {
        $inputs = $request->all();
        $inputs['password'] = Hash::make($inputs['password']);
        MMechanics::create($inputs);

        return redirect()->route('mechanics.index')
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
        $mechanic = MMechanics::findOrFail($id);

        return view('master-data.mechanics.add-edit', compact('edit', 'mechanic'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MechanicsCreatedUpdatedRequest $request, $id)
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

        $mechanic = MMechanics::find($id);
        $mechanic->update($inputs);

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
        $mechanic = MMechanics::findOrFail($id);
        $mechanic->delete();

        return redirect()->route('mechanics.index')
            ->withSuccess('Data deleted!');
    }
}
