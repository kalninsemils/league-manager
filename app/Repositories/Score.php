<?php

namespace App\Repositories;

use App\Models\Score as Model;
use Faker\Factory as Faker;

class Score
{

    public function find($id) {

        return Model::find($id);
    }

    public function extractDivisionWinners($division) : array
    {
        if (!$division->scores->count()) {
            throw new Exception('Division scores not set');
        }
        /* Extracting top 4 Teams, for simplicity ignoring draw on victory count */
        $scores = $division->scores->groupBy('winner_id')->sortByDesc(function ($scores) {
            return count($scores);
        });

        $teams = [];

        $keys = $scores->keys();
        while(count($teams) < 4) {
            $teams[] = $keys->shift();
        }


        return $teams;
    }

    public function generateDivision($division) : array
    {
        $teams_1 = $teams_2 = $division->teams;
        $scores = [];
        foreach ($teams_1 as $key => $team_1) {
            foreach ($teams_2 as $team_2) {
                /* Team cannot play with itself */
                if ($team_1 == $team_2) {
                    continue;
                }
                /* Simple algorithm to randomize victories */
                $rand = rand(0, 1);
                $scores[] = [
                    'winner_id' => $rand ? $team_1->id : $team_2->id,
                    'loser_id'  => $rand ? $team_2->id : $team_1->id,
                    'level'  => 1,
                    'league_id' => $division->league_id,
                    'division_id' => $division->id
                ];


            }
            unset($teams_1[$key]);
        }

        /* Bulk insert scores */
        Model::insert($scores);

        return $scores;
    }

    public function generateFinals($division_a, $division_b, $league_id, $level) : array
    {
        while(count($division_a)) {
            $team_1 = array_shift($division_a);
            $team_2 = array_pop($division_b);
            $rand = rand(0, 1);
            $scores[] = [
                'winner_id' => $rand ? $team_1 : $team_2,
                'loser_id'  => $rand ? $team_2 : $team_1,
                'level'  => $level,
                'league_id' => $league_id,
            ];
        }

        Model::insert($scores);

        return $scores;
    }

    public function setScoreTeams($scores) : array
    {
        foreach ($scores as &$level) {
            foreach ($level as &$score_groups) {
                foreach ($score_groups as  &$score) {
                    /* attaching team information to scores */
                    $score['winner'] = app('Team')->find($score['winner_id']);
                    $score['loser']  = app('Team')->find($score['loser_id']);
                }
            }
        }

        return $scores;
    }
}
