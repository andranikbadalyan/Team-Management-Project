<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Team;

class TeamController extends Controller
{
    public function __construct(){
        $this->middleware('can:view,App\Team')->only('index', 'show');
        $this->middleware('can:create,App\Team')->only('store');
        $this->middleware('can:update,App\Team')->only('update');
        $this->middleware('can:delete,App\Team')->only('destroy');
    }

    public function index(){
        return Team::all();
    }

    public function store(TeamRequest $request){
        $team=new Team;
        $team->name = $request->name;
        $team->save();

        return response()->json(['message' => "Successfully added team."], 200);
    }
    
    public function show($teamId){
        return Team::with(['players'])->findOrFail($teamId);
    }
    
    public function update(TeamRequest $request, $teamId){
        $team=Team::findOrFail($teamId);
        $team->name = $request->name;
        $team->save();

        return response()->json(['message' => "Successfully updated team."], 200);
    }

    public function destroy($teamId){
        $team=Team::findOrFail($teamId);
        $team->delete();
        
        return response()->json(['message' => "Successfully deleted team."], 200);
    }
}
