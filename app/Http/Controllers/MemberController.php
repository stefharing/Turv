<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Item;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MemberController extends Controller
{

    public function index() {
        $members = Member::all();

        $visibility = 'hidden';

        return view('member-dashboard', compact('members', 'visibility'));
    }

    public function filter(Request $request, $group) {

        $group = Group::find($group);
        $members = $group->members->where('name', $request['name']);
        $items = $group->items()->get();

        $visibility = 'visible';

        return view('member-dashboard', compact('members', 'group', 'items', 'visibility'));
    }

    public function store(Request $request){

        $request->validate([
            'name'=>'required',
            'group_id'=>'required',
            'standard_item' => 'required'
        ]);

        $member = [
            'name' => $request->input('name'),
            'group_id' => $request->input('group_id'),
            'standard_item' => $request->input('standard_item'),
            'points_current' => 0,
            'points_total' => 0,
            ];

        Member::create($member);

        return redirect()->back();
    }

    public function update(Request $request, Member $member){
        $request->validate([
            'name'=>'required'
        ]);

        $member->update($request->all());

        return redirect()->back();
    }

    public function destroy(Member $member){
        $member->delete();

        return redirect()->back();
    }

    public function incrementPoints(Request $request){

        $request->validate([
            'member'=>'required',
            'value'=>'required',
            'group' => 'required'
        ]);

        $member = Member::find($request['member']);
        $value = (float) $request['value'];
        $group = Group::find($request['group']);

        $member->increment('points_current', $value);
        $member->increment('points_total', $value);

        return redirect('/group/' . $group->id );
    }

    public function decrementPoints(Request $request){
        $member = Member::find($request['member']);
        $value = (float) $request['value'];
        $group = Group::find($request['group']);

        $member->decrement('points_current', $value);
        $member->decrement('points_total', $value);

        return redirect('/group/' . $group->id );
    }

    public function pay(Request $request, $id){

        $request->validate([
            'amount'=> 'required',
            'group' => 'required'
        ]);

        $member = Member::find($id);
        $amount = $request['amount'];
        $group = Group::find($request['group']);

        $member->points_current -= $amount;
        $member->save();

        return redirect('/group/' . $group->id );
    }

    public function round(Request $request, $id){
        $member = Member::find($id);
        $amount = (float) $request['amount'];
        $group = Group::find($request['group']);
        $item = Item::find($request['item']);

        $member->points_current += (float) ($amount * $item->price);
        $member->save();

        return redirect('/group/' . $group->id );
    }

}


