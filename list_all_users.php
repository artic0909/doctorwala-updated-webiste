<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use App\Models\DwUserModel;
$users = DwUserModel::all();
echo "Total users: " . $users->count() . "\n";
foreach($users as $u) {
    echo "ID: {$u->id}, Email: [" . bin2hex($u->user_email) . "] [" . $u->user_email . "], Mobile: [" . bin2hex($u->user_mobile) . "] [" . $u->user_mobile . "]\n";
}
