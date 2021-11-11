<?php

namespace Vanguard\Http\Controllers\Web\MasterData;

use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Requests\MasterData\MechanicsCreatedUpdatedRequest;
use Vanguard\MMechanics;
use Vanguard\User;
use DataTables;

class MechanicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:master-data.manage');
    }

    public function getMechanics()
    {
        $queries = MMechanics::with('user:id,first_name,last_name,email')->get();

        $mechanics = [];
        foreach($queries as $query)
        {
            $mechanics[] = [
                'id'    => $query->id,
                'name'  => $query->user->first_name.' '.$query->user->last_name,
                'email' => $query->user->email
            ];
        }

        return DataTables::of($mechanics)
        ->addIndexColumn()
        ->addColumn('action', function($mechanics) {
            $edit = '
                <a data-toggle="tooltip" title="Edit Data" href="'.route('mechanics.edit',['mechanic' => $mechanics['id']]).'" class="btn btn-outline-info btn-sm"><i class="fas fa-edit"></i></a>
                <a data-toggle="tooltip" data-placement="top" data-method="DELETE" data-confirm-title="Confirm" data-confirm-text="Are you sure to delete this data?" data-confirm-delete="Delete" title="Delete" href="'.route('mechanics.destroy',['mechanic' => $mechanics['id']]).'" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></a>
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
        $users = User::select('id', 'first_name', 'last_name')
                ->where('role_id', 3)
                ->get();

        return view('master-data.mechanics.add-edit', compact('edit', 'users'));
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
        $users = User::select('id', 'first_name', 'last_name')
                ->where('role_id', 3)
                ->get();

        return view('master-data.mechanics.add-edit', compact('edit', 'mechanic', 'users'));
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
