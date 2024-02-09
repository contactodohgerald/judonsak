<?php

use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrencySeeder extends Seeder
{
    public function run()
    {
        if (Currency::count() == 0) {
            $data = json_decode(File::get('database/list/currencies.json'));
            foreach ($data as $obj) {
                Currency::updateOrcreate([
                    'name'     => $obj->name,
                    'description'  => $obj->description
                ]);
            }

        }
    }
}
