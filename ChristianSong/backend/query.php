<?php

function fetchSongs($con, $condition)
{
    $query = "SELECT sl.id, lower(sl.title) AS 'title', lower(sa.artist) AS 'artist', sl.lyrics, sl.link , sl.artist AS 'artistID'
            FROM song_list sl JOIN song_artist sa ON sl.artist=sa.id $condition";
    return mysqli_query($con, $query);
}
