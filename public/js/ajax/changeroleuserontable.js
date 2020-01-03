//Change role of a user on Admin interface - Js - php - Ajax call
//in userstable.html.twig

$(document).ready(function () {
    $('.rownumber').each(function(i){

        var y = i + 1;
        console.log(y);
        $("#setroleuser" + y).on('click', function () {

            var radioValue1 = $("#adminchecked"+y+":checked"). val();
            var radioValue2 = $("#userchecked"+y+":checked"). val();

            if (radioValue1 == 'on') {
                var rolechoosen = 'admin';
            } else if (radioValue2 == 'on') {
                var rolechoosen = 'user';
            }

            var userid = $('#userid'+y).val();

            var ajaxmethod = 'updateRole';

            $.ajax(
                {
                    url: 'data.php',
                    method : 'POST',
                    data: {
                        ajaxmethod: ajaxmethod,
                        userid: userid,
                        rolechoosen: rolechoosen
                    },
                    success: function (response) {

                        if(response === 'successadmin') {
                            var newuserblock = '<td>admin</td>';
                            $('#shadow'+y).after(newuserblock);
                            $("#shadow"+y).remove();
                        }
                        else if(response === 'successuser') {
                            var newuserblock = '<td>user</td>';
                            $('#shadow'+y).after(newuserblock);
                            $("#shadow"+y).remove();
                        }
                    },
                    dataType: 'text'
                }
            )
        });
    });
});
