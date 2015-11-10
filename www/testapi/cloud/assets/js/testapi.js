$(function() {
    var margin_x = 5, margin_y = 5, row = -1, col = 0, margin_left = 20;
    var compute = function() {
        row = -1;
        col = 0;
        var metroheight = window.innerHeight - $('.banner').outerHeight();
        var num = parseInt(metroheight / ($('.btn-two').outerHeight() + 5) + 0.3);
        if (num == 0) {
            num = 1;
        }else if(num > 3){
            num = 4;
        }
        $('.metro').css('position', 'relative');
        $('.metro').css('left', 0);
        $('.metro').css('top', 10);
        $('.metro').css('height', metroheight);
        var width_one = $('.btn-one').outerWidth();
        var width_two = $('.btn-two').outerWidth();
        var height = $('.btn-two').outerHeight();                    
        var mark = 0;
        $('.metro .btn').each(function() {
            $(this).css('position', 'absolute');
            if (mark == 1 && $(this).hasClass('btn-one')) {
                mark = 0;
                $(this).css('left', margin_left + col * (width_two) + width_one + (col * 2 + 3) * margin_x);
                $(this).css('top', (row) * (height) + (row * 2 + 1) * margin_y);
            } else {
                row++;
                if (row >= num) {
                    col++;
                    row = 0;
                }
                $(this).css('left', margin_left + col * (width_two) + (col * 2 + 1) * margin_x);
                $(this).css('top', row * (height) + (row * 2 + 1) * margin_y);
                if ($(this).hasClass('btn-one')) {
                    mark = 1;
                } else {
                    mark = 0;
                }
            }
        });
    };
    compute();
    window.onresize = compute;
    var state = 0;
    $("html").mousewheel(function(event, delta, deltaX, deltaY) {
        if(state == 1){
            return;
        }                    
        var metrowidth = margin_left + (col+1) * $('.btn-two').outerWidth() + 2*(col+4) * margin_x;
        var totalwidth = $('html').outerWidth();
        if(totalwidth-metrowidth > 0){
            return;
        }
        var cur = parseInt($('.metro').css('left'));       
        var scroll = cur + delta * 100;
        if (scroll > 0) {
            scroll = 0;
        } else if (scroll < totalwidth-metrowidth) {
            scroll = totalwidth-metrowidth;
        }
        $('.metro').css('left', scroll);
    });

    var enter = document.all ? '\r' : '\r\n';
    var getTab = function(ll) {
        var str = '';
        for (var i = 0; i < ll; ++i) {
            str += '\t';
        }
        return str;
    };
    var json2str = function(json, l, isArray) {
        var str = '';
        var i = 0;
        for (attr in json) {
            var prefix = '';
            if (!isArray)
                prefix = attr + ': ';
            str += (i == 0 ? enter : ',' + enter);
            if ($.isArray(json[attr])) {
                str += getTab(l) + prefix + '[' + json2str(json[attr], l + 1, true) + getTab(l) + ']';
            }
            else if (typeof (json[attr]) == "object") {
                str += getTab(l) + prefix + '{' + json2str(json[attr], l + 1, false) + getTab(l) + '}';
            }
            else {
                str += getTab(l) + prefix + json[attr];
            }
            i++;
        }
        return str + enter;
    };
    var btn_click_func = function() {
        var color = $(this).css('background-color');
        $('.frame').css('background-color', color);
        $('.frame').css('z-index', '1');
        $('.frame').css('top', '0');
        $('.frame').css('left', 0);
        $('.frame').css('width', '100%');
        $('.btn-back').removeClass('hide');
        $('.btn-back').css('opacity', '0.9');
        var url = $(this).attr('url');
        $('#out_msg').removeClass('hide');
        $('#text_ret_msg').text('等待中...');                    
        state = 1;
        $.getJSON(url, {}, function(data, suc, xhr) {
            if (suc == 'success') {
                $('#text_ret_msg').text('{' + json2str(data, 1, false) + '}' + enter + enter + enter);
            }
        });
    };
    $('.btn-one,.btn-two').click(btn_click_func);
    $('.btn-wpa').click(function() {
        $('#extradiv').removeClass('hide');
        var color = $(this).css('background-color');
        $('.frame').css('background-color', color);
        $('.frame').css('z-index', '1');
        $('.frame').css('top', '0');
        $('.frame').css('left', '0');
        $('.frame').css('width', '100%');
        $('.btn-back').removeClass('hide');
        $('.btn-back').css('opacity', '0.9');
        var url = $(this).attr('url');
        $('#out_msg').removeClass('hide');
        $('#text_ret_msg').text('等待中...');                    
        state = 1;
        $.getJSON(url, {}, function(data, suc, xhr) {
            if (suc == 'success') {
                $('#text_ret_msg').text('{' + json2str(data, 1, false) + '}' + enter + enter + enter);
                $('#extradiv').html("这就是富文本：" + data.data.link);
            }
        });
    });
    $('.btn-back').click(function() {
        $('.frame').css('width', '40%');
        $('.frame').css('top', '0');
        var t = window.outerWidth * (-1);
        $('.frame').css('left', t);
        xframe = t;
        $('.btn-back').addClass('hide');
        $('.btn-back').css('opacity', '0');
        $('#out_msg').addClass('hide');
        $('#extradiv').addClass('hide');
        $('#text_ret_msg').text('');                    
        state = 0;
    });    
    $('#viewlogin').click(function() {
        alert('当前cookie:' + document.cookie);
    });    
});