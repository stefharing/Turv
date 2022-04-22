<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'name', 'user_id', 'total_members'];


    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

}
