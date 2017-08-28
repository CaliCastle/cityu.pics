<?php

return [
    'app'      => [
        'slogan' => 'CityU Photo Sharing Platform',
        '404'    => 'The page you\'re looking for went M.I.A.'
    ],
    'welcome'  => [
        'introduction' => 'Introducing',
        'popular'      => 'See what\'s popular',
        'subtitle'     => 'Join in the big family now -> <a href=":url">Register</a>',
        'show-feed'    => 'Show all feed',
        'likes'        => ':like like|:like likes',
        'share'        => [
            'top'    => 'Share',
            'bottom' => 'The CityU Way'
        ],
        'comment'      => [
            'top'    => 'A fun way',
            'bottom' => 'to interact'
        ],
        'inbox'        => [
            'top'    => 'Real-time',
            'bottom' => 'notifications update'
        ],
        'checkin'      => [
            'top'    => 'Daily Check in',
            'bottom' => 'Keep the streak'
        ],
        'languages'    => [
            'top'    => 'Multi-language support',
            'bottom' => 'Wanna help out?'
        ]
    ],
    'alerts'   => [
        'error' => 'Something went wrong, try again later'
    ],
    'navbar'   => [
        'sr-only'     => 'Toggle Navigation',
        'user-menu'   => [
            'admin'        => 'Admin',
            'profile'      => 'Profile',
            'liked'        => 'Liked',
            'achievements' => 'Achievements',
            'settings'     => 'Settings',
            'checkin'      => 'Check In',
            'signout'      => 'Sign out'
        ],
        'compose-new' => 'Post new',
        'inbox'       => [
            'unread'  => 'unread message|unread messages',
            'see-all' => 'See all',
            'empty'   => 'Empty inbox'
        ],
        'search'      => [
            'placeholder' => 'Search',
            'tips'        => 'Hit enter to search or ESC to close'
        ],
        'home'        => 'Home page'
    ],
    'composer' => [
        'description-title'   => 'Add images by dragging files here <i>or</i> select by clicking',
        'description-tips'    => '(Only allows :count images maximum, each smaller than :size MB)',
        'cancel'              => 'Cancel',
        'post'                => 'Post',
        'caption-placeholder' => 'Add a comment',
        'hashtag-placeholder' => 'Enter #hashtags',
        'dropzone'            => [
            'too-big' => 'File is too big. Max size: {{maxFilesize}}M',
            'invalid' => 'You can\'t upload files of this type',
            'cancel'  => 'Cancel upload',
            'remove'  => 'Remove',
            'max'     => 'You cannot upload any more files'
        ]
    ],
    'auth'     => [
        'background-description' => 'Welcome to the Picture Sharing Site for CityU',
        'login'                  => [
            'heading'    => 'Sign In Below',
            'email'      => 'CityU Email Only',
            'password'   => 'Password',
            'logging'    => 'Logging in',
            'first-time' => 'First time here? Register'
        ],
        'register'               => [
            'heading'          => 'Register Below',
            'name'             => 'Your Name',
            'password'         => 'Password (At least 6 characters)',
            'password-confirm' => 'Confirm Password',
            'registering'      => 'Registering',
            'got-account'      => 'Got an account? Login'
        ],
        'confirm'                => [
            'callout'     => 'Enter Code',
            'description' => 'Enter the 5-digit code from the confirmation email we sent to you.<br />Or you can click on the confirmation link to skip this process.',
            'wrong'       => 'Wrong code',
            'resend'      => 'Resend the code',
            'sent'        => 'Code sent'
        ]
    ],
    'titles'   => [
        'welcome'  => 'Welcome',
        'feed'     => 'Feed',
        'confirm'  => 'Confirm Your Email',
        'profile'  => ':user\'s Profile',
        'settings' => 'Personal Settings',
        'search'   => 'Everything Related to ":query"',
        'tag'      => '#:tag Post|#:tag Posts',
        'liked'    => 'Feed I Liked'
    ],
    'email'    => [
        'confirm' => [
            'title'   => 'Confirm Code: :code - Account Registered',
            'heading' => 'Confirm Your Email',
            'message' => 'Thanks for registering at our website <br><br><a href=":url">Click to confirm your account</a> or enter the confirmation code <b>:code</b>',
            'ignore'  => 'If you didn\'t register an account at our website, then ignore this e-mail.'
        ],
        'base'    => [
            'sent-from'        => 'Sent with ❤️ from',
            'unsubscribe-tips' => 'You\'re receiving this email because you\'ve signed up to receive updates from us. If you\'d prefer not to or feel annoyed, you can change your preferences in the settings.',
            'unsubscribe'      => 'Unsubscribe'
        ]
    ],
    'profile'  => [
        'upload-avatar' => [
            'title'   => 'Upload Avatar',
            'change'  => 'Change file',
            'done'    => 'This is it',
            'success' => 'You changed your avatar!'
        ],
        'posts-found'   => ':total post found.|:total posts found.',
        'followers'     => '<span>:count</span> Follower|<span>:count</span> Followers',
        'followings'    => ':count Following',
        'follow-state'  => [
            'followed'      => 'Followed',
            'followed-back' => 'Friends',
            'unfollowed'    => 'Follow'
        ]
    ],
    'posts'    => [
        'load-more' => 'Load more',
        'comments'  => [
            'placeholder' => 'Say something... (press Enter to submit)',
            'total'       => ':total comment|:total comments',
            'post'        => 'Post',
            'posting'     => 'Posting...',
            'no-comments' => 'No comments yet.',
            'cancel'      => 'Cancel reply',
        ],
        'actions'   => [
            'delete'  => 'Delete',
            'sign-in' => 'You\'ll need to login to comment.',
            'confirm' => 'Confirm'
        ]
    ],
    'search'   => [
        'related-tags'  => 'Related Tags',
        'related-users' => 'Related Users',
        'related-posts' => 'Related Posts',
        'none-found'    => 'None found',
        'posts'         => 'post|posts'
    ],
    'settings' => [
        'tabs'           => [
            'personal' => 'Personal',
            'privacy'  => 'Privacy',
            'feed'     => 'Feed'
        ],
        'email'          => 'Email (Cannot be changed)',
        'password'       => 'Change password',
        'description'    => 'Describe yourself',
        'gender'         => 'Gender',
        'gender-options' => [
            'male'       => 'Boy',
            'female'     => 'Girl',
            'unspecific' => 'Secret'
        ],
        'changed'        => 'Settings have been changed',
        'switches'       => [
            'on'  => 'On',
            'off' => 'Off'
        ],
        'display-email'  => 'Display E-mail on profile page',
        'subscribe'      => 'Subscribe to our newsletter or announcement email',
        'feed-filter'    => 'Show the feed from your following users only'
    ],
    'footer'   => [
        'info'        => [
            'title'   => 'Information',
            'about'   => 'About',
            'faq'     => 'FAQs',
            'privacy' => 'Privacy',
            'cookie'  => 'Cookie',
            'terms'   => 'Terms'
        ],
        'dev'         => [
            'title'      => 'Dev',
            'contribute' => 'Contribute',
            'history'    => 'Develop History'
        ],
        'links'       => [
            'title' => 'Links'
        ],
        'back-to-top' => 'Back to top'
    ]
];