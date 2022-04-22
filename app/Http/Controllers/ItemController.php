<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function addMore()
    {
//        return view("addMore");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addMoreItems(Request $request)
    {
        $request->validate([
            'addmore.*.name' => 'required',
            'addmore.*.price' => 'required',
            ''
        ]);

        foreach ($request->addmore as $key => $value) {
            $value['group_id'] = $request['group_id'];

            Item::create($value);
        }

//        return back()->with('success', 'Record Created Successfully.');

    }

}
