document.addEventListener('DOMContentLoaded', function() {
    const notificationLink = document.getElementById('notification-link');
    const popup = document.getElementById('notification-popup');
    const closePopup = document.getElementById('close-popup');

    notificationLink.addEventListener('click', function(event) {
        event.preventDefault();
        popup.style.display = 'flex';
    });

    closePopup.addEventListener('click', function() {
        popup.style.display = 'none';
    });

    window.addEventListener('click', function(event) {
        if (event.target == popup) {
            popup.style.display = 'none';
        }
    });

    let button = document.getElementById("read");

button.addEventListener('click',() => {
  document.querySelectorAll('.single-box').forEach(e => {
    e.classList.remove('unseen');
  });
  document.querySelectorAll('.dot').forEach(e => {
    e.classList.remove('dot');
  });
  document.getElementById('num').innerText = '0';
})
});