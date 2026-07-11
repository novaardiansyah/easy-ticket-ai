<?php

use Illuminate\Support\Facades\Route;

Route::post('/webhook/deploy', function () {
    $scriptPath = base_path('setup.sh');

    if (!file_exists($scriptPath)) {
        return response()->json(['status' => 'error', 'message' => 'Script not found'], 404);
    }

    $output = shell_exec('bash ' . escapeshellarg($scriptPath) . ' 2>&1');

    return response()->json(['status' => 'ok', 'output' => $output]);
});
