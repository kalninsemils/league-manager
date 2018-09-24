<?php

namespace App\Http\Controllers;

use App\Repositories\League as LeagueRepository;
use App\Http\Controllers\Controller;

class LeagueController extends Controller
{

    public function __construct(LeagueRepository $league)
    {
        $this->league = $league;
    }
    public function generate()
    {
        $league = $this->league->generate();

        return $this->league->commit($league);
    }
}
