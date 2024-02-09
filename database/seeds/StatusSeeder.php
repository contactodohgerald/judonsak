<?php

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Status::count() == 0) {
            $data = json_decode(File::get('database/list/status.json'));

            foreach ($data as $obj) {
                Status::updateOrcreate([
                    'name'     => $obj->name
                ]);
            }

        }
    }
}
