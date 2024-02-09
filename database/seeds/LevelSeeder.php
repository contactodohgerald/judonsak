<?php

use Illuminate\Database\Seeder;
use App\Level;

class LevelSeeder extends Seeder
{
    public function run()
    {
        $data = json_decode(File::get('database/list/level.json'));
        foreach ($data as $obj) {
            $level = new Level;
            $level->name = $obj->name;
            $level->save();
        }
    }
}
