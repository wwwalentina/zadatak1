<!DOCTYPE html>
<html>
    <head>
        <title></title>
    </head>
    <body>
        <div id="container">
           
            <form action="<?php echo site_url("Guest/login"); ?>" method="POST">
                <input type="text" name="username" placeholder="Username" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <button type="submit">Login</button>
            </form>
            
            <?php if(isset($msg)) {
                echo $msg;
            } ?>
        </div>
    </body>
