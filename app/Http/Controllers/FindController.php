<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Find;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FindController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $finds = [];
        $users = [];

        if(Auth::user()->role->name == 'admin'){
            $finds = Find::orderBy('end_date','asc')
            ->with(['user','audit'])
            ->get();
        } else {
            $finds = Find::where('user_id', Auth::user()->id)
            ->where('status', 1)
            ->with(['user','audit'])
            ->orderBy('end_date','asc')
            ->get();
        }

        if(Auth::user()->role->name == 'admin'){
            $audits = Audit::orderBy('name','asc')
            ->where('status', 1)
            ->get();
        } else {
            $audits = Audit::where('user_id', Auth::user()->id)
            ->where('status', 1)
            ->orderBy('name','asc')
            ->get();
        }


        if(Auth::user()->role->name == 'admin'){
            $users = User::orderBy('name','asc')
            ->where('status',1)
            ->get();
        }

        return view('finds.list')
        ->with('finds', $finds)
        ->with('audits', $audits)
        ->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'description' => 'required|max:255',
            'recommendation' => 'required|max:255',
            'responsible' => 'required|max:255',
            'responsible_comment' => 'required|max:255',
            'audit_id' => 'required',
            'end_date' => 'required',
        ]);

        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        unset($input['_token']);
        $find = Find::create($input);

        if($find){
            return back()->with('success', 'Hallazgo creado satisfactoriamente.');
        } else {
            return back()->with('failed', 'Se presentó un inconveniente al realizar la creación del Hallazgo.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        unset($request['_token']);
        $find = Find::where('id',$request->input("idEdit"))->first();
        $find->name = $request->input('editName');
        $find->code = $request->input('editCode');
        $find->expiration_date = $request->input('editDate');
        $find->save();

        if($find){
            return back()->with('success', 'Hallazgo actualizado satisfactoriamente.');
        } else {
            return back()->with('failed', 'Se presentó un inconveniente al realizar la modificación del Hallazgo.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $find = Find::where('id',$id)->first();
        $find->status = false;
        $find->save();

        if($find){
            return back()->with('success', 'Hallazgo eliminado satisfactoriamente.');
        } else {
            return back()->with('failed', 'Se presentó un inconveniente al realizar la eliminación del Hallazgo.');
        }
    }
}
