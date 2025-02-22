<?php

include('config.php');
if (isset($_POST['submit'])) {
    $title = trim(mysqli_escape_string($con, $_POST['title']));
    $artist = trim(mysqli_escape_string($con, $_POST['artist']));
    $songArtist = trim(mysqli_escape_string($con, $_POST['songArtist']));
    $lyrics = trim(mysqli_escape_string($con, $_POST['lyrics']));
    $link = trim(mysqli_escape_string($con, $_POST['link']));

    if (empty($title) || empty($artist) || empty($lyrics)) {
        error("Please fill all the fields.");
    } else {
        if (!empty($songArtist)) {
            try {
                $query = "INSERT INTO song_artist(artist) VALUES('$songArtist');";
                $result = mysqli_query($con, $query);
                if ($result) {
                    $artistID = getMaxID($con, "song_artist");
                    insertSong($con, $title, $artistID, $lyrics, $link);
                }
            } catch (Exception) {
                error("This Artist (" . $songArtist . ") is already exist.");
            }
        } else {
            insertSong($con, $title, $artist, $lyrics, $link);
        }
    }
}

function error($error)
{
    session_start();
    $_SESSION['error'] = $error;
    header("location:../frontend/addSong.php");
}

function getMaxID($con, $table)
{
    $artistID = mysqli_query($con, "SELECT MAX(id) AS 'id' FROM $table;");
    $row = mysqli_fetch_assoc($artistID);
    return $row['id'];
}

function insertSong($con, $title, $artist, $lyrics, $link)
{
    if (!checkSongIfExist($con, $title, $artist)) {
        $query = "INSERT INTO song_list(title, artist, lyrics, link) 
            VALUES('$title', $artist, '$lyrics','$link');";

        $result = mysqli_query($con, $query);

        if ($result) {
            $songID = getMaxID($con, "song_list");
            header("location:../frontend/lyrics.php?id=$songID");
        } else {
            error(mysqli_connect_error());
        }
    }
}

function checkSongIfExist($con, $title, $artist)
{
    $query = "SELECT sl.id, sl.title, sa.artist, sl.lyrics 
    FROM song_list sl JOIN song_artist sa ON sl.artist=sa.id 
    WHERE sl.title='$title' AND sl.artist=$artist;";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    // Check if query executed successfully
    if (!$result) {
        // Handle error if query fails
        error(mysqli_error($con));
        return false; // Return false indicating error
    }

    // Check if any rows are returned
    if (mysqli_num_rows($result) > 0) {
        // Song already exists
        error($row['title'] . " by: " . $row['artist'] . " is already exists.");
        return true;
    }
}
