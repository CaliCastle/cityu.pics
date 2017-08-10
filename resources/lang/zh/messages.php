<?php

return [
    'app' => [
        'slogan' => 'CityU图片分享平台'
    ],
    'navbar' => [
        'sr-only' => '切换导航',
        'user-menu' => [
            'admin' => '后台管理',
            'profile' => '个人主页',
            'achievements' => '成就',
            'checkin' => '签到',
            'signout' => '登出'
        ],
        'compose-new' => '发布图文'
    ],
    'composer' => [
        'description-title' => '拖拽图片到这里或者点击选择',
        'description-tips' => '(只允许上传:count个图片, 每个不能大于 :size MB)',
        'cancel' => '算了',
        'post' => '发布',
        'caption-placeholder' => '说些什么吧',
        'hashtag-placeholder' => '输入 #主题标签, 不用输入 "#"',
        'dropzone' => [
            'too-big' => '文件过大. 最大限制: {{maxFilesize}}M',
            'invalid' => '你不能上传此类文件',
            'cancel' => '取消上传',
            'remove' => '删除',
            'max' => '文件超过最多限数'
        ]
    ],
    'auth' => [
        'background-description' => '欢迎来到CityU Pics. CityU的专属图片分享平台',
        'login' => [
            'heading' => '填写登录信息',
            'email' => 'CityU邮箱地址',
            'password' => '密码',
            'logging' => '登录中',
            'first-time' => '第一次访问? 立刻注册'
        ],
        'register' => [
            'heading' => '填写注册信息',
            'name' => '昵称',
            'password' => '密码 (不少于6个字符)',
            'password-confirm' => '确认密码',
            'registering' => '注册中',
            'got-account' => '已经有账号了? 直接登录'
        ],
        'confirm' => [
            'callout' => '输入验证码',
            'description' => '请输入验证邮件里的5位数字<br />或者点击邮件中的链接跳过此步',
            'wrong' => '验证码错误',
            'resend' => '重发验证码',
            'sent' => '验证码已发'
        ]
    ],
    'titles' => [
        'feed' => '动态',
        'confirm' => '验证您的邮箱',
        'profile' => ':user的个人主页'
    ],
    'email' => [
        'confirm' => [
            'title' => '验证码: :code - 账号注册成功',
            'message' => '感谢阁下在我们的平台注册账号, <a href=":url">点击此链接通过验证</a> 或者输入验证码： :code',
            'ignore' => '如果您没有在我们的平台注册账号，不要慌，请无视这封邮件'
        ]
    ]
];