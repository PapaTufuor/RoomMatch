document.addEventListener('DOMContentLoaded', function() {
    const feedbackButton = document.getElementById('feedback-button');
    const feedbackPopup = document.getElementById('feedback-popup');
    const closeFeedbackPopup = document.getElementById('close-feedback-popup');

    feedbackButton.addEventListener('click', function() {
        feedbackPopup.style.display = 'flex';
    });

    closeFeedbackPopup.addEventListener('click', function() {
        feedbackPopup.style.display = 'none';
    });

    window.addEventListener('click', function(event) {
        if (event.target === feedbackPopup) {
            feedbackPopup.style.display = 'none';
        }
    });

    document.getElementById('feedbackForm').addEventListener('submit', function() {
        // Show snackbar after form submission
        var snackbar = document.getElementById("snackbar");
        snackbar.className = "show";
        setTimeout(function(){ snackbar.className = snackbar.className.replace("show", ""); }, 3000);
    });
});
