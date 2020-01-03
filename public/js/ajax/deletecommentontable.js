//delete comment - Js - php - Ajax call
//in onearticle.html.twig

$(document).ready(function () {
    $('.rownumber').each(function(i){

        var y = i + 1;
        $("#deletecomment" + y).on('click', function () {
            var commentid = $('#commentid'+y).val();

            var ajaxmethod = 'deleteComment';

            $.ajax(
                {
                    url: 'data.php',
                    method : 'POST',
                    data: {
                        ajaxmethod: ajaxmethod,
                        commentid: commentid,
                    },
                    success: function (response) {

                        if(response === 'successcommentdelete') {
                            $("#shadowdelete"+y).remove();
                            $("#response").html('This Comment has been deleted successfully');
                        }

                    },
                    dataType: 'text'
                }
            )
        });
    });
});
