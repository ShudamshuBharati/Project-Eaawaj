<?php
// Start session
session_start();
?>

<nav class="navbar navbar-expand-lg navbar-light bg-primary-subtle">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img class="img" src="logo.webp" alt="E-AAWAJ Logo">
            E-AAWAJ
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                
                <?php if (isset($_SESSION['user_name'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><?php echo htmlspecialchars($_SESSION['user_name']); ?></a>
                    </li>
                    <!-- Logout Button -->
                    <li class="nav-item">
                        <a class="nav-link" href="logoutlogic.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="userlogin.php">User Login</a>
                    </li>
                <?php endif; ?>
                
                <li class="nav-item">
                    <a class="nav-link" href="#about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
