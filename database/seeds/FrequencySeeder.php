<?php

use Illuminate\Database\Seeder;
use App\Models\Frequency;

class FrequencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Frequency::count() == 0) {
            $data = json_decode(File::get('database/list/frequencies.json'));
            foreach ($data as $obj) {
                Frequency::updateOrcreate([
                    'name'     		=> $obj->name,
                    'description'  	=> $obj->description
                ]);
            }

        }
    }
}
