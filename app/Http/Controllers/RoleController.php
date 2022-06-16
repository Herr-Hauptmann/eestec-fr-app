<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Type\Integer;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    public function index() {
        if (! Gate::allows('manage-users')) {
            abort(403);
        }
        $unverified = User::all()->where('role_id', 4);
        $users = User::all()->where('role_id', '<', 4 )->sortBy('role_id');
        return view('users', compact('unverified', 'users'));
    }

    public function update(Request $request, $id) {
        if (! Gate::allows('manage-users')) {
            abort(403);
        }
        $user = User::findOrfail($id);
        $user->role_id = $request->rolename;
        $user->save();
        return back();
    }

    public function verify(int $id) {
        if (! Gate::allows('manage-users')) {
            abort(403);
        }
        $user = User::find($id);
        $user->role_id = 3;
        $user->save();
        return back();
    }

    public function destroy(int $id) {
        if (! Gate::allows('manage-users')) {
            abort(403);
        }
        User::destroy($id);
        return back();
    }


    public function dashboard() {
        $statuses = Status::all()->where('user_id', Auth::user()->id)->filter( function($value, $key) {
            return $value->event->is_active == 1;
        });
        return view('dashboard', compact('statuses'));
    }
}
