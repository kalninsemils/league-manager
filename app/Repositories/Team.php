<?php

namespace App\Repositories;

use DB;
use Illuminate\Support\Collection;
use App\Models\Team as Model;
use Faker\Factory as Faker;

class Team
{

    public function find(int $id) : Model
    {

        return Model::find($id);
    }
    public function generate(int $count) : Collection
    {
        $faker = Faker::create();

        $teams = collect([]);

        while ($teams->count() < $count) {
            $team = new Model();
            $team->name = $faker->name;
            $teams[] = $team;
        }



        return $teams;
    }

    public function commit(Collection $teams) : Collection
    {
        DB::beginTransaction();

        try {
            $teams->each(function($team) {
                $team->save();
            });

        } catch (\Exception $e) {
            \DB::rollback();
            throw $e;

        }

        DB::commit();

        return $teams;
    }

    public function getRandom(int $limit) : Collection
    {
        return Model::inRandomOrder()->limit($limit)->get();
    }
}
