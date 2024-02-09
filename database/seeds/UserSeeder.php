<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\User;
use App\Models\Person;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//         if (User::count() == 0) {
            $data = json_decode(File::get('database/list/users.json'));

            foreach ($data as $obj) {
                $user = User::updateOrcreate([
                    'name'           => $obj->name,
                    'email'          => $obj->email,
                    'type_id'          => $obj->type_id,
                    'password'       => bcrypt($obj->password),
                    'remember_token' => str_random(60)
                ]);

                $person = new Person;
                $person->first_name = $obj->first_name;
                $person->last_name  = $obj->last_name;
                $person->slug = $obj->slug;
                $person->level_id = $obj->level_id;
                $person->department_id = $obj->department_id;
                $person->address = $obj->address;
                $person->phone_num = $obj->phone;
                $person->staff_id = $obj->staff_id;
                $user->person()->save($person);
            }
        // }
    }
}
