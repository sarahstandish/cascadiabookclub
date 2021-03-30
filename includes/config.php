<?php

ob_start();
include 'credentials.php';
include 'mailchimp.php';

define('DEBUG', 'TRUE');

global $db;

$db = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) or die(myError(__FILE__, __LINE__, mysqli_connect_error()));

function myError($myFile, $myLine, $errorMsg)
{
    if(defined('DEBUG') && DEBUG)
    {
    echo 'Error in file: <b> '.$myFile.' </b> on line: <b> '.$myLine.' </b>';
        echo 'Error message: <b> '.$errorMsg.'</b>';
        die();
    }  else {
        echo ' Houston, we have a problem!';
        die();
    }   
}


function get_book($id, $db) {

    //if the id passed is an int and within the range of table values
    if (is_int($id) && $id <= get_table_length('books', $db)) {
        $result = get_sql_result($db, 'books', 'book_id', $id);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $title = stripslashes($row['title']);
                $author = stripslashes($row['author']);
                $year_published = stripslashes($row['year_published']);
                $setting = stripslashes($row['setting']);
                $about = stripslashes($row['about']);
                $category = stripslashes($row['category']);
                $url = stripslashes($row['url']);
                $feedback = "";
            }
        } else {
            $feedback = "Something went wrong";
        }

        //release the web server
        mysqli_free_result($result);

        if (!empty($feedback)) {
            //values to return if there's an error
            return ["Cascadia's Fault", 'Jerry Thompson', 2012, "Oregon and Washington", "A depressing prediction about the earthquake that will devastate Cascadia.", "Books", "https://www.goodreads.com/book/show/10866111-cascadia-s-fault"];
        } else {
            return [$title, $author, $year_published, $setting, $about, $category, $url];
        }
    } else {
        return ["Cascadia's Fault", 'Jerry Thompson', 2012, "Oregon and Washington", "A depressing prediction about the earthquake that will devastate Cascadia.", "Books", "https://www.goodreads.com/book/show/10866111-cascadia-s-fault"]; 
    }
}

function get_table_length($table_name, $db) {

    $table_name = mysqli_real_escape_string($db, $table_name);

    $result = get_sql_result($db, $table_name);

    $num_rows = mysqli_num_rows($result);

    //release the web server
    mysqli_free_result($result);

    return $num_rows;
}

function get_sql_result($db, $table_name, $column_name="", $column_condition="") {

    $table_name = mysqli_real_escape_string($db, $table_name);
    
    if (!empty($column_name)) {
        $column_name = mysqli_real_escape_string($db, $column_name);
        $column_condition = mysqli_real_escape_string($db, $column_condition);
    }

    if (empty($column_condition)) {
        $query = "SELECT * FROM $table_name";
    } else {
        $query = "SELECT * FROM $table_name WHERE $column_name = '$column_condition'";
    }

    $result = mysqli_query($db, $query) or die(myError(__FILE__, __LINE__, mysqli_error($db)));

    return $result;
}

//contact form checkoxes
function defaultUnchecked($n) {
    if (isset($_POST['regions']) && in_array($n, $_POST['regions'])) {
        return "checked='checked'";
    } else if (isset($_POST['regions']) && !in_array($n, $_POST['regions'])) {
        return "";
    } else {
        return "";
    }
}

