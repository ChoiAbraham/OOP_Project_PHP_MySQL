//change comment Valid - Js - php - Ajax call
//in onearticle.html.twig

$(document).ready(function () {
    $('.rownumber').each(function(i){
        var y = i + 1;
        $("#customSwitch" + y).on('click', function () {

            var switchvalue = $("#customSwitch"+y+":checked"). val();

            if (switchvalue == 'on') {
                var validation = 1;
            } else {
                var validation = 0;
            }

            var commentid = $('#commentid'+y).val();
            console.log(commentid);

            var ajaxmethod = 'changeCommentValid';

            $.ajax(
                {
                    url: 'data.php',
                    method : 'POST',
                    data: {
                        ajaxmethod: ajaxmethod,
                        commentid: commentid,
                        validation: validation
                    },
                    success: function (response) {
                        if(response === 'success') {
                            // $("#response").html(response);
                        }

                    },
                    dataType: 'text'
                }
            )
    });
});
        });

