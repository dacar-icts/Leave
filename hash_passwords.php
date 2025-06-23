<?php
// Input and output file paths
$inputFile  = 'input.csv';  // Your original CSV file with plain passwords
$outputFile = 'output_hashed.csv'; // New file with hashed passwords

// Open files
$inputHandle  = fopen($inputFile, 'r');
$outputHandle = fopen($outputFile, 'w');

if (!$inputHandle || !$outputHandle) {
    die("Failed to open input or output file.\n");
}

$header = fgetcsv($inputHandle);
$passwordIndex = array_search('password', $header);

if ($passwordIndex === false) {
    die("No 'password' column found.\n");
}

// Write header to output
fputcsv($outputHandle, $header);

// Process each row
while (($row = fgetcsv($inputHandle)) !== false) {
    $plainPassword = $row[$passwordIndex];
    $row[$passwordIndex] = password_hash($plainPassword, PASSWORD_BCRYPT);
    fputcsv($outputHandle, $row);
}

fclose($inputHandle);
fclose($outputHandle);

echo "Passwords hashed and saved to $outputFile\n";
