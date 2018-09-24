<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
   use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];


    public function divisions()
    {
        return $this->belongsToMany('App\Models\Division');
    }

    public function leagues()
    {
        return $this->belongsToMany('App\Models\Team');
    }
}
