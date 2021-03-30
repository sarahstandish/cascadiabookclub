<?php
include 'includes/server.php';
include 'includes/header.php';
display_header('Gallery');
?>
<h2>Maps of Cascadia</h2>
<div class="main about">
    <p>What is Cascadia, exactly? Everyone agrees that the region includes parts of Oregon, Washington, and British Columbia, but there's disagreement over how far the borders extend. Some include parts of Idaho, Alaska, or Northern California as well.</p>
    <p>The definition of Cascadia may ultimately be a personal one, depending on whether one sees access to lush forests, proximity to a waterway that feeds into the Colubmia, state residency, or the liberal politics of major urban centers as the most salient feature of the region.</p>
</div>
<?php  
foreach ($maps as $filename => $description) {
    $map_name = ucwords(substr(str_replace("_", " ", $filename), 0, -4));
    ?>
    <div class="main">
        <div class='map-description'>
            <p class='map-name'><?php echo $map_name ?></p>
            <p><?php echo $description ?></p>
        </div>
        <div class="map"><img src="/it261/cascadiabookclub/images/<?php echo $filename ?>"></div>
    </div>
<?php
}
include 'includes/footer.php';
?>