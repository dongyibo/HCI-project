/**
 * 关注用户
 */
function forkUser(myId, forkId) {
    //alert(myId+" "+forkId);
    var success = function (data) {
        if (data.msg == '关注成功!') {
            $('#friend_alert').removeClass('alert-warning');
            $('#friend_alert').addClass('alert-success');
        }
        else {
            $('#friend_alert').removeClass('alert-success');
            $('#friend_alert').addClass('alert-warning');
        }
        $('#friend_alert').show();
        $('#friend_alert').text(data.msg);
        $('#friend_alert').fadeOut(2000);

        if (data.success) {
            // appendFriend(myId, forkId, data.avatar, data.name);
            setTimeout(function () {
                window.location = '/relax/public/my/friend';
            },2000);
        }
    };
    $.ajax({
        type: 'POST',
        url: '/relax/public/ajax/fork',
        data: {
            'userId': myId,
            'friendId': forkId
        },
        dataType: 'json',
        success: success,
        error: function (xhr, type) {
            alert('Ajax error!')
        }
    });
}


/**
 * 关注热门用户
 */
function forkHotUser(myId, forkId) {
    //alert(myId+" "+forkId);
    var success = function (data) {
        if (data.msg == '关注成功!') {
            $('#hotUser_alert').removeClass('alert-warning');
            $('#hotUser_alert').addClass('alert-success');
        }
        else {
            $('#hotUser_alert').removeClass('alert-success');
            $('#hotUser_alert').addClass('alert-warning');
        }
        $('#hotUser_alert').show();
        $('#hotUser_alert').text(data.msg);
        $('#hotUser_alert').fadeOut(2000);
    };
    $.ajax({
        type: 'POST',
        url: '/relax/public/ajax/fork',
        data: {
            'userId': myId,
            'friendId': forkId
        },
        dataType: 'json',
        success: success,
        error: function (xhr, type) {
            alert('Ajax error!')
        }
    });
}

/**
 * 图片
 */
function forkIn(img) {
    $(img).attr('src', '/relax/public/static/images/my/hot/fork1.png');
}

function forkOut(img) {
    $(img).attr('src', '/relax/public/static/images/my/hot/fork.png');

}

