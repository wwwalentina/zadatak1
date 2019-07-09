</div>
</div>
<script>

    const isValidElement = element => {
        return element.name && element.value;
    };


    const formToJSON = elements => [].reduce.call(elements, (data, element) => {

            if (isValidElement(element)) {
                data[element.name] = element.value;
            }

            return data;
        }, {});



    const handleFormSubmit = event => {

        // Stop the form from submitting since we’re handling that with AJAX.
        event.preventDefault();

        // Call our function to get the form data.
        const data = formToJSON(form.elements);
        // Demo only: print the form data onscreen as a formatted JSON object.
        const dataContainer = document.getElementsByClassName('resultsDisplay')[0];

        dataContainer.textContent = JSON.stringify(data, null, "  ");

        var jsonData = dataContainer.textContent;

        alert(jsonData);

        $.ajax({
            url: "<?php echo site_url(); ?>/User/createArticle",
            type: 'POST',
            contentType: "application/json; charset=utf-8",
            dataType: 'json',
            data: jsonData,
            success: function (data) {
                alert(data);
                console.log('aaaaaaaaaaaaaaaaaaaaa');
                console.log(typeof (data));
                console.log(data.length);
                console.log(data);
                for (i = 0; i < data.length; i++) {
                    var articleTitleFromDatabase = data[i]['title'];
                    var articleBodyFromDatabase = data[i]['body'];
                    var articleImageFromDatabase = data[i]['image'];
                    document.getElementById('articleResult').innerHTML = "This is title: " + articleTitleFromDatabase + "<br>This is article body: " + articleBodyFromDatabase + "<br>This is article image: " + articleImageFromDatabase;
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                console.log(xhr);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });

    };


    var form = document.getElementsByClassName('articleForm')[0];
    if (form)
        form.addEventListener('submit', handleFormSubmit);



    function readFile() {

        if (this.files && this.files[0]) {

            var FR = new FileReader();

            FR.addEventListener("load", function (e) {
                document.getElementById("img").src = e.target.result;
                document.getElementById("imgOutput").value = e.target.result;
            });

            FR.readAsDataURL(this.files[0]);
        }

    }


    var inImg = document.getElementById("inputImage");
    if (inImg) {
        inImg.addEventListener("change", readFile);
    }

    $.ajax({
        url: "<?php echo site_url(); ?>/User/listArticles",
        type: 'GET',
        dataType: 'json',
        success: function (data2) {

            console.log(data2);

            for (var i = 0; i < data2.length; i++) {

                var singleArticleId = data2[i]["id"];
                var singleArticleTitle = data2[i]["title"];
                var singleArticleBody = data2[i]["body"];
                var singleArticleImage = data2[i]["image"];

                if (goesInHtmlListArticles == undefined) {
                    var goesInHtmlListArticles = "" + "<div class='singleListArticleDiv'><a href='<?php echo site_url(); ?>/User/loadFullArticle/" + singleArticleId + "' id='" + singleArticleId + "'><h>" + singleArticleTitle + "</h>" + "<p>" + singleArticleBody + "</p></a></div>";
                } else {
                    var goesInHtmlListArticles = goesInHtmlListArticles + "<div class='singleListArticleDiv'><a href='<?php echo site_url(); ?>/User/loadFullArticle/" + singleArticleId + "' id='" + singleArticleId + "'><h>" + singleArticleTitle + "</h>" + "<p>" + singleArticleBody + "</p></a></div>";
                }

                if (goesInHtmlDeleteArticle == undefined) {
                    var goesInHtmlDeleteArticle = "" + "<div class='singleListArticleDiv'><h>" + singleArticleTitle + "</h>" + "<p>" + singleArticleBody + "</p></a><button class='deleteButton' value='"+singleArticleId+"' id='"+singleArticleId+"'>Delete article</button></div>";
                } else {
                    var goesInHtmlDeleteArticle = goesInHtmlDeleteArticle + "<div class='singleListArticleDiv'><h>" + singleArticleTitle + "</h>" + "<p>" + singleArticleBody + "</p></a><button class='deleteButton' value='"+singleArticleId+"' id='"+singleArticleId+"'>Delete article</button></div>";
                }

                if (goesInHtmlUpdateArticle == undefined) {
                    var goesInHtmlUpdateArticle = "" + "<div class='singleListArticleDiv'><a href='<?php echo site_url(); ?>/User/loadFullArticleUpdate/" + singleArticleId + "' id='" + singleArticleId + "'><h>" + singleArticleTitle + "</h>" + "<p>" + singleArticleBody + "</p></a><button>Update article</button></div>";
                } else {
                    var goesInHtmlUpdateArticle = goesInHtmlUpdateArticle + "<div class='singleListArticleDiv'><a href='<?php echo site_url(); ?>/User/loadFullArticleUpdate/" + singleArticleId + "' id='" + singleArticleId + "'><h>" + singleArticleTitle + "</h>" + "<p>" + singleArticleBody + "</p></a><button>Update article</button></div>";
                }

                var currentPage = window.location.href;

                if (currentPage == "<?php echo site_url(); ?>/User/loadListArticles") {
                    document.getElementById('divListArticles').innerHTML = goesInHtmlListArticles;
                } else if (currentPage == "<?php echo site_url(); ?>/User/loadDeleteArticle") {
                    document.getElementById('divDeleteArticle').innerHTML = goesInHtmlDeleteArticle;
                } else if (currentPage == "<?php echo site_url(); ?>/User/loadUpdateArticle") {
                    document.getElementById('divUpdateArticle').innerHTML = goesInHtmlUpdateArticle;
                }

                if (currentPage.substring(currentPage.lastIndexOf('/') + 1) == singleArticleId) {
                    var showFullArticle = "<div><img src='" + singleArticleImage + "'></div><div><h1>" + singleArticleTitle + "</h1>" + singleArticleBody + "</div>";
                    var showFullArticleInInputFields = "<form name='formUpdate' id='formUpdate'><input type='text' name='articleTitleUpdate' id='articleTitleUpdate' size='59' value='" + singleArticleTitle + "'><br><textarea name='articleBodyUpdate' rows='25' id='articleBodyUpdate' cols='60'>" + singleArticleBody + "</textarea><br><output name='articlePictureUpdate' id=imgOutput'></output><br><input type='submit' name='submit' value='Submit'></form>"
                    var pathArray = window.location.pathname.split('/');
                    var pathArrayLocation = pathArray[4];
                    if (pathArrayLocation == "loadFullArticle") {
                        document.getElementById("fullSingleArticle").innerHTML = showFullArticle;
                    } else {
                        document.getElementById("fullSingleArticleUpdateDiv").innerHTML = showFullArticleInInputFields;
                    }
                }

            }

        },
        error: function (xhr, textStatus, errorThrown) {
            console.log(xhr);
            console.log(textStatus);
            console.log(errorThrown);
        }
    });

//
    var postForm = $('#formUpdate');

    var jsonData = function (form) {
        var arrData = form.serializeArray(),
                objData = {};

        $.each(arrData, function (index, elem) {
            objData[elem.name] = elem.value;
        });

        return JSON.stringify(objData);
    };

    $('body').on('submit', '#formUpdate', function (e) {

        e.preventDefault();
        alert('jejejejeeeeeeeeeeeeeeeeeeej');
        $.ajax({
            url: "<?php echo site_url(); ?>/User/updateArticle",
            method: 'POST',
            data: jsonData(postForm),
            crossDomain: true,
            contentType: 'application/json; charset=utf-8',
            success: function (data) {
                console.log(data);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });


     $('body').on('click','.deleteButton', function () {
             alert('woowowo');
        var url_id = $(this).val();
        alert(url_id);
        $.ajax({
            url: '<?php echo site_url(); ?>/User/deleteArticle/'+url_id,
            type: 'DELETE',
            success: function (result) {
                console.log(result);
               
            }
        });

    });




</script>
</body>
</html>

