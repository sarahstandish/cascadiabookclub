<?php
include 'includes/server.php';
include 'includes/header.php';
display_header('Cascadia Book Club');

//choose a random number from available table ids, using 1 as min and table length as max
$id = rand(1, get_table_length('books', $db));

list($title, $author, $year_published, $setting, $about, $category, $url) = get_book($id, $db);

?>
<div class="main">
    <div class="front-page">
        <img id='flag' src='/it261/cascadiabookclub/images/cascadia_flag.png' alt='Cascadia Flag'>
        <h2>Learn more about the Pacific Northwest through books</h2>
        <p class="about">
            We don't all know the history of the region we live in--but what better way to learn about it than through the Cascadia region's acclaimed authors? Start your own Cascadia Book Club branch and explore the rich history and culture of Cascadia with your friends.
        </p>
        <p class="about">
            Whether you live in Oregon, Washington, British Columbia, or Idaho, you'll deepen your understanding of local history and form stronger a bond with friends.
        </p>
    </div>
    <aside>
        <h2>Start Reading</h2>
        <div class='book-cover'>
            <a href="/it261/cascadiabookclub/book-view.php?id=<?php echo $id ?>">
                <?php echo display_image($id, $title); ?>
            </a>
        </div>
    </aside>
</div>
<?php
mysqli_close($db);
include 'includes/footer.php';
?>