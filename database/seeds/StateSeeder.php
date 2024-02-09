<?php

use Illuminate\Database\Seeder;
use App\Models\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (State::count() == 0) {
            $data = json_decode(File::get('database/list/states.json'));

            foreach ($data as $obj) {
                State::updateOrcreate([
                    'name'     => $obj->state,
                    'capital'  => $obj->capital
                ]);
            }

        }
    }
}
