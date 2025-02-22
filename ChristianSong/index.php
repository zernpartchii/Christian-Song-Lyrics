<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="icons/bootstrap-icons.css">
    <link rel="icon" type="image/png" href="./img/musical-note.png">
    <script defer src="bootstrap/bootstrap.min.js"></script>
    <title>Christian Song Lyrics</title>
</head>

<body class="bg-dark text-white">

    <div class="container sticky-top pb-2 bg-dark">
        <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3">
            <a class="navbar-brand bi-music-note" href="./index.php"> Christian Song Lyrics</a>
            <a href="./frontend/addSong.php" class="btn btn-lg btn-primary ms-auto">
                <i class="bi bi-music-note"></i> Add Song
            </a>
        </nav>

        <div class="d-flex align-items-center justify-content-between">
            <div class="fw-bold text-warning">Songs:
                <?php
                include('./backend/config.php');
                include('./backend/totalSong.php');
                echo totalSong($con);
                ?>
            </div>
            <!-- include dropdown -->
            <?php include('./backend/dropdown.php'); ?>
        </div>

        <div class="input-group my-2" role="search">
            <input class="form-control" id="searchInput" type="search" name="search" placeholder="Search"
                aria-label="Search" />
            <button class="btn btn-secondary bi-search" name="submit" type="button"></button>
        </div>
    </div>

    <div class="container">
        <div>
            <!-- include songlist -->
            <?php include('./backend/songlist.php'); ?>
        </div>

        <script>
            let songs = document.querySelectorAll(".song-item");

            document.getElementById("searchInput").addEventListener("keyup", function() {

                let query = this.value.toLowerCase();

                songs.forEach(song => {
                    let title = song.querySelector(".title").textContent.toLowerCase();
                    let artist = song.querySelector(".artist").textContent.toLowerCase();
                    // Show/hide based on match
                    song.style.display = title.includes(query) || artist.includes(query) ? "flex" : "none";
                });
            });

            document.getElementById("filterAll").addEventListener("click", function() {
                songs.forEach(song => {
                    song.style.display = "flex";
                })
            })

            const filterArtist = document.querySelectorAll(".filterArtist");
            filterArtist.forEach(filter => {
                filter.addEventListener("click", function() {
                    let query = this.textContent.trim().toLowerCase(); // Trim and lowercase 

                    songs.forEach(song => {
                        let artist = song.querySelector(".artist").textContent.toLowerCase()
                            .replace("by: ", "").trim();

                        // Show/hide based on match
                        song.style.display = artist.includes(query) ? "flex" : "none";
                    });
                });
            });
        </script>
    </div>

</body>

</html>