<!-- header.php -->
<header class="site-header">
  <div class="logo-section">
    <img src="assets/Logo.png" alt="Asian College Logo" class="logo-img" />
    <div class="logo-text">
      <span>Student</span><br/>
      <span>Information</span><br/>
      <span>System</span>
    </div>
  </div>

  <?php if (!empty($showBackButton)): ?>
    <a href="dashboard.php" class="back-button">← Go Back to Dashboard</a>
  <?php else: ?>
    <form action="login.php" method="post">
      <button class="logout-btn">Logout</button>
    </form>
  <?php endif; ?>
</header>
