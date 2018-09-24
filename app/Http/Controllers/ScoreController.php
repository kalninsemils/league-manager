<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Score as ScoreRepository;
use App\Http\Controllers\Controller;

class ScoreController extends Controller
{
    public function __construct(ScoreRepository $score)
    {
        $this->score = $score;
    }
    public function division(Request $request)
    {
        /* TODO Should be done via FormRequest, for simple usage this will suffice */
        $data = $request->validate([
            'division_id' => 'required|exists:divisions,id',
        ]);

        $division = app('Division')->find($data['division_id']);

        if (!$division->scores->count()) {
            $this->score->generateDivision($division);
            $division->load('scores');
        }

        /* Preloading winner and loser Team Models */
        return $division->scores->load('winner')->load('loser');
    }

    public function finals(Request $request)
    {
        $data = $request->validate([
            'league_id' => 'required|exists:leagues,id',
        ]);

        $league = app('League')->find($data['league_id']);
        $divisions = $league->divisions;

        $winners = [];
        foreach ($divisions as $key => $division) {
            $winners[$key] = $this->score->extractDivisionWinners($division);
        }
        /*
         * Requirements explicitly stated to have 4 winners per division
         * therefore we can hardcode the semi-final/final algorithm
         */

         /* First Round */
        $first_half  = array_chunk($winners[0], 2)[0];
        $second_half = array_chunk($winners[1], 2)[1];
        $scores = [];
        $scores[2][] = $this->score->generateFinals(
            $first_half,
            $second_half,
            $league->id,
            2
        );

        /* Second Round */
        $first_half  = array_chunk($winners[0], 2)[1];
        $second_half = array_chunk($winners[1], 2)[0];
        $scores[2][] = $this->score->generateFinals(
            $first_half,
            $second_half,
            $league->id,
            2
        );

        /* Semi Final */
        $scores[3] = [];
        foreach ($scores[2] as $score) {

            $winners = array_pluck($score, 'winner_id');
            $scores[3][] = $this->score->generateFinals(
                [$winners[0]],
                [$winners[1]],
                $league->id,
                3
            );

        }

        /* Final */
        $scores[4][] = $this->score->generateFinals(
            array_pluck($scores[3][0], 'winner_id'),
            array_pluck($scores[3][1], 'winner_id'),
            $league->id,
            4
        );

        return $this->score->setScoreTeams($scores);
    }
}
