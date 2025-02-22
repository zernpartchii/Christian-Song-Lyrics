<?php

function totalSong($con)
{
    $query = "SELECT COUNT(id) AS 'Total' FROM song_list;";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['Total'];
}
