<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/notification.css">
    <link rel="stylesheet" href="../public/css/snackbar.css">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon-16x16.png">
    <link rel="manifest" href="../assets/images/site.webmanifest">
    <title>Notifications</title>
</head>
<body>
<div id="snackbar">Judith sent a request</div>

<div class="container">
    <div class="wrapper">
        <div class="top-bar">
            <div class="title">
                <p class="title-text">Notifications</p>
                <p class="num" id="num">3</p>
            </div>
            <a href="#" class="read" id="read">Mark all as read</a>
        </div>
        <div class="notifications">
            <!-- single notification starts -->
            <div class="single-box unseen">
                <div class="avatar">
                    <img src="https://digitshack.com/codepen/mentor14/avatar-mark-webber.webp" alt="">
                </div>
                <div class="box-text">
                    <p class="notifi">
                        <a href="#" class="name"> Mark Webber </a>reacted to your recent post <a href="#" class="post">My first tournament today!</a>
                        <span class="dot"></span>
                    </p>
                    <p class="time">1m ago</p>
                </div>
            </div>
            <!-- single notification end -->
            <!-- single notification starts -->
            <div class="single-box unseen">
                <div class="avatar">
                    <img src="https://digitshack.com/codepen/mentor14/avatar-angela-gray.webp" alt="">
                </div>
                <div class="box-text">
                    <p class="notifi">
                        <a href="#" class="name">Angela Gray </a>followed you
                        <span class="dot"></span>
                    </p>
                    <p class="time">5m ago</p>
                </div>
            </div>
            <!-- single notification end -->
            <!-- single notification starts -->
            <div class="single-box unseen">
                <div class="avatar">
                    <img src="https://digitshack.com/codepen/mentor14/avatar-jacob-thompson.webp" alt="">
                </div>
                <div class="box-text">
                    <p class="notifi">
                        <a href="#" class="name">Jacob Thompson </a>has joined your group <a href="#" class="group">Chess Club</a>
                        <span class="dot"></span>
                    </p>
                    <p class="time">1 day ago</p>
                </div>
            </div>
            <!-- single notification end -->
            <!-- single notification starts -->
            <div class="single-box with-mssg">
                <div class="avatar">
                    <img src="https://digitshack.com/codepen/mentor14/avatar-rizky-hasanuddin.webp" alt="">
                </div>
                <div class="box-text">
                    <p class="notifi">
                        <a href="#" class="name">Rizky Hasanuddin </a>sent you a private message
                    </p>
                    <p class="time">5 days ago</p>
                    <div class="message">
                        <p>Hello, thanks for setting up the Chess Club. I've been a member for a few weeks now and I'm already having lots of fun and improving my game.</p>
                    </div>
                </div>
            </div>
            <!-- single notification end -->
            <!-- single notification starts -->
            <div class="single-box comment">
                <div class="left">
                    <div class="avatar">
                        <img src="https://digitshack.com/codepen/mentor14/avatar-kimberly-smith.webp" alt="">
                    </div>
                    <div class="box-text">
                        <p class="notifi">
                            <a href="#" class="name">Kimberly Smith </a>commented on your picture
                        </p>
                        <p class="time">1 week ago</p>
                    </div>
                </div>
                <div class="img-box">
                    <img src="https://digitshack.com/codepen/mentor14/image-chess.webp" alt="">
                </div>
            </div>
            <!-- single notification end -->
            <!-- single notification starts -->
            <div class="single-box">
                <div class="avatar">
                    <img src="https://digitshack.com/codepen/mentor14/avatar-nathan-peterson.webp" alt="">
                </div>
                <div class="box-text">
                    <p class="notifi">
                        <a href="#" class="name">Nathan Peterson </a>reacted to your recent post  <a href="#" class="post">5 end-game strategies to increase your win rate</a>
                    </p>
                    <p class="time">2 weeks ago</p>
                </div>
            </div>
            <!-- single notification end -->
            <!-- single notification starts -->
            <div class="single-box">
                <div class="avatar">
                    <img src="https://digitshack.com/codepen/mentor14/avatar-anna-kim.webp" alt="">
                </div>
                <div class="box-text">
                    <p class="notifi">
                        <a href="#" class="name">Anna Kim </a>left the group <a href="#" class="group">Chess Club</a>
                    </p>
                    <p class="time">2 weeks ago</p>
                </div>
            </div>
            <!-- single notification end -->
        </div>
    </div>
</div>
</body>
<script src="../public/js/notification.js"></script>
<script src="../public/js/snackbar.js"></script>
</html>
