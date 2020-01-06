//deletepost Js - php - Ajax call
//deletepost in post/mypost.html.twig

$(document).ready(function () {
    $("#deletepost").on('click', function () {
        var postid = $("#postid").val();
        var shadow = $("#shadow").val();

        $.ajax(
            {
                url: '/ajax/deletepost',
                method : 'POST',
                data: {
                    postid: postid,
                },
                success: function (response) {

                    if(response) {
                        $("."+shadow).remove();
                    }

                    $("#response").html(response);

                },
                dataType: 'text'
            }
        )
    });
});
