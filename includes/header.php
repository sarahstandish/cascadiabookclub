<?php
function display_header($title) {
    $nav2 = [
        "Home" => '/it261/cascadiabookclub/index.php',
        "About" => '/it261/cascadiabookclub/about.php',
        "Gallery" => '/it261/cascadiabookclub/gallery.php',
        "Contact" => '/it261/cascadiabookclub/contact.php',
        "Daily" => '/it261/cascadiabookclub/daily.php',
        "Books" => '/it261/cascadiabookclub/books.php'
    ];
    echo
    "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <title>$title</title>
        <link href='/it261/cascadiabookclub/css/styles.css' type='text/css' rel='stylesheet'>
        <link href='/it261/cascadiabookclub/css/small-screen-styles.css' type='text/css' rel='stylesheet'>
        <meta content='width=device-width, initial-scale=1' name='viewport' />
        <link rel='preconnect' href='https://fonts.gstatic.com'>
        <link href='https://fonts.googleapis.com/css2?family=Montserrat&family=Syne:wght@400;500&display=swap' rel='stylesheet'> 
    </head>
    <body>";
    if (($_SERVER['PHP_SELF'] != '/it261/cascadiabookclub/login.php') && ($_SERVER['PHP_SELF'] != '/it261/cascadiabookclub/register.php')) {
        check_login();
    };
    echo   "<nav>";
            foreach($nav2 as $name => $url) {
                if ('THIS_PAGE' == $url) {
                    echo "<div class='dropdown-container nav-button'><a class='home-active' href='$url'>$name</a></div>";
                } else {
                    echo "<div class='dropdown-container nav-button'><a href='$url'>$name</a></div>";
                }
            }
        echo "</nav>
        <header>
                    <h1>Cascadia Book Club</h1>
        </header>";
}



?>