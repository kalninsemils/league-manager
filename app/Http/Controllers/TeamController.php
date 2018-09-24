<?php

namespace App\Http\Controllers;

use App\Repositories\Team as TeamRepository;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{

    protected $team;

    public function __construct(TeamRepository $team)
    {
        $this->team = $team;
    }

    public function generate()
    {
        $teams = $this->team->generate(10);

        return $this->team->commit($teams);
    }
}
