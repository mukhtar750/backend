<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// --- Start Debugging Code ---

use App\Models\Task;

// Replace with an actual task ID that is causing the 500 error
$taskId = 1; // You might need to change this to a valid Task ID from your database

try {
    $task = Task::find($taskId);

    if ($task) {
        echo "Task found:\n";
        echo "ID: " . $task->id . "\n";
        echo "Title: " . $task->title . "\n";
        echo "Assignee ID: " . ($task->assignee_id ?? 'N/A') . "\n";
        echo "Status: " . $task->status . "\n";
        // Add any other relevant attributes you want to inspect

        // Attempt to call the new methods if they are related to the error
        // echo "Status Class: " . $task->getStatusClass() . "\n";
        // echo "Status Label: " . $task->getStatusLabel() . "\n";

    } else {
        echo "Task with ID {$taskId} not found.\n";
    }
} catch (\Exception $e) {
    echo "An error occurred while trying to load the task:\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

// --- End Debugging Code ---

$kernel->terminate($request, $response);