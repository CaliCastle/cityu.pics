<?php

return [
    'app' => [
        'slogan' => 'CityU Photo Sharing Platform'
    ],
    'navbar' => [
        'sr-only' => 'Toggle Navigation',
        'user-menu' => [
            'admin' => 'Admin',
            'profile' => 'Profile',
            'achievements' => 'Achievements',
            'checkin' => 'Check In',
            'signout' => 'Sign out'
        ],
        'compose-new' => 'Post new'
    ],
    'composer' => [
        'description-title' => 'Add images by dragging files here or selecting',
        'description-tips' => '(Only allows :count images maximum, each smaller than :size MB)',
        'cancel' => 'Cancel',
        'post' => 'Post',
        'caption-placeholder' => 'Add a comment',
        'hashtag-placeholder' => 'Enter #hashtags, without entering "#"',
        'dropzone' => [
            'too-big' => 'File is too big. Max size: {{maxFilesize}}M',
            'invalid' => 'You can\'t upload files of this type',
            'cancel' => 'Cancel upload',
            'remove' => 'Remove',
            'max' => 'You cannot upload any more files'
        ]
    ],
    'auth' => [
        'login' => [
            'heading' => 'Sign In Below',
            'email' => 'CityU Email Only',
            'password' => 'Password',
            'logging' => 'Logging in',
            'first-time' => 'First time here? Register'
        ],
        'register' => [
            'heading' => 'Register Below',
            'name' => 'Your Name',
            'password' => 'Password (At least 6 characters)',
            'password-confirm' => 'Confirm Password',
            'registering' => 'Registering',
            'got-account' => 'Got an account? Login'
        ],
        'confirm' => [
            'callout' => 'Enter Code',
            'description' => 'Enter the 5-digit code from the confirmation email we sent to you.<br />Or you can click on the confirmation link to skip this process.',
            'wrong' => 'Wrong code',
            'resend' => 'Resend the code',
            'sent' => 'Code sent'
        ]
    ],
    'titles' => [
        'feed' => 'Feed',
        'confirm' => 'Confirm your email'
    ]
];