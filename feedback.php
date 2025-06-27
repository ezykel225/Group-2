<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- Floating Feedback Button -->
<div class="feedback-button" onclick="toggleFeedbackForm()">&#9993;</div>

<!-- Feedback Form -->
<div id="feedback-form" class="feedback-form">
    <div class="feedback-form-content">
        <span class="close-btn" onclick="toggleFeedbackForm()">&times;</span>
        <h3>Submit Feedback</h3>
        <form method="POST" action="submit_feedback.php">
            <textarea name="feedback_text" placeholder="Your feedback..." required></textarea>
            <button type="submit">Submit</button>
        </form>
    </div>
</div>

<!-- Styled Notification Pop-up -->
<div id="notification" class="custom-modal">
    <div class="custom-modal-content">
        <span class="custom-modal-title">Important!</span>
        <p id="notification-message"></p>
        <button onclick="closeNotification()" class="modal-button">OK</button>
    </div>
</div>

<script>
    function toggleFeedbackForm() {
        <?php if (!isset($_SESSION['student'])): ?>
            alert('You must be logged in to submit feedback!');
            return;
        <?php endif; ?>

        var form = document.getElementById('feedback-form');
        form.style.display = (form.style.display === 'block') ? 'none' : 'block';
    }

    function showNotification(message) {
        document.getElementById('notification-message').textContent = message;
        document.getElementById('notification').style.display = 'flex';
    }

    function closeNotification() {
        document.getElementById('notification').style.display = 'none';
    }

    <?php if (isset($_SESSION['feedback_success'])): ?>
        showNotification('Thank you for your feedback! It helps us improve.');
        <?php unset($_SESSION['feedback_success']); ?>
    <?php elseif (isset($_SESSION['feedback_error'])): ?>
        showNotification('There was an issue submitting your feedback. Please try again.');
        <?php unset($_SESSION['feedback_error']); ?>
    <?php endif; ?>
</script>