//contact form errors
$region_error = "";
$post_array = "";
$first_name_err = "";
$last_name_err = "";
$email_err = "";
$agree_err = "";
$phone_err = "";
$frequency_err = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_contact_form'])) {

    // $post_array = $_POST;
    if (empty($_POST['first_name'])) {
        $first_name_err = "Please enter your first name";
    } else {
        $first_name = $_POST['first_name'];
    }

    if ($_POST['frequency'] == 'NULL') {
        $frequency_err = "Please select an email frequency.";
    }

    if (empty($_POST['last_name'])) {
        $last_name_err = "Please enter your last name";
    } else {
        $last_name = $_POST['last_name'];
    }

    if (empty($_POST['email'])) {
        $email_err = "Please enter your email";
    } else {
        $email = $_POST['email'];
    }

    if (empty($_POST['regions'])) {
        $region_error = "Please select at least once region.";
    } else {
        $regions = implode(",", $_POST['regions']);
    }

    if (empty($_POST['agree'])) {
        $agree_err = "You must agree.";
    } else {
        $agree = $_POST['agree'];
    }

    if (empty($_POST['phone'])) {
        $phone_err = "ERROR!!! Type in your phone number.";
    } else if (array_key_exists('phone', $_POST)) {

        if (!preg_match('/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/', $_POST['phone'])) {
            $phone_err = "Phone must be xxx-xxx-xxxx";
        } else {
            $phone = $_POST['phone'];
        }
        
    } else {
        $phone_err = "Nothing happened.";
    }

    if (isset($_POST['first_name'],
                $_POST['last_name'],
                $_POST['email'],
                $_POST['phone'],
                $_POST['agree']) 
                && !empty($_POST['regions'])
                && $_POST['frequency'] != 'NULL'
                ) {

        add_subscriber($_POST['email'], $_POST['first_name'], $_POST['last_name']);
        add_tag($_POST['email'], $_POST['regions']);

        $your_regions = "Your regions of interest:\n " . implode(" \n ", $_POST['regions']);

        $to = 'szemeo@mystudentswa.com';
        date_default_timezone_set('America/Los_Angeles');
        $subject = "Test email " . date('m/d/y h:i:s A');
        $body = "Hello {$_POST['first_name']} {$_POST['last_name']},\n Your email is {$_POST['email']}.\n Your phone number is {$_POST['phone']}.\n You're interested in the regions: $your_regions. \nYou're want to be updated {$_POST['frequency']}. \n Email sent from sarahstandish.com - contact form.";
        $headers = [
            'From' => 'no-reply@sarahstandish.com',
            'Reply-to' => 'standish.sm@gmail.com',
        ];

        mail($to, $subject, $body, $headers);
        echo "Your form has been received.";
        header('Location:/it261/cascadiabookclub/thanks.php');

    }
}

function display_image($id, $title) {

    return "<img src='/it261/cascadiabookclub/images/book$id.jpg' alt='$title'>";
}

// switch

$days = [
    'sunday' => [
        'day_name' => 'Sunday',
        'id' => 1,
    ],
    'monday' => [
        'day_name' => 'Monday',
        'id' => 2,
    ],
    'tuesday' => [
        'day_name' => 'Tuesday',
        'id' => 3,
    ],
    'wednesday' => [
        'day_name' => 'Wednesday',
        'id' => 4,
    ],
    'thursday' => [
        'day_name' => 'Thursday',
        'id' => 5,
    ],
    'friday' => [
        'day_name' => 'Friday',
        'id' => 6,
    ],
    'saturday' => [
        'day_name' => 'Saturday',
        'id' => 7,
    ],
];

//gallery
$maps = [
    'cascadia_as_states.png' => "Some define Cascadia primarily through political boundaries, edged by the borders of Oregon, Washington, and British Columbia.",
    'cascadia_as_the_northwest_of_north_america.png' => "Some believe that Cascadia covers the entire Pacfic Northwest of the North American contintent.",
    'mcLoskey_map_of_2015.png' => "One of the most detailed and most beautiful maps of Cascadia, the <a href='http://www.marshamccloskey.com/cascadiamap.html'>McLoskey Map of Cascadia</a> imagines Cascadia as a bioregion defined by natural plateaus and watersheds that create the distinct ecosystems of the Northwest.",
    'western_temperate_rainforests.jpg' => "Others take a narrower view, believing that Cascadia should be defined only by the temperate rainforests that cover the land from the ocean to the Cascade mountains."
    ];

//login redirection

function check_login() {

    if (!isset($_SESSION['UserName'])) {
        $_SESSION['msg'] = "You must log in first.";
        header('Location:/it261/cascadiabookclub/login.php');
    }
    
    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['UserName']);
        header('Location:/it261/cascadiabookclub/login.php');
    }
    if (isset($_SESSION['Success'])) :?>
        <div class='success'>
        <h3><?php echo $_SESSION['Success'];
            unset($_SESSION['Success']); ?></h3>
        </div>
        <?php endif;
    
    if (isset($_SESSION['UserName'])) :?>
        <div class="welcome-logout">
            <span class="greeting"><?php echo "Hello, {$_SESSION['UserName']}"; ?></span>
            <a class='logout-button' href="/it261/cascadiabookclub/index.php?logout='1'">Logout</a>
        </div>
        <?php endif;
}


?>