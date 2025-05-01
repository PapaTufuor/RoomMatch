document.addEventListener("DOMContentLoaded", function() {
  // Initialize Swiper
  var swiper = new Swiper('.content', {
      effect: 'coverflow',
      grabCursor: true,
      centeredSlides: true,
      slidesPerView: 'auto',
      coverflowEffect: {
          rotate: 50,
          stretch: 0,
          depth: 100,
          modifier: 1,
          slideShadows: true,
      },
      pagination: {
          el: '.swiper-pagination',
      },
  });

//   // Function to send user ID
//   function sendUserId(userId) {
//     const xhr = new XMLHttpRequest();
//     xhr.open("POST", "../actions/room_selection.php", true);
//     xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//     xhr.onreadystatechange = function () {
//         if (xhr.readyState === 4 && xhr.status === 200) {
//             console.log(xhr.responseText); // Handle the response from the server
//             alert(xhr.responseText); // Show an alert with the response
//         } else if (xhr.readyState === 4) {
//             console.error("Error:", xhr.statusText); // Handle the error response
//         }
//     };
//     xhr.send("userId=" + encodeURIComponent(userId));
//   }

//   // Add event listeners to buttons
//   document.querySelectorAll(".select-button").forEach(function(button) {
//       button.addEventListener("click", function(event) {
//           event.preventDefault(); // Prevent default button behavior
//           const userId = this.getAttribute("data-user-id");
//           sendUserId(userId); // Call the function with the user ID
//       });
//   });

});
  