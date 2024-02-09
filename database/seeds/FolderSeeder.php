<?php

use Illuminate\Database\Seeder;
use App\Models\Folder;

class FolderSeeder extends Seeder
{
    public function run()
    {
        $data = json_decode(File::get('database/list/folders.json'));
        foreach ($data as $obj) {
            $folder = new Folder;
            $folder->name = $obj->name;
            $folder->save();
        }
    }
}
