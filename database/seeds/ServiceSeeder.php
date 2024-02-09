<?php

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Service::count() == 0) {
            $data = json_decode(File::get('database/list/services.json'));

            foreach ($data as $obj) {
                Service::updateOrcreate([
                    'name'     => $obj->name
                ]);
            }

        }
    }
}
