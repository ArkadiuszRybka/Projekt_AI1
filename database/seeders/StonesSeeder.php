<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class StonesSeeder extends Seeder
{
    public function run(): void
    {
        $path = storage_path('csv/stones.csv');
        $data = File::get($path);
        $rows = explode("\n", $data);
        foreach($rows as $row) {
            $values = str_getcsv($row, ';');
            if (isset($values[1])) {
                DB::table('stones')->insert([
                    'id' => $values[0],
                    'name' => $values[1],
                    'description' => $values[2],
                    'price' => $values[3],
                    'img' => $values[4],
                ]);
            }
        }
    }
}
