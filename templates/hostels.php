<?php
include "../config/core.php";

// Check if the user is logged in by checking if UserID is set in the session
checkLogin();
// Retrieve the user ID from the session
$userID = $_SESSION['UserID'];
// echo $userID;
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Hostels</title>
    
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/gijgo.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/slicknav.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon-16x16.png">
    <link rel="manifest" href="../assets/images/site.webmanifest">
    <!-- <link rel="stylesheet" href="css/responsive.css"> -->
</head>

<body>
    <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

    <!-- header-start -->
    <header>
        <div class="header-area ">
            <div id="sticky-header" class="main-header-area">
                <div class="container-fluid p-0">
                    <div class="row align-items-center no-gutters">
                        <div class="col-xl-5 col-lg-6">
                            <div class="main-menu  d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">
                                        <li><a href="home.php">home</a></li>
                                        <li><a class="active" href="hostels.php">hostels</a></li>
                                        <li><a href="profile.php">Profile</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2">
                            <div class="logo-img">
                                <a href="home.php">
                                    <img src="img/ashesiLogo.png" alt="" class="logo-size">
                                </a>
                            </div> 
                        </div>
                        <div class="col-xl-5 col-lg-4 d-none d-lg-block">

                        </div>
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header-end -->
<style>
.imagex {
    position: relative;
    width: 100%;

}

.imagex img {
    width: 100%;
    height: auto;
}

.imagex h3 {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white; /* Adjust color as needed */
    font-size: 80px;
    color: #fff;
    font-weight: 600;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6); /* Optional: adds a shadow for better visibility */
    margin: 0;
}

</style>
    <!-- bradcam_area_start -->
    <a href="kofi_tawiah.php">
    <div class="imagex">
    <img src="../assets/images/Kofi Taweah.jpg" alt="Kofi Tawiah Hostel" class="bradcam_img">
        <h3>KOFI TAWIAH</h3>
    </div>
    </a>
    <a href="wangari_mathai.php">
    <div class="imagex">
    <img src="../assets/images/Wangari Mathai.jpg" alt="Wangari Mathai" class="bradcam_img">
            <h3>WANGARI MATHAI</h3>
        </div>
    </a>
    <a href="walter_sisulu.php">
    <div class="imagex">
    <img src="../assets/images/Walter Sisulu.jpg" alt="Walter Sisulu" class="bradcam_img">
            <h3>WALTER SISULU</h3>
        </div>
    </a>
    <a href="affrimamu.php">
    <div class="imagex">
    <img src="../assets/images/Ephraim-Amu.jpg" alt="Ephraim-Amu" class="bradcam_img">
            <h3>Ephraim-Amu</h3>
        </div>
    </a>
    <a href="oteng_korankye.php">
    <div class="imagex">
    <img src="../assets/images/Oteng-Korankye.jpg" alt="Oteng-Korankye" class="bradcam_img">
            <h3>OTENG KORANKYE</h3>
        </div>
    </a>
    <a href="hostel_2c.php">
    <div class="imagex">
    <img src="../assets/images/Hostel 2C.jpg" alt="Hostel 2C" class="bradcam_img">
            <h3>HOSTEL 2C</h3>
        </div>
    </a>
    <a href="hostel_2d.php">
    <div class="imagex">
    <img src="../assets/images/Hostel 2D.jpg" alt="Hostel 2D" class="bradcam_img">
            <h3>HOSTEL 2D</h3>
        </div>
    </a>

    <!-- bradcam_area_end -->

    <!-- offers_area_start -->

    <!-- offers_area_end -->
    
    <!-- footer -->

    <!-- form itself end-->
    <form id="test-form" class="white-popup-block mfp-hide">
        <div class="popup_box ">
                <div class="popup_inner">
                    <h3>Check Availability</h3>
                    <form action="#">
                        <div class="row">
                            <div class="col-xl-6">
                                <input id="datepicker" placeholder="Check in date">
                            </div>
                            <div class="col-xl-6">
                                <input id="datepicker2" placeholder="Check out date">
                            </div>
                            <div class="col-xl-6">
                                <select class="form-select wide" id="default-select" class="">
                                    <option data-display="Adult">1</option>
                                    <option value="1">2</option>
                                    <option value="2">3</option>
                                    <option value="3">4</option>
                                </select>
                            </div>
                            <div class="col-xl-6">
                                <select class="form-select wide" id="default-select" class="">
                                    <option data-display="Children">1</option>
                                    <option value="1">2</option>
                                    <option value="2">3</option>
                                    <option value="3">4</option>
                                </select>
                            </div>
                            <div class="col-xl-12">
                                <select class="form-select wide" id="default-select" class="">
                                    <option data-display="Room type">Room type</option>
                                    <option value="1">Laxaries Rooms</option>
                                    <option value="2">Deluxe Room</option>
                                    <option value="3">Signature Room</option>
                                    <option value="4">Couple Room</option>
                                </select>
                            </div>
                            <div class="col-xl-12">
                                <button type="submit" class="boxed-btn3">Check Availability</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </form>
<!-- form itself end -->


    <!-- JS here -->
    <script src="js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/isotope.pkgd.min.js"></script>
    <script src="js/ajax-form.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/jquery.counterup.min.js"></script>
    <script src="js/imagesloaded.pkgd.min.js"></script>
    <script src="js/scrollIt.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/nice-select.min.js"></script>
    <script src="js/jquery.slicknav.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/gijgo.min.js"></script>

    <!--contact js-->
    <script src="js/contact.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.form.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/mail-script.js"></script>

    <script src="js/main.js"></script>
    <script>
        $('#datepicker').datepicker({
            iconsLibrary: 'fontawesome',
            icons: {
             rightIcon: '<span class="fa fa-caret-down"></span>'
         }
        });
        $('#datepicker2').datepicker({
            iconsLibrary: 'fontawesome',
            icons: {
             rightIcon: '<span class="fa fa-caret-down"></span>'
         }

        });
    </script>



</body>

</html>