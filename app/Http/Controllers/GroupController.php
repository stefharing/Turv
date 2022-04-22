<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Item;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index(Request $request) {
        $groups = $request->user()->groups->all();
        $visibility = 'hidden';


        return view('group-dashboard', compact('groups', 'visibility'));
    }

    public function filter(Request $request) {

        $groups = $request->user()->groups->where('name', $request['name']);
        $visibility = 'visible';

        return view('group-dashboard', compact('groups', 'visibility'));
    }

    public function store(Request $request){

        $request->validate([
            'name'=>'required',
        ]);

        $group = Group::create($request->all());

        foreach ($request->addmore as $key => $value) {
            $value['group_id'] = $group->id;

            Item::create($value);

        }

        return redirect()->back();
    }

    public function update(Request $request, Group $group){
        $request->validate([
            'name'=>'required',
        ]);

        $group->update($request->all());

        return redirect()->back();
    }

    public function destroy(Group $group){

        $group->members()->delete();
        $group->items()->delete();

        $group->delete();

        return redirect()->back();
    }

    public function openGroup($id){
        $group = Group::find($id);
        $members = Group::find($id)->members;
        $items = $group->items()->get();
        $visibility = 'hidden';

        if (Auth::check()) {
            if (Auth::user()->id == $group->user_id){
                return view('member-dashboard', compact('members', 'group', 'items', 'visibility'));
            }
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }
}
