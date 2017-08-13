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
            'settings' => 'Settings',
            'checkin' => 'Check In',
            'signout' => 'Sign out'
        ],
        'compose-new' => 'Post new'
    ],
    'composer' => [
        'description-title' => 'Add images by dragging files here <i>or</i> select by clicking',
        'description-tips' => '(Only allows :count images maximum, each smaller than :size MB)',
        'cancel' => 'Cancel',
        'post' => 'Post',
        'caption-placeholder' => 'Add a comment',
        'hashtag-placeholder' => 'Enter #hashtags',
        'dropzone' => [
            'too-big' => 'File is too big. Max size: {{maxFilesize}}M',
            'invalid' => 'You can\'t upload files of this type',
            'cancel' => 'Cancel upload',
            'remove' => 'Remove',
            'max' => 'You cannot upload any more files'
        ]
    ],
    'auth' => [
        'background-description' => 'Welcome to the Picture Sharing Site for CityU',
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
        'confirm' => 'Confirm Your Email',
        'profile' => ':user\'s Profile'
    ],
    'email' => [
        'confirm' => [
            'title' => 'Confirm Code: :code - Account Registered',
            'message' => 'Thanks for registering at our website, <a href=":url">click to confirm your account</a> or enter the confirmation code :code',
            'ignore' => 'If you didn\'t register an account at our website, then ignore this e-mail.'
        ]
    ],
    'profile' => [
        'upload-avatar' => [
            'title' => 'Upload Avatar',
            'change' => 'Change file',
            'done' => 'This is it',
            'success' => 'You changed your avatar!'
        ],
        'posts-found' => ':total post found.|:total posts found.'
    ],
    'posts' => [
        'load-more' => 'Load more',
        'comments' => [
            'placeholder' => 'Say something... (press Enter to submit)',
            'total' => ':total comment|:total comments',
            'post' => 'Post'
        ]
    ]
];