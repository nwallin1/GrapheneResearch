<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\GroupLink;
use App\User;
use App\Group;

class LinkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return GroupLink::whereHas('group', function($q){
            $q->where('site_id','=',config('app.site')->id)->whereIn('id',Auth::user()->admin_groups);
        })->get();
    }

    public function create(Request $request)
    {
        $link = new GroupLink($request->all());
        $link->save();
        return $link;
    }

    public function update(Request $request, GroupLink $link)
    {
        $data = $request->all();
        $link->update($data);
        return $link;
    }

    public function destroy(GroupLink $link)
    {
        if ($link->delete()) {
            return 1;
        }
    }
}