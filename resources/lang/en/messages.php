<?php

return [
    'auth' => [
        'register_success' => 'User successfully registered',
        'login_success' => 'Successfully logged in',
        'logout_success' => 'Successfully logged out',
        'invalid_credentials' => 'Invalid credentials',
        'unauthenticated' => 'Unauthenticated',
    ],
    'users' => [
        'created' => 'User successfully created',
        'updated' => 'User successfully updated',
        'deleted' => 'User successfully deleted',
        'not_found' => 'User not found',
        'list_retrieved' => 'Users list retrieved successfully',
        'retrieved' => 'User retrieved successfully',
    ],
    'validation' => [
        'name_required' => 'The name field is required',
        'email_required' => 'The email field is required',
        'email_invalid' => 'The email must be a valid email address',
        'email_unique' => 'User with this email already exists',
        'password_required' => 'The password field is required',
        'password_confirmed' => 'Passwords do not match',
        'password_min' => 'Password must be at least 8 characters',
    ],
    'rate_limit_exceeded' => 'Too many requests. Please try again in :seconds seconds.',
];