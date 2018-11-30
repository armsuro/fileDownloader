<?php

use Illuminate\Database\Seeder;

class FileStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('file_statuses')->insert([
            [
                'name' => 'Pending',
                'alias' => 'PENDING'
            ],
            [
                'name' => 'Downloading',
                'alias' => 'DOWNLOADING'
            ],
            [
                'name' => 'Completed',
                'alias' => 'COMPLETED'
            ],
            [
                'name' => 'Error',
                'alias' => 'ERROR'
            ]
        ]);
    }
}
