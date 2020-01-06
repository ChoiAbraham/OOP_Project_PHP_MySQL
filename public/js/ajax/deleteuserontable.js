//Change role of a user on Admin interface - Js - php - Ajax call
//in userstable.html.twig

$(document).ready(function () {
    $('.rownumber').each(function(i){

        var y = i + 1;
        $("#deleteuser" + y).on('click', function () {
            var userid = $('#userid'+y).val();

            $.ajax(
                {
                    url: '/ajax/deleteuser',
                    method : 'POST',
                    data: {
                        userid: userid,
                    },
                    success: function (response) {

                        if(response === 'successdelete') {
                            $("#shadowdelete"+y).remove();
                            $("#shadowdeletenext"+y).remove();
                            $("#response").html('This user has been deleted successfully');
                        }

                    },
                    dataType: 'text'
                }
            )
        });
    });
});
