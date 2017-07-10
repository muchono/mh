$(document).ready(function() {
	init();
});

function init()
{
    $('#blog_subscribe').on('click', function(e){
        e.preventDefault();
        subscribe($('#blog_subscribe_input').val(), subscriberBlogRes);
    });    
}

function subscribe(email, callback)
{
    var data = 'email='+email;
    $.ajax({
        type: 'POST',
        url: '?r=blog/subscribe',
        data: data,
        success:function(data){
                callback(data);
        },
        error: function(data) { // if error occured
            alert("Error occured. Please try again");
        },
        dataType:'json'
    });
}

function subscriberBlogRes(res)
{
    if (res.errors) {
        $('#blog_subscribe_errors').html(res.errors);
    } else {
        $('#blog_subscribe_errors').removeClass('error-message');
        $('#blog_subscribe_errors').addClass('success-message text-center');
        $('#blog_subscribe').hide();
        $('#blog_subscribe_errors').html('Subscribed');
    }
}