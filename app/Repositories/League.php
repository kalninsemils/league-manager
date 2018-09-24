<?php

namespace App\Repositories;

use DB;
use App\Models\League as Model;
use Faker\Factory as Faker;

class League
{
    public function find(int $id) : Model
    {
        return Model::find($id);
    }
    public function generate() : Model
    {
        $faker = Faker::create();

        $league = new Model();
        $league->name = $faker->name . ' League';

        return $league;
    }

    public function commit(Model $league) : Model
    {
        DB::beginTransaction();

        try {
            $league->save();

        } catch (\Exception $e) {
            \DB::rollback();
            throw $e;

        }

        DB::commit();

        return $league;
    }
}
