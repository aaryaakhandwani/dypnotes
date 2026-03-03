<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
  $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: /dypnotes/index.php");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login — DYP Notes</title>
  <meta name="description" content="Login to your DYP Notes account." />
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../styles.css" />
</head>
<body>

<!-- Navbar -->
<nav class="s-nav">
  <a class="s-nav-brand" href="../index.php">
    <img src="../images/dyp_logo.jpeg" alt="DYP Logo" />
    <span>DYP Notes</span>
  </a>
  <div class="s-nav-links">
    <a href="../index.php">Home</a>
    <a href="../contact us.html">Contact Us</a>
  </div>
  <button class="s-hamburger" aria-label="Menu">
    <span></span><span></span><span></span>
  </button>
</nav>
<div class="s-mobile-menu">
  <a href="../index.php">Home</a>
  <a href="../contact us.html">Contact Us</a>
</div>

<!-- Auth Form -->
<div class="s-auth-wrap">
  <div class="s-auth-card">
    <h2>Welcome Back</h2>
    <p class="s-auth-sub">Sign in to access your DYP Notes account.</p>

    <?php if ($is_invalid): ?>
      <div style="background:#ffe6ea; color:#b91c3a; padding:12px 16px; border-radius:12px; font-size:0.88rem; font-weight:600; margin-bottom:18px;">
        ⚠ Invalid email or password. Please try again.
      </div>
    <?php endif; ?>

    <form method="post">
      <div class="s-form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="you@example.com" required
               value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" />
      </div>

      <div class="s-form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required />
      </div>

      <div class="s-check-group">
        <input type="checkbox" id="remember" name="remember" />
        <label for="remember">Remember me</label>
      </div>

      <button class="s-btn" type="submit">Login →</button>
    </form>

    <p class="s-auth-footer">
      Don't have an account? <a href="signup.html">Create one</a>
    </p>
  </div>
</div>

<footer class="s-footer">© 2025 DYP Notes · Made for Students, by Students</footer>

<script src="../nav.js"></script>
</body>
</html>
