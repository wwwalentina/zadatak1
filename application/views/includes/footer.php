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
                    var goesInHtmlListArticles = "" + "<div class='singleListArticleDiv'><a href='<?php echo site_url(); ?>/User/loadFullArticle/" + singleArticleId + "' id='" + singleArticleId + "'><h class='singleArticleTitleInList'>" + singleArticleTitle + "</h>" + "<p>" + singleArticleBody + "</p></a></div><br>";
                } else {
                    var goesInHtmlListArticles = goesInHtmlListArticles + "<div class='singleListArticleDiv'><a href='<?php echo site_url(); ?>/User/loadFullArticle/" + singleArticleId + "' id='" + singleArticleId + "'><h class='singleArticleTitleInList'>" + singleArticleTitle + "</h>" + "<p>" + singleArticleBody + "</p></a></div><br>";
                }



                var currentPage = window.location.href;

                if (currentPage == "<?php echo site_url(); ?>/User/loadListArticles") {
                    document.getElementById('divListArticles').innerHTML = goesInHtmlListArticles;
                }

                if (currentPage.substring(currentPage.lastIndexOf('/') + 1) == singleArticleId) {
                    var showFullArticle = "<div><img src='" + singleArticleImage + "'></div><div><h1 class='singleArticleTitle'>" + singleArticleTitle + "</h1>" + singleArticleBody + "</div>";
                    var pathArray = window.location.pathname.split('/');
                    var pathArrayLocation = pathArray[4];
                    if (pathArrayLocation == "loadFullArticle") {
                        document.getElementById("fullSingleArticle").innerHTML = showFullArticle;
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

    //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        
    // _________________________________jsonData FUNCTION__________________

    var jsonData = function (form) {

        var arrData = form.serializeArray(),
                objData = {};

        $.each(arrData, function (index, elem) {
            objData[elem.name] = elem.value;
        });

        var jsonStringifyData = JSON.stringify(objData);

        return jsonStringifyData;
    };

    $.ajax({
        url: "<?php echo site_url(); ?>/User/getArticlesForLogedUsers",
        type: 'GET',
        dataType: 'json',
        success: function (data3) {

            console.log(data3);

            for (var i = 0; i < data3.length; i++) {
                var singleArticleIdOfLogedUser = data3[i]["id"];
                var singleArticleTitleOfLogedUser = data3[i]["title"];
                var singleArticleBodyOfLogedUser = data3[i]["body"];
                var singleArticleImageOfLogedUser = data3[i]["image"];
                var singleArticleAuthorIdOfLogedUser = data3[i]["authorId"];
                

                if (goesInHtmlDeleteArticle == undefined) {
                    var goesInHtmlDeleteArticle = "" + "<div class='singleListArticleDiv'><button class='deleteButton' value='" + singleArticleIdOfLogedUser + "' id='" + singleArticleIdOfLogedUser + "'>Delete article</button><br><h class='singleArticleTitleInList'>" + singleArticleTitleOfLogedUser + "</h>" + "<p>" + singleArticleBodyOfLogedUser + "</p></a></div><br>";
                } else {
                    var goesInHtmlDeleteArticle = goesInHtmlDeleteArticle + "<div class='singleListArticleDiv'><button class='deleteButton' value='" + singleArticleIdOfLogedUser + "' id='" + singleArticleIdOfLogedUser + "'>Delete article</button><br><h class='singleArticleTitleInList'>" + singleArticleTitleOfLogedUser + "</h>" + "<p>" + singleArticleBodyOfLogedUser + "</p></a></div><br>";
                }

                if (goesInHtmlUpdateArticle == undefined) {
                    var goesInHtmlUpdateArticle = "" + "<div class='singleListArticleDiv'><a href='<?php echo site_url(); ?>/User/loadFullArticleUpdate/" + singleArticleIdOfLogedUser + "' id='" + singleArticleIdOfLogedUser + "'><h class='singleArticleTitleInList'>" + singleArticleTitleOfLogedUser + "</h>" + "<p>" + singleArticleBodyOfLogedUser + "</p></a></div><br>";
                } else {
                    var goesInHtmlUpdateArticle = goesInHtmlUpdateArticle + "<div class='singleListArticleDiv'><a href='<?php echo site_url(); ?>/User/loadFullArticleUpdate/" + singleArticleIdOfLogedUser + "' id='" + singleArticleIdOfLogedUser + "'><h class='singleArticleTitleInList'>" + singleArticleTitleOfLogedUser + "</h>" + "<p>" + singleArticleBodyOfLogedUser + "</p></a></div><br>";
                }
                
                var currentPage = window.location.href;


                if (currentPage == "<?php echo site_url(); ?>/User/loadDeleteArticle") {
                    document.getElementById('divDeleteArticle').innerHTML = goesInHtmlDeleteArticle;
                } else if (currentPage == "<?php echo site_url(); ?>/User/loadUpdateArticle") {
                    document.getElementById('divUpdateArticle').innerHTML = goesInHtmlUpdateArticle;
                }

                if (currentPage.substring(currentPage.lastIndexOf('/') + 1) == singleArticleIdOfLogedUser) {
                    var showFullArticleInInputFields = "<form name='formUpdate' class='formUpdate' id='formUpdate'><input type='hidden' name='articleHiddenUpdate' value='"+singleArticleIdOfLogedUser+"'><input type='text' name='articleTitleUpdate' id='articleTitleUpdate' size='59' value='" + singleArticleTitleOfLogedUser + "'><br><textarea name='articleBodyUpdate' rows='25' id='articleBodyUpdate' cols='60'>" + singleArticleBodyOfLogedUser + "</textarea><br><img id='imgUpdate' height='150'><output name='articlePictureUpdate' id='imgOutputUpdate'></output><input type='file' id='inputImageUpdate'><br><br><input type='submit' name='submit' value='submit'></form>"
                    var pathArray = window.location.pathname.split('/');
                    var pathArrayLocation = pathArray[4];
                    if (pathArrayLocation == "loadFullArticleUpdate") {
                        document.getElementById("fullSingleArticleUpdateDiv").innerHTML = showFullArticleInInputFields;
                    }
                }
                
                
                
                           

                

            }
            
             var postForm = $('#formUpdate');
            
            var inImgUpdate = document.getElementById("inputImageUpdate");
            if (inImgUpdate) {
                inImgUpdate.addEventListener("change", readFileUpdate);
            }



            postForm.on('submit', function (e) {
                e.preventDefault();
//                var url_id = currentPage.substring(currentPage.lastIndexOf('/') + 1);
//                alert(url_id);
                alert(jsonData(postForm));
                $.ajax({
                    url: "<?php echo site_url(); ?>/User/updateArticle",
                    method: 'POST',
                    data: jsonData(postForm),
                    dataType: 'json',
                    contentType: 'application/json; charset=utf-8',
                    success: function (data) {

                        console.log(data);
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });
            

        }
    });

    function readFileUpdate() {

        if (this.files && this.files[0]) {

            var FR = new FileReader();

            FR.addEventListener("load", function (e) {
                document.getElementById("imgUpdate").src = e.target.result;
                document.getElementById("imgOutputUpdate").value = e.target.result;
            });

            FR.readAsDataURL(this.files[0]);
        }

    }

    $('body').on('click', '.deleteButton', function () {
        var url_id = $(this).val();
        $.ajax({
            url: '<?php echo site_url(); ?>/User/deleteArticle/' + url_id,
            type: 'DELETE',
            success: function (result) {
                alert('Article is deleted');
            }
        });

    });




</script>
</body>
</html>

