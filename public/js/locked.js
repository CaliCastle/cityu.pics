$(document).ready(function () {
    setTimeout(function () {
        $($('.number-box:first-of-type')[0]).focus();
    }, 200);

    $('.number-box:not(:last-of-type)').each(function () {
        $(this).keypress(function (e) {
            var $this = this,
                keyCode = e.which || e.keyCode;

            if (keyCode >= 48 && keyCode <= 57 && $this.innerText.length < 1) {
                focusNext($this);
            } else {
                return false;
            }
        });
        $(this).keyup(function (e) {
            var $this = this,
                keyCode = e.which || e.keyCode;

            if (keyCode == 8 || keyCode == 46 && $this.inner.length < 1) {
                focusLast($this);
                return false;
            }
        });
    });

    $('.number-box:last-of-type').keydown(function (e) {
        var $this = this,
            keyCode = e.which || e.keyCode;

        if (keyCode == 8) {
            focusLast($this);
            return false;
        }

        if (keyCode >= 48 && keyCode <= 57 && $this.innerText.length < 1) {
            setTimeout(function () {
                fillDigits();
                submitCode();
            }, 80);
        } else {
            return false;
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

function focusLast($current) {
    $current.value = '';

    setTimeout(function () {
        $($current).prev(".number-box").focus();
        $($current).prev(".number-box").val('');
    }, 2);
}

function focusNext($current) {
    setTimeout(function () {
        $($current).next(".number-box").focus();
    }, 2);
}

function fillDigits() {
    var digits = '';

    $('.number-box').each(function () {
        digits += this.value;
    });
    document.querySelector('form input[name=code]').value = digits;
}

function submitCode() {
    $('form').submit();
}