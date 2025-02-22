<?php include('header.php'); ?>

<body>

    <?php

    include('topbar.php');
    include('../backend/formatLyrics.php');
    include('../backend/config.php');
    include('../backend/query.php');
    include('../backend/search.php');

    $result = fetchSongs($con, $condition);
    $row = mysqli_fetch_assoc($result);

    $artist = "Unknown";
    $title = "Unknown";
    $lyrics = "No Lyrics Available";
    $link = "";

    if ($row) {
        $title = $row['title'];
        $artist = $row['artist'];
        $lyrics = $row['lyrics'];
        $link = getYouTubeID($row['link']);
    }

    function getYouTubeID($url)
    {
        preg_match('/(?:youtube\.com\/.*v=|youtu\.be\/)([^&]+)/', $url, $matches);
        return $matches[1] ?? "https://www.youtube.com/embed/?autoplay=1&controls=1&modestbranding=1&rel=0";
    }
    ?>
    <div class="container vh-100" style="margin-top: 100px;">
        <div class="d-flex justify-content-center flex-wrap">
            <div class="card border-0 col-sm-12 col-md-6 col-lg-8">
                <?php
                session_start();
                if (isset($_SESSION['success'])) { ?>

                    <div class="alert alert-info borsder-0 d-flex">
                        <?php echo $_SESSION['success']; ?>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                <?php
                    unset($_SESSION['success']);
                }

                ?>

                <div class="rounded-3">
                    <div id="playerContainer"></div>
                    <input type="hidden" id="songLink" value="<?php echo $link; ?>">
                </div>

                <div class="card-header bg-transparent border-0 d-flex flex-wrap gap-3 justify-content-between">
                    <h3 class="text-capitalize m-0"><?php echo $title . " - " . $artist; ?></h3>
                    <a href="updateSong.php?id=<?php echo $id; ?>" class="btn btn-dark bi-pencil-fill "> Edit</a>
                </div>
                <div class="card-body me-3 overflow-auto">
                    <p class="fs-5"><?php echo formatLyrics($lyrics); ?></p>
                </div>
            </div>
            <div class="card border-0 col-sm-12 col-md-6 col-lg-4 overflow-auto flex-fill" style="height: 70rem;">
                <div class="card-header bg-body border-0 sticky-top">
                    <h4 class="m-3">Explore Songs of <div class="text-capitalize text-danger"><?php echo $artist; ?>
                        </div>
                    </h4>
                    <div action="lyrics.php" method="POST" class="input-group" role="search">
                        <input class="form-control" id="searchInput" type="search" name="search"
                            placeholder="Search Here..." aria-label="Search" />
                        <button class="btn btn-secondary bi-search" name="submit" type="button"></button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- include lyrics -->
                    <?php include('../backend/lyrics.php'); ?>
                </div>

                <script>
                    document.getElementById("searchInput").addEventListener("keyup", function() {

                        let query = this.value.toLowerCase();
                        let songs = document.querySelectorAll(".song-item");

                        songs.forEach(song => {
                            let title = song.querySelector(".title").textContent.toLowerCase();
                            let artist = song.querySelector(".artist").textContent.toLowerCase();

                            songs.innerHTML = "";
                            // Show/hide based on match
                            song.style.display = title.includes(query) || artist.includes(query) ?
                                "flex" :
                                "none";
                        });
                    });
                </script>

                <script>
                    const playerContainer = document.getElementById("playerContainer");
                    const songLink = document.getElementById("songLink");

                    function playChristianSong() {

                        let randomSong = songLink.value;
                        // If player is not initialized, create an iframe manually
                        playerContainer.innerHTML = `<iframe class="iframe" src="https://www.youtube.com/embed/${randomSong}?autoplay=1&controls=1&modestbranding=1&rel=0"
              frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>`;
                    }

                    playChristianSong();
                </script>

                <style>
                    .iframe {
                        height: 350px;
                        width: 100%;
                    }
                </style>

            </div>
        </div>
    </div>
</body>

</html>