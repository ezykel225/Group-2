document.getElementById('forgot-password').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('custom-modal').style.display = 'block';
});

document.querySelector('.close-button').addEventListener('click', function() {
    document.getElementById('custom-modal').style.display = 'none';
});

window.addEventListener('click', function(event) {
    if (event.target == document.getElementById('custom-modal')) {
        document.getElementById('custom-modal').style.display = 'none';
    }
});