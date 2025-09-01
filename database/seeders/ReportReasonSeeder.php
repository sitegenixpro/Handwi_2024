<?php

// database/seeders/ReportReasonSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReportReason;

class ReportReasonSeeder extends Seeder
{
    public function run()
    {
        $reasons = [
            ['reason' => 'Sale of illegal or regulated goods'],
            ['reason' => 'Hate speech or symbols'],
            ['reason' => 'Scam or fraud'],
            ['reason' => 'Violence or dangerous organizations'],
            ['reason' => 'Bullying or harassment'],
        ];

        // Insert the reasons into the database
        ReportReason::insert($reasons);
    }
}

