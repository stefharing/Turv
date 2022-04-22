<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MemberTableSeeder extends Seeder {

    public function run(){
        DB::table('members')->insert([
            'name' => Str::random(6),
            'group_id' => 1,
            'points_current' => 0,
            'points_total' => 10
        ]);
    }
}


//$table->string('name');
//$table->unsignedBigInteger('group_id');
//$table->integer('points_current');
//$table->integer('points_total');
