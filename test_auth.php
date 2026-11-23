<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Auth;

$credentials = [
    'admin@sekolah.com' => 'admin123',
    'gurupiket@sekolah.com' => 'guru123',
    'satpam@sekolah.com' => 'satpam123',
    'siswa@sekolah.com' => 'siswa123',
];

foreach ($credentials as $email => $pass) {
    $attempt = Auth::attempt(['email' => $email, 'password' => $pass]);
    $user = Auth::user();
    echo $email . ' -> attempt: ' . ($attempt ? 'SUCCESS' : 'FAIL') . ', role: ' . ($user ? $user->role : 'none') . ', status: ' . ($user ? $user->status : 'none') . PHP_EOL;
    Auth::logout();
}
