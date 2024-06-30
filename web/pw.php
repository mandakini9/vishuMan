<?php

// User's password to be hashed
$userPassword = 'user123';

// Hash the password
$hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);

// Output the hashed password
echo 'Hashed Password: ' . $hashedPassword;


//User's entered password for verification
$userEnteredPassword = 'fdfdf';

// Check if the entered password matches the hashed password
if (password_verify($userEnteredPassword, $hashedPassword)) {
    echo 'Password is valid!';
} else {
    echo 'Invalid password.';
}