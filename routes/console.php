<?php

use App\Imports\FinancesImport;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('import-record', function () {
   $this->output->title('Importing records...');
    (new FinancesImport())->import(public_path('template.csv'));
    $this->output->success('Imported records successfully.');
})->purpose('Import Records from a CSV file');
