<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GroupTableSeeder extends Seeder {

    public function run(){
        DB::table('groups')->insert([
            'name' => Str::random(6),
            'total_members' => 0,
            'points_value' => 1,
        ]);
    }
}
