<nav class="navbar navbar-expand-lg bg-light sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand ms-5" href="index.php">Bruce & Jeffrey's News Website</a>

        <ul class="navbar-nav me-5">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="http://34.204.146.87/~liyifei/m3/index.php">Home</a >
            </li>
            <!-- show new post button if logged in -->
            <?php 
                require 'loginStatus.php';
                // show new post button if logged in
                if (isLoggedIn()) {
                    echo '<li class="nav-item">
                            <a class="nav-link" href="newstory.php">New Post</a>
                        </li>';
                }
            ?>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                
                <?php 
                    // if not logged in, show login button
                    if (!isLoggedIn()) {
                        echo "Login/Register";
                    } else {
                        // if logged in, show username
                        
                        echo htmlspecialchars(getUsername());
                    }

                ?>
                </a >
                <ul class="dropdown-menu">
                <?php 
                    // if logged in, show logout button and profile button, else show login button

                    if (!isLoggedIn()) {
                        echo "<li><a class=\"dropdown-item\" href=\"login.php\">Login</a ></li>";
                        echo "<li><a class=\"dropdown-item\" href=\"register.php\">Register</a ></li>";
                    } else {
                        // echo "<li><a class=\"dropdown-item\" href=\"profile.php\">Profile</a ></li>";
                        echo "<li><a class=\"dropdown-item\" href=\"logout.php\">Logout</a ></li>";
                    } 
                ?>
                </ul>
            </li>
            <li class="nav-item">
                <form class="d-flex" action="index.php" method="GET">
                    <input class="form-control me-2" name="keyword" type="search" placeholder="Search" aria-label="Search" >
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </li>
        </ul>
    </div>
</nav>