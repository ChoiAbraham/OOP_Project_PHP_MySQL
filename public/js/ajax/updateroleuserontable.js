//Change role of a user on Admin interface - Js - php - Ajax call
//in userstable.html.twig

$(document).ready(function () {
    $('.rownumber').each(function(i){

        var y = i + 1;
        $("#setroleuser" + y).on('click', function () {

            var radioValue1 = $("#adminchecked"+y+":checked"). val();
            var radioValue2 = $("#userchecked"+y+":checked"). val();
            var token = $("#token" + y). val();
            if (radioValue1 == 'on') {
                var rolechoosen = 'admin';
            } else if (radioValue2 == 'on') {
                var rolechoosen = 'user';
            }

            var userid = $('#userid'+y).val();
            //for the next ${shadow}
            var shadow = "shadow" + y;

            $.ajax(
                {
                    url: '/ajax/updaterole',
                    method : 'POST',
                    data: {
                        userid: userid,
                        token: token,
                        rolechoosen: rolechoosen
                    },
                    success: function (response) {

                        if(response === 'successadmin') {
                            var newuserblock = `<td id=${shadow}>admin</td>`;
                            $('#shadow'+y).after(newuserblock);
                            $("#shadow"+y).remove();
                        }
                        else if(response === 'successuser') {
                            var newuserblock = `<td id=${shadow}>user</td>`;
                            $('#shadow'+y).after(newuserblock);
                            $("#shadow"+y).remove();
                        }
                        // $("#response").html(response);

                    },
                    dataType: 'text'
                }
            )
        });
    });
});
