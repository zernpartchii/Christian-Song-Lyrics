<?php

$condition = "ORDER BY sl.title ASC";

// Check if the ID is set and it's not empty
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Sanitize the ID to prevent SQL injection
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $condition = "WHERE sl.id=$id";
}

if (isset($_POST['submit'])) {
    $search = mysqli_escape_string($con, $_POST['search']);
    $condition = "WHERE sl.title LIKE '%$search%' OR sa.artist LIKE '%$search%'";
}

// Check if the artist is set and it's not empty
if (isset($_GET['artist']) && !empty($_GET['artist'])) {
    // Sanitize the artist to prevent SQL injection
    $artist = mysqli_escape_string($con, filter_var($_GET['artist']));
    $condition = "WHERE sa.artist='" . $artist . "' ORDER BY sl.title ASC";
?>
    <h4>Artist: <i class="text-warning"><?php echo $_GET['artist']; ?></i></h4>
<?php
}
