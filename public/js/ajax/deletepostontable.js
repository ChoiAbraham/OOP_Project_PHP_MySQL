//Delete Post an Article - Js - php - Ajax call
//in articles.html.twig

$(document).ready(function () {
    $('.rownumber').each(function(i){

        var y = i + 1;
        $("#deletepost" + y).on('click', function () {
            var postid = $('#postid'+y).val();

            $.ajax(
                {
                    url: '/ajax/deletepost',
                    method : 'POST',
                    data: {
                        postid: postid,
                    },
                    success: function (response) {

                        if(response) {
                            $("#shadow"+y).remove();
                        }

                        $("#response").html(response);

                    },
                    dataType: 'text'
                }
            )
        });
    });
});
