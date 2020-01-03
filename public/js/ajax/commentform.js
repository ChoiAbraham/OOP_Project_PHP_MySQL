//CommentForm Js - php - Ajax call
//Create a comment in  : comment.html.twig

$(document).ready(function () {
    $("#commentpost").on('click', function () {
        var content = $("#commentuser").val();
        var postid = $("#postid").val();
        // var shadow = $("#shadow").val();
        var userid = $("#userId").val();
        var ajaxmethod = 'createComment';

        if(content == "")
            alert('Please check your inputs');
        else {
            $.ajax(
                {
                    url: 'data.php',
                    method : 'POST',
                    data: {
                        submitbutton: 1,
                        ajaxmethod: ajaxmethod,
                        userid: userid,
                        postid: postid,
                        contentPHP: content
                    },
                    success: function (response) {

                        if(response == 'CommentSuccess') {
                            $("#commentuser").val('');
                            var responsesuccess = '<p>Your Comment is being reviewed and will be confirmed by admin</p>';
                            $("#response").after(responsesuccess);
                        }
                    },
                    dataType: 'text'
                }
            )
        }
    });

});
