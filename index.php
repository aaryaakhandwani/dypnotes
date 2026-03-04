<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>DYP Notes — Your College Resources, All in One Place</title>
  <meta name="description" content="Access notes, question papers, recorded lectures & toppers' tips — curated for DYP Kolhapur students." />
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles.css" />
  <link rel="stylesheet" href="notifications.css" />
  <style>
    /* ── Homepage-specific styles (hero, announcement, cards) ── */
    #announcement {
      background: var(--warn-bg);
      border-bottom: 2px solid var(--warn-border);
      color: var(--warn-text);
      padding: 10px 20px;
      text-align: center;
      font-size: 0.85rem;
      font-weight: 600;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
      position: relative;
      z-index: 100;
    }

    #announcement button {
      background: none;
      border: none;
      font-size: 18px;
      cursor: pointer;
      color: var(--warn-text);
      line-height: 1;
      padding: 0 4px;
      margin-left: auto;
    }

    .hero {
      text-align: center;
      padding: 60px 24px 24px;
      position: relative;
      z-index: 1;
    }

    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: #fff;
      border: 1.5px solid #c7d4ff;
      color: var(--blue);
      font-size: 0.78rem;
      font-weight: 700;
      padding: 5px 14px;
      border-radius: 100px;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      margin-bottom: 18px;
      box-shadow: 0 2px 12px #1023b620;
    }

    .hero h1 {
      font-family: 'DM Serif Display', serif;
      font-size: clamp(2rem, 6vw, 3.4rem);
      color: var(--navy);
      line-height: 1.15;
      margin-bottom: 14px;
    }

    .hero h1 span { color: var(--blue); }

    .hero p {
      color: var(--muted);
      font-size: 1rem;
      max-width: 480px;
      margin: 0 auto;
      line-height: 1.7;
    }

    /* Card color themes */
    .c1 .s-card-icon { background: #e6ebff; }
    .c2 .s-card-icon { background: #fff3e6; }
    .c3 .s-card-icon { background: #e6f9f0; }
    .c4 .s-card-icon { background: #fce6ff; }
    .c5 .s-card-icon { background: #fff8e6; }

    /* Version tag */
    .version-tag {
      position: fixed;
      bottom: 14px;
      right: 14px;
      background: var(--blue);
      color: #fff;
      font-size: 0.72rem;
      font-weight: 600;
      padding: 5px 11px;
      border-radius: 8px;
      z-index: 999;
      letter-spacing: 0.04em;
    }

    @media (max-width: 640px) {
      .hero { padding: 40px 18px 16px; }
    }
  </style>
</head>

<body>

<!-- Version Tag -->
<div class="version-tag">v2</div>

<!-- Announcement -->
<div id="announcement">
  📢 New update: Search &amp; Filter feature is being rolled out for students.
  <button onclick="this.parentElement.style.display='none'" aria-label="Close">✕</button>
</div>

<div id="notification-container"></div>

<!-- Navbar -->
<nav class="s-nav">
  <a class="s-nav-brand" href="index.php">
    <img src="images/dyp_logo.jpeg" alt="DYP Logo" />
    <span>DYP Notes</span>
  </a>
  <div class="s-nav-links">
    <a href="index.php" class="active">Home</a>
    <a href="contact us.html">Contact Us</a>
  </div>
  <button class="s-hamburger" aria-label="Menu">
    <span></span><span></span><span></span>
  </button>
</nav>
<div class="s-mobile-menu">
  <a href="index.php">Home</a>
  <a href="contact us.html">Contact Us</a>
</div>

<!-- Hero -->
<section class="hero">
  <div class="hero-badge">✦ DYP Kolhapur · Student Resource Hub</div>
  <h1>Your College Resources,<br><span>All in One Place</span></h1>
  <p>Access notes, question papers, recorded lectures & toppers' tips — curated for DYP students.</p>
</section>

<!-- Cards -->
<section class="s-section">
  <p class="s-section-label">Browse Resources</p>
  <div class="s-card-grid">

    <a class="s-card c1" href="notes.html">
      <div class="s-card-icon">📄</div>
      <div>
        <div class="s-card-title">Notes</div>
        <div class="s-card-desc">Subject-wise notes curated by students and faculty for all semesters.</div>
      </div>
      <div class="s-card-arrow">Browse Notes →</div>
    </a>

    <a class="s-card c2" href="que paper.html">
      <div class="s-card-icon">📝</div>
      <div>
        <div class="s-card-title">Question Papers</div>
        <div class="s-card-desc">Autonomous exam question papers to help you prepare better and faster.</div>
      </div>
      <div class="s-card-arrow">View Papers →</div>
    </a>

    <a class="s-card c3 soon" href="#">
      <div class="s-soon-badge">Coming Soon</div>
      <div class="s-card-icon">🎬</div>
      <div>
        <div class="s-card-title">Recorded Lectures</div>
        <div class="s-card-desc">Watch chapter-wise recorded lectures from experienced faculty.</div>
      </div>
      <div class="s-card-arrow">Explore →</div>
    </a>

    <a class="s-card c4" href="toppers sugg.html">
      <div class="s-card-icon">🏆</div>
      <div>
        <div class="s-card-title">Toppers' Suggestions</div>
        <div class="s-card-desc">Tips, strategies, and study plans shared by top-scoring students.</div>
      </div>
      <div class="s-card-arrow">Read Tips →</div>
    </a>

    <a class="s-card c5 soon" href="#">
      <div class="s-soon-badge">Coming Soon</div>
      <div class="s-card-icon">📚</div>
      <div>
        <div class="s-card-title">Reference Books</div>
        <div class="s-card-desc">Curated reference books for deeper understanding of your subjects.</div>
      </div>
      <div class="s-card-arrow">Explore →</div>
    </a>

  </div>
</section>

<footer class="s-footer">© 2025 DYP Notes · Made for Students, by Students</footer>

<script src="nav.js"></script>
<script src="notifications.js"></script>

<script>
window.onload = function() {
  <?php if (isset($_GET['logout']) && $_GET['logout'] === 'success'): ?>
    NotificationSystem.show({
      title: "Logged Out",
      message: "You have been successfully logged out of DYP Notes.",
      type: "info",
      duration: 5000
    });
  <?php elseif (isset($_GET['login']) && $_GET['login'] === 'success'): ?>
    NotificationSystem.show({
      title: "Welcome Back",
      message: "You have successfully logged in to DYP Notes!",
      type: "success",
      duration: 5000
    });
  <?php else: ?>
    // Optional: Only show general welcome if no specific action occurred
    // Remove or keep based on preference
  <?php endif; ?>
};
</script>


</body>
</html>