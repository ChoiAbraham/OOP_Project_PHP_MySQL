//deletepost Js - php - Ajax call
//deletepost in post/mypost.html.twig

$(document).ready(function () {
    $("#deletepost").on('click', function () {
        var postid = $("#postid").val();
        var shadow = $("#shadow").val();
        var ajaxmethod = 'deletePost';

        $.ajax(
            {
                url: 'data.php',
                method : 'POST',
                data: {
                    ajaxmethod: ajaxmethod,
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
