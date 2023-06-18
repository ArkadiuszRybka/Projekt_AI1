<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = storage_path('csv/transactions.csv');
        $data = File::get($path);
        $rows = explode("\n", $data);
        $startDate = Carbon::parse('2022-01-01');
        $endDate = Carbon::now();
        foreach($rows as $row) {
            $values = str_getcsv($row, ';');
            if (isset($values[1])) {
                $randomDays = rand(0, $startDate->diffInDays($endDate));
                $randomDate = $startDate->addDays($randomDays);
                $randomTime = rand(0, 23);
                $randomMinute = rand(0, 59);
                $randomDate = $randomDate->setTime($randomTime, $randomMinute);

                DB::table('transactions')->insert([
                    'id' => $values[0],
                    'user_id' => $values[1],
                    'price' => $values[2],
                    'created_at' => $randomDate,
                ]);
            }
        }
    }
}
