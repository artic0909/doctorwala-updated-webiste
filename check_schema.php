<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$res = Illuminate\Support\Facades\DB::select('SHOW CREATE TABLE dw_user_models');
echo $res[0]->{'Create Table'};
