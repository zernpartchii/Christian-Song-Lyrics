<?php

$artist = mysqli_escape_string($con, $artist);
$condition = "WHERE sa.artist='$artist'";
$result = fetchSongs($con, $condition);

if (mysqli_num_rows($result) > 0) {
    $index = 0;
    while ($row = mysqli_fetch_assoc($result)) {
?>
        <div class="song-item flex-fill mb-2">
            <a href="lyrics.php?id=<?php echo $row['id']; ?>"
                class="d-flex gap-3 text-white text-decoration-none btn btn-dark flex-fill">
                <i class="bi-music-note fs-1"></i>
                <div class="text-start mx-3">
                    <p class="text-capitalize title h6"><?php echo ($index += 1) . '.) ' . $row['title']; ?></p>
                    <p class="text-capitalize artist text-warning m-0 fst-italic"><?php echo 'by: ' . $row['artist']; ?></p>
                </div>
            </a>
        </div>
    <?php
    }
} else {
    ?>
    <div class="alert alert-warning d-flex w-100">
        <p class="m-0">No Christian Song found.</p>
        <a href="lyrics.php" class="btn-close ms-auto"></a>
    </div>
<?php
}

?>