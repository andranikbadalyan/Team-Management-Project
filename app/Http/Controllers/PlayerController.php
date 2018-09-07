<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerRequest;
use App\Player;

class PlayerController extends Controller
{
    public function __construct(){
        $this->middleware('can:view,App\Player')->only('index', 'show');
        $this->middleware('can:create,App\Player')->only('store');
        $this->middleware('can:update,App\Player')->only('update');
        $this->middleware('can:delete,App\Player')->only('destroy');
    }

    public function index($teamId){
        return Player::where('team_id', $teamId)->get();
    }
    
    public function store(PlayerRequest $request, $teamId){
        $player = new Player;
        $player->first_name = $request->first_name;
        $player->last_name = $request->last_name;
        $player->team()->associate($teamId);
        $player->save();

        return response()->json(['message' => "Successfully added player."], 200);
    }
    public function update(PlayerRequest $request, $teamId, $playerId){
        $player = Player::where('team_id', $teamId)->findOrFail($playerId);
        $player->first_name = $request->first_name;
        $player->last_name = $request->last_name;
        $player->save();

        return response()->json(['message' => "Successfully updated player."], 200);
    }

    public function destroy($teamId, $playerId){
        $player=Player::where('team_id', $teamId)->findOrFail($playerId);
        $player->delete();

        return response()->json(['message' => "Successfully deleted player."], 200);
    }
}
