<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="<?php echo base_url('assets/css/main.css'); ?>" type="text/css" rel="stylesheet" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>
    <body>
        <div id="container">
            <header>
                <ul>
                    <li>
                        <a href="<?php echo site_url('User/logout'); ?>">Logout</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('User/loadCreateArticle'); ?>">Create Article</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('User/loadListArticles'); ?>"> List of articles</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('User/loadDeleteArticle'); ?>">Delete article</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('User/loadUpdateArticle'); ?>">Update article</a>
                    </li>
                </ul>
            </header>
            <div id="mainPart">


