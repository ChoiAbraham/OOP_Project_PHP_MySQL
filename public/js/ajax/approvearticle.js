//approve an Article - Js - php - Ajax call
//in onearticle.html.twig

$(document).ready(function () {
    $("#approvearticle").on('click', function () {
        var postid = $('#postid').val();
        var shadow = $("#shadow").val();

        $.ajax(
            {
                url: '/ajax/approve',
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
