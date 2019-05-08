<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('id','>' ,'0')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        if($user->delete()){
            return redirect(route('admin.users.index'))->with('success', 'User deleted successfully');
        }
    }

    public function promote(User $user){
        if($user->role_id < 4 && $user->role_id > 1){
            $promoted_id = $user->role_id - 1;
            if(
                $user->update([
                    'role_id' => $promoted_id
                ])
            ){
                return redirect(route('admin.users.index'))->with('success', 'User promoted successfully');
            }
        }
    }
    public function demote(User $user){
        if($user->role_id < 3 && $user->role_id > 1){
            $demoted_id = $user->role_id + 1;
            if(
                $user->update([
                    'role_id' => $demoted_id
                ])
            ){
                return redirect(route('admin.users.index'))->with('success', 'User demoted successfully');
            }
        }
    }
}
