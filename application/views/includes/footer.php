</div>
</div>
<!--        <script src="<?php // echo base_url('assets/js/main.js');     ?>"></script>-->
<script>
//    $(document).ready(function () {
//
//        $("#postArticleButton").click(function () {
////                 var article = new Object();  
////                 article.articleTitle = $('#articleTitle').val();  
////                 article.articleBody = $('#articleBody').val();
////        var data = {
////            articleTitle: $("#articleTitle").val(),
////            articleBody: $("#articleBody").val()
////        };
//            var articleTitle = $("#articleTitle").val();
//            var jsonData = JSON.stringify(articleTitle);
////        var articleBody = $("#articleBody").val();
////            alert(articleTitle);
//            $.ajax({
//                url: "<?php //echo site_url();    ?>/User/createArticle",
//                type: 'POST',
//                contentType: "application/json; charset=utf-8",
//                dataType: 'json',
//                data: { jsonData },
//                success: function (data) {
//                    alert(data);
//                    console.log('aaaaaaaaaaaaaaaaaaaaa');
//                    console.log(typeof (data));
//                    console.log(data);
//                },
//                error: function (xhr, textStatus, errorThrown) {
//                    console.log(xhr);
//                    console.log(textStatus);
//                    console.log(errorThrown);
//                }
//            });
//        });
//    });

//function convertToDataURLviaCanvas(url, callback, outputFormat){
//    var img = new Image();
//    img.crossOrigin = 'Anonymous';
//    img.onload = function(){
//        var canvas = document.createElement('CANVAS');
//        var ctx = canvas.getContext('2d');
//        var dataURL;
//        canvas.height = this.height;
//        canvas.width = this.width;
//        ctx.drawImage(this, 0, 0);
//        dataURL = canvas.toDataURL(outputFormat);
//        callback(dataURL);
//        canvas = null; 
//    };
//    img.src = url;
//}

    const isValidElement = element => {
        return element.name && element.value;
    };


    const formToJSON = elements => [].reduce.call(elements, (data, element) => {

            // Make sure the element has the required properties.
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

        // Use `JSON.stringify()` to make the output valid, human-readable JSON.
        dataContainer.textContent = JSON.stringify(data, null, "  ");

        var jsonData = dataContainer.textContent;

        // ...this is where we’d actually do something with the form data...
//        var parsedData = JSON.parse(jsonData);




//        alert(typeof (parsedData));
        alert(jsonData);

// data bez {} je ulazila u bazu
        $.ajax({
            url: "<?php echo site_url(); ?>/User/createArticle",
            type: 'POST',
            contentType: "application/json; charset=utf-8",
            dataType: 'json',
            data:  jsonData,
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
//                    alert(data);
//                    console.log('bbbbbb');
//                    console.log(typeof (data));
//                    console.log(data.length);
                var decoded = JSON.parse(data2);
                for (i = 0; i < decoded.length; i++) {
                    var articleTitleFromDatabase = decoded[i]['title'];
                    var articleBodyFromDatabase = decoded[i]['body'];
//                        var articleImageFromDatabase = decoded[i]['image'];
//                    document.getElementById('article').innerHTML = "This is title: " + articleTitleFromDatabase + "<br>This is article body: " + articleBodyFromDatabase;
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                console.log(xhr);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });




</script>
</body>
</html>

