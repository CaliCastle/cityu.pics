<?php

return [
    'app'      => [
        'slogan' => 'CityU图片分享平台'
    ],
    'alerts'   => [
        'error' => '出错了，请稍后重试'
    ],
    'navbar'   => [
        'sr-only'     => '切换导航',
        'user-menu'   => [
            'admin'        => '后台管理',
            'profile'      => '个人主页',
            'liked'        => '赞过的动态',
            'achievements' => '成就',
            'settings'     => '设置',
            'checkin'      => '签到',
            'signout'      => '登出'
        ],
        'compose-new' => '发布图文',
        'inbox'       => [
            'unread'  => '条未读通知',
            'see-all' => '查看全部',
            'empty'   => '暂无未读通知'
        ],
    ],
    'composer' => [
        'description-title'   => '拖拽图片到这里 <i>或者</i> 点击选择',
        'description-tips'    => '(限制:count张图片, 每张不大于 :size MB)',
        'cancel'              => '算了',
        'post'                => '发布',
        'caption-placeholder' => '说些什么吧',
        'hashtag-placeholder' => '参与话题 (如 "cityu")',
        'dropzone'            => [
            'too-big' => '文件过大. 最大限制: {{maxFilesize}}M',
            'invalid' => '你不能上传此类文件',
            'cancel'  => '取消上传',
            'remove'  => '删除',
            'max'     => '文件数量超过限制'
        ]
    ],
    'auth'     => [
        'background-description' => '欢迎来到CityU专属图片分享平台',
        'login'                  => [
            'heading'    => '登录',
            'email'      => 'CityU邮箱',
            'password'   => '密码',
            'logging'    => '登录中',
            'first-time' => '第一次访问? 立刻注册'
        ],
        'register'               => [
            'heading'          => '注册',
            'name'             => '昵称',
            'password'         => '密码 (不少于6个字符)',
            'password-confirm' => '确认密码',
            'registering'      => '注册中',
            'got-account'      => '已经有账号了? 直接登录'
        ],
        'confirm'                => [
            'callout'     => '输入验证码',
            'description' => '请输入验证邮件里的5位数字<br />或者点击邮件中的链接跳过此步',
            'wrong'       => '验证码错误',
            'resend'      => '重发验证码',
            'sent'        => '验证码已发'
        ]
    ],
    'titles'   => [
        'feed'    => '动态',
        'confirm' => '验证您的邮箱',
        'profile' => ':user的个人主页'
    ],
    'email'    => [
        'confirm' => [
            'title'   => '验证码: :code - 账号注册成功',
            'message' => '感谢阁下在我们的平台注册账号, <a href=":url">点击此链接通过验证</a> 或者输入验证码： :code',
            'ignore'  => '如果您没有在我们的平台注册账号，不要慌，请无视这封邮件'
        ],
        'base'    => [
            'sent-from' => '邮件来自'
        ]
    ],
    'profile'  => [
        'upload-avatar' => [
            'title'   => '上传头像',
            'change'  => '换张头像',
            'done'    => '确定剪裁',
            'success' => '头像更改成功!'
        ],
        'posts-found'   => '共:total条动态',
        'followers'     => '粉丝<span>:count</span>人',
        'followings'    => '已关注:count人',
        'follow-state'  => [
            'followed'      => '已关注',
            'followed-back' => '互相关注',
            'unfollowed'    => '关注'
        ]
    ],
    'posts'    => [
        'load-more' => '继续加载',
        'comments'  => [
            'placeholder' => '尽情评论... (按回车提交)',
            'total'       => ':total条评论',
            'post'        => '评论',
            'posting'     => '评论中...',
            'no-comments' => '暂无评论，快来抢沙发',
            'cancel'      => '取消回复',
        ],
        'actions'   => [
            'delete'  => '删除',
            'sign-in' => '登录后进行回复/点赞',
            'confirm' => '确定'
        ]
    ],
    'footer'   => [
        'info'  => [
            'title'   => '网站信息',
            'about'   => '关于本站',
            'faq'     => '常见问题',
            'privacy' => '用户隐私'
        ],
        'dev'   => [
            'title'      => '开发相关',
            'contribute' => '参与贡献',
            'history'    => '开发记录'
        ],
        'links' => [
            'title' => '相关链接'
        ]
    ]
];