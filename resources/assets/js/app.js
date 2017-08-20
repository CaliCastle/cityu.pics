/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('mo-js');

require('timeago');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const $vm = new Vue({
    el: '#app',
    methods: {
        request(param) {
            $.ajax({
                type: param.type,
                url: param.url,
                data: param.data || {},
                success(data) {
                    if (data.status != undefined) {
                        if (data.message != undefined)
                            toastr[data.status](data.message);

                        if (param.callback != undefined)
                            param.callback((data.status != 'error'), data);
                    }
                },
                error(er) {
                    displayErrorMessage();

                    if (param.callback != undefined)
                        param.callback(false);
                },
                complete(ev) {
                    if (param.complete != undefined) {
                        param.complete(ev);
                    }
                }
            });
        },
        readInbox(e) {
            const inbox = e.target,
                $this = this;

            if ($(inbox).hasClass('reading'))
                return false;

            $(inbox).addClass('reading');

            this.request({
                url: '/read/notification',
                type: 'PATCH',
                data: {
                    id: $(inbox).attr('inbox-id')
                },
                callback(success) {
                    $(inbox).removeClass('reading');

                    if (success) {
                        let index = $(inbox).attr('inbox');
                        $this.Inboxes.splice(index, 1);
                        $this.User.unread--;
                    }

                    if (inbox.getAttribute('data-link') != undefined)
                        setTimeout(() => window.location.href = inbox.getAttribute('data-link'), 150);
                }
            });
        },
        readAllInbox() {
            let ids = [],
                $this = this;

            $(".Inbox__item > a").each(function () {
                ids.push($(this).attr('inbox-id'));
                $(this).addClass('reading');
            });

            this.request({
                url: '/read/notification',
                type: 'PATCH',
                data: {
                    id: ids.join(',')
                },
                callback(success) {
                    if (success) {
                        for (let id in ids)
                            $this.Inboxes.pop();

                        $this.User.unread -= ids.length;
                    }
                }
            });
        },
        getInbox() {
            let $this = this;

            this.request({
                url: '/get-inbox',
                type: 'POST',
                callback(success, data) {
                    if (success) {
                        for (let i in data.inbox) {
                            $this.Inboxes.push(data.inbox[i]);
                        }
                        setTimeout(() => $('.Inbox .timeago').timeago(), 200);
                    }
                }
            });
        }
    },
    data: {
        User: CurrentUser,
        Inboxes: [],
        token: Laravel.csrfToken
    },
    mounted() {
        this.getInbox();
    }
});

window.$vm = $vm;

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

jQuery.timeago.settings.strings = TimeStrings;

$(document).ready(function () {
    // Slimscroll.
    $('.SlimScroll').slimscroll({
        allowPageScroll: true
    });

    // Time ago.
    $('.timeago').timeago();
});

// Only listen if logged in.
if ($vm.User.id != undefined) {
    Echo.private(`App.User.${$vm.User.id}`)
        .listen('UserFollowed', notificationReceived)
        .listen('LikedPost', notificationReceived)
        .listen('LikedComment', notificationReceived)
        .listen('CommentPosted', notificationReceived)
        .listen('NewCommentReply', notificationReceived)
        .listen('ExperienceHasChanged', notificationReceived);
}

function notificationReceived(data) {
    // Append to the Inbox.
    $vm.Inboxes.reverse();
    $vm.Inboxes.push(data.notification);
    $vm.Inboxes.reverse();

    // Display toastr.
    toastr.info(data.notification.message);
    // Animate notification button.
    document.querySelector('.notif-button').classList.add('bounce');
    setTimeout(() => document.querySelector('.notif-button').classList.remove('bounce'), 750);

    // Add unread count.
    $vm.User.unread++;

    if (data.experience != undefined) {
        $vm.User.experience += parseInt(data.experience);
    }

    setTimeout(() => $('.Inbox .timeago').timeago('updateFromDOM'), 500);
}