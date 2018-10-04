@extends('layout.default')

@section('content')

    <div class="scan" id="scan">
        <img src="{{ asset('img/card.png') }}">
        <div class="code">
            <span id="code">&nbsp;</span>
            <span id="key" style="display: none;"></span>
        </div>
    </div>

    <div class="pass" id="pass">
        <div class="access">&nbsp;</div>
        <div class="buttons">
            <div class="row">
                <div class="col-4">
                    <div onclick="passNum(1)" class="num">
                        1
                    </div>
                </div>
                <div class="col-4">
                    <div onclick="passNum(2)" class="num">
                        2
                    </div>
                </div>
                <div class="col-4">
                    <div onclick="passNum(3)" class="num">
                        3
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <div onclick="passNum(4)" class="num">
                        4
                    </div>
                </div>
                <div onclick="passNum(5)" class="col-4">
                    <div class="num">
                        5
                    </div>
                </div>
                <div onclick="passNum(6)" class="col-4">
                    <div class="num">
                        6
                    </div>
                </div>
            </div>
            <div class="row">
                <div onclick="passNum(7)" class="col-4">
                    <div class="num">
                        7
                    </div>
                </div>
                <div onclick="passNum(8)" class="col-4">
                    <div class="num">
                        8
                    </div>
                </div>
                <div onclick="passNum(9)" class="col-4">
                    <div class="num">
                        9
                    </div>
                </div>
            </div>

            <div class="row">
                <div onclick="passNum(0)" class="col-4">
                    <div class="num">
                        -
                    </div>
                </div>
                <div onclick="passNum(8)" class="col-4">
                    <div class="num">
                        0
                    </div>
                </div>
                <div onclick="passNum(0)" class="col-4">
                    <div class="num">
                        #
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <a href="javascript:" onclick="enterPass()" class="button success">
                    ENTER
                </a>
            </div>
            <div class="col-6">
                <a href="javascript:" onclick="cancelPass()" class="button">
                    GO BACK
                </a>
            </div>
        </div>
    </div>

@endsection

@section('script')
<script>
var first = true;
var active = false;
var code = '';
var userID = null;

$(document).ready(() => {

    $(document).keyup((e) => {
        var key = String.fromCharCode(e.which);

        if (first) {
            $('#code').html('*');
            $('#key').html(key);
        }
        else {
            $('#code').prepend('*');
            $('#key').prepend(key);
        }

        first = false;

        setTimeout(() => {
            if (active)
                return;

            active = true;

            var key = $('#key').html().split('').reverse().join('');
            
            $.ajax({
                type: 'GET',
                url: `{{ asset('') }}validate/${key}`,
                beforeSend: () => {
                    $('#code').html('<i class="fa fa-spinner fa-pulse"></i>');
                },
                success: (data) => {
                    var info = data;

                    if (info.status == 200) {
                        userID = data.id;
                        $('.code').html('<i class="fas fa-check"></i>');
                        $('.code').addClass('success');

                        $('#scan').fadeOut(() => {
                            $('#pass').fadeIn();
                        });
                    }
                },
                error: (data) => {
                    var info = data;

                    userID = null;

                    $('.code').addClass('danger');

                    if (info.status == 401) {
                        if (info.banned) {
                            $('.error').fadeIn().html(`Your account has been deactivated.`);
                            setTimeout(() => {
                                $('.code').removeClass('success');
                                $('.code').removeClass('danger');
                                $('#code').html('&nbsp;');
                                first = true;
                                active = false;
                            }, 3000);
                            return;
                        }
                    }

                    if (info.status == 400) {
                        $('.code').addClass('danger');

                        setTimeout(() => {
                            $('.code').removeClass('success');
                            $('.code').removeClass('danger');
                            $('#code').html('&nbsp;');
                            first = true;
                            active = false;
                        }, 50);
                        return;
                    }

                    $('.code').addClass('danger');

                    setTimeout(() => {
                        $('.code').removeClass('success');
                        $('.code').removeClass('danger');
                        $('#code').html('&nbsp;');
                        first = true;
                        active = false;
                    }, 50);
                    return;
                }
            });

        }, 500);

    })

});

function passNum(num) {
    if ($('.access').html() == '&nbsp;')
        $('.access').html('');

    if (num == 0) {
        var html = $('.access').html();
        var minus = html.substring(0, html.length - 1);

        if (minus == '')
            $('.access').html('&nbsp;');
        else
            $('.access').html(minus);

        var newcode = code.substring(0, code.length - 1);
        code = newcode;
        return;
    }

    $('.access').prepend('*');
    code = code + `${num}`;
}

function enterPass () {
    $.ajax({
        type: 'GET',
        url: `{{ asset('') }}code/${userID}/${code}`,
        beforeSend: () => {
            $('.access').html('<i class="fa fa-spinner fa-pulse"></i>');
        },
        success: (data) => {
            var info = data;

            if (info.status == 200) {
                $('.access').addClass('success');
                $('.access').html('<i class="fas fa-check"></i>');
            
                document.location.href = '{{ route('dashboard') }}';
            }
        },
        error: (data) => {
            var info = data;

            $('.access').removeClass('success').addClass('danger');
            setTimeout(() => {
                $('.access').removeClass('danger');
                code = '';
                $('.access').html('&nbsp;');
            }, 500);
        }
    });

    // if (code == '1234') {
    //     $('.access').addClass('success');
    // } else {
    //     $('.access').addClass('danger');
    //     setTimeout(() => {
    //         $('.access').removeClass('danger');
    //         code = '';
    //         $('.access').html('&nbsp;');
    //     }, 500);
    // }
}

function cancelPass () {
    userID = null;
    $('.access').removeClass('success');
    code = '';
    $('.access').html('&nbsp;');
    $('#pass').fadeOut(() => {
        $('#scan').fadeIn();
        $('.code').removeClass('success');
        $('.code').removeClass('danger');
        $('#code').html('&nbsp;');
        first = true;
        active = false;
    });
}

</script>
@endsection