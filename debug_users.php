<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\DwUserModel;

$email = 'coder.saklin@gmail.com';
$mobile = '6124475399';

echo "Searching for Email: [$email]\n";
$userByEmail = DwUserModel::where('user_email', $email)->first();
if ($userByEmail) {
    echo "Found by email! ID: " . $userByEmail->id . "\n";
} else {
    echo "NOT found by email.\n";
}

echo "Searching for Mobile: [$mobile]\n";
$userByMobile = DwUserModel::where('user_mobile', $mobile)->first();
if ($userByMobile) {
    echo "Found by mobile! ID: " . $userByMobile->id . "\n";
} else {
    echo "NOT found by mobile.\n";
}

$all = DwUserModel::where('user_email', 'LIKE', '%coder.saklin%')->get();
foreach($all as $u) {
    echo "Partial Match: ID: {$u->id}, Email: [{$u->user_email}], Mobile: [{$u->user_mobile}]\n";
}
