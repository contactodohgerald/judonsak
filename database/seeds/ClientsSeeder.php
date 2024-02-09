<?php

use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    public function run()
    {
        if (Client::count() == 0) {
            $data = json_decode(File::get('database/list/clients.json'));
            foreach ($data as $obj) {
                Client::updateOrcreate([
                    'name'     => $obj->name,
                    'state_id'  => $obj->state_id,
                    'address'  => $obj->address,
                    'phone_num'  => $obj->phone_num,
                    'email'  => $obj->email,
                    'tin'  => $obj->tin,
                    'industry'  => $obj->industry,
                    'nature_of_business'  => $obj->nature_of_business
                ]);
            }

        }
    }
}