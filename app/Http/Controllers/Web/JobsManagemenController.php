<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Vanguard\TJobs;
use DataTables;

class JobsManagemenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:jobs.list.show', ['only' => ['index', 'show']]);
    }

    public function getJobs()
    {
        if(auth()->user()->hasRole('Admin'))
        {
            $queries = TJobs::with(['order', 'mechanic'])->get();

            $jobs = [];
            foreach($queries as $query)
            {
                $jobs[] = [
                    'id'            => $query->id,
                    'licence_plate' => $query->order->car->licence_plate,
                    'car_name'      => $query->order->car->name,
                    'car_owner'     => $query->order->car->user->first_name.' '.$query->order->car->user->last_name,
                    'handled_by'    => $query->mechanic->user->first_name.' '.$query->mechanic->user->last_name,
                    'status'        => $query->status
                ];
            }

            return DataTables::of($jobs)
            ->addIndexColumn()
            ->addColumn('status', function($jobs) {
                $array = [
                    "1" => '<span class="badge badge-pill badge-info"> <i class="fas fa-exclamation-triangle"></i> Processing</span>',
                    "2" => '<span class="badge badge-pill badge-success"> <i class="fas fa-check-square"></i> Completed</span>'
                ];
                $fa_active = @$array[$jobs['status']] ?: null;

                return $fa_active;
            })
            ->addColumn('action', function($jobs) {
                $edit = '
                    <a data-toggle="tooltip" title="View Data" href="'.route('jobs.show',['job' => $jobs['id']]).'" class="btn btn-outline-info btn-sm"><i class="fas fa-eye"></i></a>
                ';
                return $edit;
            })
            ->rawColumns(['status', 'action'])
            ->toJson();
        }
        elseif(auth()->user()->hasRole('Mechanics'))
        {
            $queries = TJobs::with(['order', 'mechanic.user'])
                        ->whereHas('mechanic.user', function($query) {
                            $query->where('user_id', auth()->user()->id);
                        })
                        ->get();

            $jobs = [];
            foreach($queries as $query)
            {
                $jobs[] = [
                    'id'            => $query->id,
                    'licence_plate' => $query->order->car->licence_plate,
                    'car_name'      => $query->order->car->name,
                    'car_owner'     => $query->order->car->user->first_name.' '.$query->order->car->user->last_name,
                    'handled_by'    => $query->mechanic->user->first_name.' '.$query->mechanic->user->last_name,
                    'status'        => $query->status
                ];
            }

            return DataTables::of($jobs)
            ->addIndexColumn()
            ->addColumn('status', function($jobs) {
                $array = [
                    "1" => '<span class="badge badge-pill badge-info"> <i class="fas fa-exclamation-triangle"></i> Processing</span>',
                    "2" => '<span class="badge badge-pill badge-success"> <i class="fas fa-check-square"></i> Completed</span>'
                ];
                $fa_active = @$array[$jobs['status']] ?: null;

                return $fa_active;
            })
            ->addColumn('action', function($jobs) {
                $edit = '
                    <a data-toggle="tooltip" title="View Data" href="'.route('jobs.show',['job' => $jobs['id']]).'" class="btn btn-outline-info btn-sm"><i class="fas fa-eye"></i></a>
                ';
                return $edit;
            })
            ->rawColumns(['status', 'action'])
            ->toJson();
        }
        else
        {
            return abort(403);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('jobs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
}
