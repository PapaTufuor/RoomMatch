window.onload = function() {
    showSnackbar();
};

function showSnackbar() {
    var snackbar = document.getElementById("snackbar");
    snackbar.className = "show";
    setTimeout(function(){ snackbar.className = snackbar.className.replace("show", ""); }, 3000);
}
