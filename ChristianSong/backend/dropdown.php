<div class="dropdown me-2">
    <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        Filter by: Artist
    </button>
    <ul class="dropdown-menu dropdown-menu-dark overflow-auto" style="height: 450px;">
        <a class="dropdown-item fw-semibold" id="filterAll">All Artist</a>
        <?php
        $query = "SELECT * FROM song_artist;";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
                <li>
                    <button type="button" class="dropdown-item text-capitalize filterArtist">
                        <?php echo $row['artist']; ?></button>
                </li>
            <?php
            }
        } else {
            ?>
            <div class="alert alert-warning w-100">
                Opps! Something went wrong.
            </div>
        <?php
        }

        ?>
    </ul>
</div>