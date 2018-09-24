<?php

namespace App\Repositories;

use DB;
use Illuminate\Support\Collection;
use App\Models\Division as Model;
use Faker\Factory as Faker;

class Division
{

    public function find(int $id) {
        /* In Non Tes Project Cache Would be Applied here */
        return Model::find($id);
    }

    public function generate(Collection $chunks, Collection $divisions) : Collection
    {
        DB::beginTransaction();
        try {
            $divisions = $this->commit($divisions);

            foreach ($divisions as $key => $division) {
                $divisions[$key] = $this->attachTeams($division, $chunks[$key]);
            }

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;

        }

        DB::commit();

        return $divisions;
    }

    public function make(int $count,int $league_id) : Collection
    {
        $faker = Faker::create();

        $divisions = collect([]);

        while ($divisions->count() < $count) {
            $division = new Model();
            $division->league_id = $league_id;
            $division->name = $faker->name . ' Division';
            $divisions[] = $division;
        }

        return $divisions;
    }

    public function attachTeams(Model $division, Collection $teams) : Model
    {
        $division->teams()->attach($teams->pluck('id')->all());
        /* Preloading Teams for response (the view is not using them, though) */
        $division->load('teams');

        return $division;
    }

    public function commit(Collection $divisions) : Collection
    {
        DB::beginTransaction();

        try {
            $divisions->each(function($division) {
                $division->save();
            });

        } catch (\Exception $e) {
            \DB::rollback();
            throw $e;

        }

        DB::commit();

        return $divisions;
    }
}
