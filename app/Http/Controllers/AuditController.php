<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];

        if(Auth::user()->role->name == "admin"){
            $data = Audit::orderBy("expiration_date","asc")
            ->with(['user','find','find.audit','find.user'])
            ->get();
        } else {
            $data = Audit::where("user_id", Auth::user()->id)
            ->where("status",1)
            ->with(['user','find','find.audit','find.user'])
            ->orderBy("expiration_date","asc")
            ->get();
        }

        return view('audits.list')
            ->with('audits', $data)
            ->with('role', json_encode(Auth::user()->role->name))
            ->with('occupation', 'Astronaut');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'code' => 'required',
            'expiration_date' => 'required',
        ]);

        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        unset($input['_token']);
        $audit = Audit::create($input);

        if($audit){
            return back()->with('success', 'Auditoria creada satisfactoriamente.');
        } else {
            return back()->with('failed', 'Se presentó un inconveniente al realizar la creación de la Auditoría.');
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
        $audit = Audit::where('id',$request->input("idEdit"))->first();
        $audit->name = $request->input('editName');
        $audit->code = $request->input('editCode');
        $audit->expiration_date = $request->input('editDate');
        $audit->save();

        if($audit){
            return back()->with('success', 'Auditoria actualizada satisfactoriamente.');
        } else {
            return back()->with('failed', 'Se presentó un inconveniente al realizar la modificación de la Auditoría.');
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
        $audit = Audit::where('id',$id)->first();
        $audit->status = false;
        $audit->save();

        if($audit){
            return back()->with('success', 'Auditoria eliminada satisfactoriamente.');
        } else {
            return back()->with('failed', 'Se presentó un inconveniente al realizar la eliminación de la Auditoría.');
        }
    }
}
