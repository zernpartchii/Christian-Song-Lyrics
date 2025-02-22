<?php include('header.php') ?>

<body class="bg-light">
    <?php include('topbar.php') ?>

    <div class="container" style="margin-top: 100px;">
        <form action="../backend/addSong.php" method="POST" class="card border-0 p-3 mb-5">
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
                <h1>Add Song </h1>
                <div class="text-end d-flex flex-wrap gap-3">
                    <a href="../index.php" class="btn btn-secondary">Close</a>
                    <button type="submit" name="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
            <div class="d-flex flex-wrap gap-3">
                <div class="d-flex flex-column flex-fill gap-3">
                    <div class="">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Song title here..."
                            autocapitalize="on">
                    </div>
                    <div class="">
                        <label for="dropdown" class="form-label">Artist</label>
                        <input type="search" id="searchArtist" class="form-control mb-2" placeholder="Search Artist">
                        <select id="dropdown" name="artist" class="form-select" size="14">
                            <?php
                            include('../backend/config.php');

                            $query = "SELECT * FROM song_artist;";
                            $result = mysqli_query($con, $query);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['artist']; ?></option>
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
                        </select>
                        <script>
                            const searchArtist = document.getElementById("searchArtist");
                            const dropdown = document.getElementById("dropdown");

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
                        <div id="otherInput" style="display: none;">
                            <div class="d-flex align-items-center">
                                <input class="form-control me-2" type="text" name="songArtist"
                                    placeholder="Song Artist" />
                                <span class="btn btn-close" onclick="reset();"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column flex-fill gap-3">
                    <div class="">
                        <label class="form-label" for="link">Song Link</label>
                        <input type="search" id="link" name="link" class="form-control" placeholder="Song link here..."
                            autocomplete="off">
                    </div>
                    <div class="">
                        <label class="form-label" for="lyrics" class="">Lyrics</label>
                        <textarea class="form-control" id="lyrics" name="lyrics" cols="100" rows="15"
                            placeholder="Song lyrics here..."> </textarea>
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

    <script>
        var otherInput = document.getElementById("otherInput");
        var selectElement = document.getElementById("dropdown");

        function reset() {
            selectElement.style.display = "inline";
            otherInput.style.display = "none";
            selectElement.selectedIndex = 0
        }
        // Show input field if "Other" option is selected
        selectElement.addEventListener("change", function() {
            if (this.value === "other") {
                otherInput.style.display = "inline";
                selectElement.style.display = "none";
            } else {
                otherInput.style.display = "none";
            }
        });
    </script>
</body>

</html>