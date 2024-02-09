<?php

use Illuminate\Database\Seeder;
use App\Type;

class TypeSeeder extends Seeder
{
    public function run()
    {
        $data = json_decode(File::get('database/list/type.json'));
        foreach ($data as $obj) {
            $type = new Type;
            $type->name = $obj->name;
            $type->save();
        }
    }
}
