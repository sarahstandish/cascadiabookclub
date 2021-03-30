<?php

include 'includes/server.php';
include 'includes/header.php';
if (isset($_GET['id']) && $_GET['id'] <= get_table_length('books', $db)) {
    $id = (int)$_GET['id'];
    list($title, $author, $year_published, $setting, $about, $category, $url) = get_book($id, $db);
    display_header($title);
} else {
    header('Location:books.php');
}

?>
<h2><?php echo $title; ?></h2>

<div class="main">
    <div class='book-view-cover'>
        <?php echo display_image($id, $title); ?>
    </div>
    <div class="book-info">
        <p><span class="info-type">Author:</span> <?php echo $author; ?></p>
        <p><span class="info-type">Year published:</span> <?php echo $year_published; ?></p>
        <p><span class="info-type">Setting:</span> <?php echo $setting; ?></p>
        <p><span class="info-type">Synopsis:</span> <?php echo $about; ?></p>
        <p><span class="info-type"><a href='<?php echo $url; ?>'>Read reviews on Goodreads</a></span></p>
    </div>
</div>
<?php 

//close the connection
mysqli_close($db);
include 'includes/footer.php';
?>