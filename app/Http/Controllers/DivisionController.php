<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Division as DivisionRepository;
use App\Http\Controllers\Controller;

class DivisionController extends Controller
{
    public function __construct(DivisionRepository $division)
    {
        $this->division = $division;
    }

    public function generate(Request $request)
    {
        $data = $request->validate([
            'league_id' => 'required|exists:leagues,id',
        ]);
        $request->input('league_id');
        $divisions = $this->division->make(2, $data['league_id']);

        /* Getting Random Teams from all the generated Teams */
        $teams = app('Team')->getRandom(10);
        /* Splitting the teams in 2 parts, since we have 2 divisions */
        $chunks = $teams->chunk(5);

        $this->division->generate($chunks, $divisions);

        return $divisions;
    }
}
