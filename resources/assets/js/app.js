/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('mo-js');

require('timeago');

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': Laravel.csrfToken
    }
});

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
            if (this.readingInbox)
                return false;

            let inbox = e.target,
                $this = this;

            if ($(inbox).hasClass('reading'))
                return false;

            $(inbox).addClass('reading');
            this.readingInbox = true;

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
                        window.location.href = $(inbox).attr('data-link');
                },
                complete() {
                    $this.readingInbox = false;
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
            // Check for logged-in.
            if (this.User.id == undefined) {
                return false;
            }

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
        token: Laravel.csrfToken,
        readingInbox: false,
    },
    computed: {
        Experience() {
            return this.User.experience.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    },
    mounted() {
        this.getInbox();
    }
});

const $composerVm = new Vue({
    el: '.composer',
    data: {captionText: ''}
});

window.$vm = $vm;
window.$composerVm = $composerVm;

jQuery.timeago.settings.strings = TimeStrings;

$(document).ready(function () {
    // Slimscroll.
    $('.SlimScroll').slimscroll({
        allowPageScroll: true
    });

    // Time ago.
    $('.timeago').timeago();

    // Search
    let mainContainer = document.querySelector('#app'),
        openCtrl = document.querySelector('.btn-search'),
        closeCtrl = document.querySelector('.btn--search-close'),
        searchContainer = document.querySelector('.Search'),
        inputSearch = searchContainer.querySelector('.Search__input');

    function initSearchEvents() {
        if ($vm.User.id == undefined) {
            return false;
        }

        openCtrl.addEventListener('click', openSearch);
        closeCtrl.addEventListener('click', closeSearch);
        document.addEventListener('keyup', function (ev) {
            // Escape key.
            if (ev.keyCode == 27) {
                closeSearch();
            }
        });
    }

    function openSearch(e) {
        e.preventDefault();

        mainContainer.classList.add('main-wrap--move');
        searchContainer.classList.add('search--open');
        document.body.classList.add('searching');
        inputSearch.focus();
    }

    function closeSearch() {
        mainContainer.classList.remove('main-wrap--move');
        searchContainer.classList.remove('search--open');
        document.body.classList.remove('searching');
        inputSearch.blur();
        inputSearch.value = '';
    }

    initSearchEvents();

    const loadingIcon = '<i class="fa fa-circle-o-notch fa-spin"></i>&nbsp;';

    $("form.ajax").each(function () {
        const form = this;
        $(this).on('submit', function (e) {
            e.preventDefault();

            $(form).addClass('loading');

            let button = $(form).find("button[type=submit]")[0];

            if (button) {
                var originText = button.innerHTML;
                $(button).html(`${loadingIcon}&nbsp;${originText}`);
            }

            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                timeout: 0,
                error(error) {
                    if (error.status === 422) {
                        let errors = JSON.parse(error.responseText);
                        for (let er in errors) {
                            const sel = `[name=${er}]`,
                                groupEl = $($(form).find(sel)[0]).parents('.input-field')[0];
                            // Add error class to the input-field
                            $(groupEl).addClass('has-error shaky');
                            setTimeout(() => $(groupEl).removeClass('has-error shaky'), 8000);

                            toastr.error(errors[er][0]);
                        }
                    }
                },
                success(data) {
                    if ($(form).attr('callback')) {
                        const callback = $(form).attr('callback');
                        callback();

                        return false;
                    }

                    if (data.status !== 'error') {
                        if (typeof(data.redirectUrl) != 'undefined') {
                            if (data.redirectUrl == 'refresh') {
                                window.location.reload();
                            } else {
                                window.location.href = data.redirectUrl;
                            }
                        } else if (typeof(data.newWindowUrl) != 'undefined') {
                            window.open(data.newWindowUrl, "_blank");
                        } else if (typeof(data.reload) != 'undefined') {
                            toastr.success(data.message);
                            $.pjax.reload(pjaxContainer);
                        } else {
                            toastr.success(data.message);
                        }
                    } else {
                        toastr.error(data.message);
                    }
                },
                complete() {
                    if (button) {
                        $(button).html(originText);
                        $(form).removeClass('loading');
                        $(form).addClass('done-loaded');
                        setTimeout(function () {
                            $(form).removeClass('done-loaded');
                        }, 300);
                    }
                }
            });
        });
    });
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