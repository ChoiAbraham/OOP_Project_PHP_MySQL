//approve an Article - Js - php - Ajax call
//in articles.html.twig

$(document).ready(function () {
    $('.rownumber').each(function(i){

        var y = i + 1;
        $("#approvearticle" + y).on('click', function () {
            var postid = $('#postid'+y).val();

        $.ajax(
            {
                url: '/ajax/approve',
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
