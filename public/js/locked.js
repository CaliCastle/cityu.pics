$(document).ready(function () {
    setTimeout(function () {$($('.number-box:first-of-type')[0]).focus();}, 150);

    $('.number-box:not(:last-of-type)').each(function () {
        $(this).keypress(function (e) {
            var $this = this;

            if (e.keyCode >= 48 && e.keyCode <= 57 && $this.innerText.length < 1) {
                focusNext($this);
            } else {
                setTimeout(function () {
                    $this.innerText = '';
                }, 20);
            }
        });
    });

    $('.number-box:last-of-type').keydown(function (e) {
        var $this = this;

        if (e.keyCode >= 48 && e.keyCode <= 57 && $this.innerText.length < 1) {
            setTimeout(function () {
                fillDigits();
                submitCode();
            }, 80);
        } else {
            setTimeout(function () {
                $this.innerText = '';
            }, 20);
        }
    });

    $('button.resend-button').on('click', function () {
        $('.resend').toggleClass('sending');

        $.ajax({
            method: 'PUT',
            data: {_token: $('meta[name=csrf_token]').attr('content')},
            success: function () {
                $('.resend').toggleClass('sending');
                $('.resend-button').next().removeClass('hidden');
                $('.resend-button').remove();
                setTimeout(function () {
                    $('.resend span').removeClass('fadeInLeft').addClass('fadeOutLeft');
                }, 2500);
            }
        });
    });
});

function focusNext($current) {
    setTimeout(function () {
        $($current).next(".number-box").focus();
    }, 2);
}

function fillDigits() {
    var digits = '';

    $('div.number-box').each(function () {
       digits += this.innerText;
    });
    $('form input[name=code]').val(digits);
}

function submitCode() {
    $('form').submit();
}