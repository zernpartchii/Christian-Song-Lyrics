<?php

include('config.php');
if (isset($_POST['submit'])) {
    $id = trim(mysqli_escape_string($con, $_POST['id']));
    $title = trim(mysqli_escape_string($con, $_POST['title']));
    $artist = trim(mysqli_escape_string($con, $_POST['artist']));
    $lyrics = trim(mysqli_escape_string($con, $_POST['lyrics']));
    $link = trim(mysqli_escape_string($con, $_POST['link']));

    if (empty($title) || empty($artist) || empty($lyrics) || empty($link)) {
        error("Please fill all the fields.");
    } else {
        updateSong($con, $title, $artist, $lyrics, $link, $id);
    }
}

function error($error)
{
    session_start();
    $_SESSION['error'] = $error;
    header("location:../frontend/updateSong.php");
}

function updateSong($con, $title, $artist, $lyrics, $link, $id)
{
    $query = "UPDATE song_list SET title='$title', artist=$artist, lyrics='$lyrics', link='$link'
            WHERE id=$id";

    $result = mysqli_query($con, $query);

    if ($result) {
        session_start();
        $_SESSION['success'] = "Updated Successfully!";
        header("location:../frontend/lyrics.php?id=$id");
    } else {
        error(mysqli_connect_error());
    }
}
