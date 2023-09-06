<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class Select2SearchController extends Controller
{

    public function selectSearch(Request $request)
    {
    	$users = [];
        
        if($request->has('q')){
            $search = $request->q;
            $users =User::select("username", "id")
            		->where('username', 'LIKE', "%$search%")
            		->get();
        }
        return response()->json($users);
    }
}
