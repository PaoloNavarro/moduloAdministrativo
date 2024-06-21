<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserApiController extends Controller
{
    public function index()
    {
        $users = User::all();

        return response()->json($users);
    }

    

    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json(null, 204);
        } else {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }
    }
}
