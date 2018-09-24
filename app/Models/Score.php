<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Score extends Model
{
   use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'level', 'winner_id', 'loser_id', 'league_id', 'division_id'
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

    public function winner()
    {
        return $this->belongsTo('App\Models\Team', 'winner_id');
    }

    public function loser()
    {
        return $this->belongsTo('App\Models\Team', 'loser_id');
    }
}
