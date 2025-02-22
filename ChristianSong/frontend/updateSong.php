<?php include('header.php') ?>

<body class="bg-light">
    <?php

    include('topbar.php');
    include('../backend/config.php');
    include('../backend/query.php');

    // Check if the ID is set and it's not empty
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        // Sanitize the ID to prevent SQL injection
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $condition = "WHERE sl.id=$id";
    }

    $result = fetchSongs($con, $condition);
    $row = mysqli_fetch_assoc($result);

    ?>

    <div class="container d-flex justify-content-center" style="margin-top: 100px;">
        <form action="../backend/updateSong.php" method="POST" class="card border-0 p-3 mb-5">
            <?php
            session_start();
            if (isset($_SESSION['error'])) { ?>

            <div class="alert alert-warning border-0 w-100">
                <?php echo $_SESSION['error']; ?>
            </div>

            <?php
                unset($_SESSION['error']);
            }

            ?>

            <div class="d-flex justify-content-between align-items-center mb-5">
                <h1>Update Song</h1>
                <div class="text-end d-flex flex-wrap gap-3">
                    <a href="./lyrics.php?id=<?php echo $id ?>" class="btn btn-secondary">Close</a>
                    <button type=" submit" name="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
            <div class="d-flex flex-wrap gap-3">
                <div class="d-flex flex-column flex-fill gap-3">
                    <input type="hidden" id="title" name="id" value="<?php echo $row['id']; ?>">
                    <div class="">
                        <label class="form-label" for="title" class="">Title</label>
                        <input type="search" class="form-control text-capitalize" id="title" name="title"
                            placeholder="Song title here..." value="<?php echo $row['title']; ?>">
                    </div>

                    <div class="">
                        <label class="form-label" for="dropdown">Artist</label>
                        <input type="search" id="searchArtist" class="form-control mb-2" placeholder="Search Artist">
                        <select id="dropdown" name="artist" class="form-select" size="14">
                            <!-- Added size="5" -->
                            <?php
                            $query = "SELECT * FROM song_artist";
                            $result = mysqli_query($con, $query);

                            if (mysqli_num_rows($result) > 0) {
                                while ($rows = mysqli_fetch_assoc($result)) {
                            ?>
                            <option value="<?php echo $rows['id']; ?>"
                                <?php echo $rows['id'] == $row['artistID'] ? 'selected' : ''; ?>>
                                <?php echo $rows['artist']; ?>
                            </option>
                            <?php
                                }
                            } else {
                                ?>
                            <option disabled>No artists found</option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <script>
                    const searchArtist = document.getElementById("searchArtist");
                    const dropdown = document.getElementById("dropdown");

                    // Set default value in input based on the selected option
                    searchArtist.value = dropdown.options[dropdown.selectedIndex].text;

                    // Filter options while typing
                    searchArtist.addEventListener("input", function() {
                        let filter = this.value.toLowerCase();
                        let options = dropdown.querySelectorAll("option");

                        let found = false; // Track if at least one match is found
                        options.forEach(option => {
                            let text = option.textContent.toLowerCase();
                            let isMatch = text.includes(filter);
                            option.style.display = isMatch ? "block" : "none";
                            if (isMatch) found = true;
                        });

                        // Expand dropdown if there's a match
                        dropdown.size = found ? Math.min(options.length, 14) : 1;
                    });

                    // Update input when an option is selected
                    dropdown.addEventListener("change", function() {
                        searchArtist.value = dropdown.options[dropdown.selectedIndex].text;
                    });
                    </script>


                </div>

                <div class="d-flex flex-column flex-fill gap-3">
                    <div class="">
                        <label class="form-label" for="link">Song Link</label>
                        <input type="search" id="link" name="link" class="form-control" autocomplete="off"
                            value="<?php echo $row['link']; ?>" placeholder="Song link here...">
                    </div>
                    <div class="">
                        <label class="form-label" for="lyrics" class="">Lyrics</label>
                        <textarea class="form-control" id="lyrics" name="lyrics" cols="100" rows="15"
                            placeholder="Song lyrics here..."><?php echo $row['lyrics']; ?></textarea>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <style>
    .addSong {
        display: none;
    }
    </style>
</body>

</html>