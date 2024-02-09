<?php

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $data = json_decode(File::get('database/list/departments.json'));
        foreach ($data as $obj) {
            $department = new Department;
            $department->name = $obj->name;
            $department->slug = $obj->slug;
            $department->description = $obj->description;
            $department->save();
        }
    }
}
