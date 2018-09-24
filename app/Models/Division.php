<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Division extends Model
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


    public function league()
    {
        return $this->belongsTo('App\Models\League');
    }

    public function teams()
    {
        return $this->belongsToMany('App\Models\Team');
    }

    public function scores()
    {
        return $this->hasMany('App\Models\Score');
    }
}
