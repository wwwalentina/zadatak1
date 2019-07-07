$(document).ready(function () {

    $("#submitButton").click(function () {
//                 var article = new Object();  
//                 article.articleTitle = $('#articleTitle').val();  
//                 article.articleBody = $('#articleBody').val();
//        var data = {
//            articleTitle: $("#articleTitle").val(),
//            articleBody: $("#articleBody").val()
//        };
        var articleTitle = $("#articleTitle").val();
        var articleBody = $("#articleBody").val();
//    alert('caoooo');
        alert(articleTitle);
        $.ajax({
            url: "<?php echo site_url(); ?>/User/createArticle",
//            type: 'POST',
//            contentType: "application/json; charset=utf-8",
//            dataType: 'json',
//            data: JSON.stringify({data}),  
//            success: function (data) {
//                console.log('aaaaaaaaaaaaaaaaaaaaa');
//                console.log(typeof (data));
//                console.log(data);
//            },
//            error: function (xhr, textStatus, errorThrown) {
//                console.log('Error in Operation');
//            }
        });
    });
});


