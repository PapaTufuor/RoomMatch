<?php
include '../config/connection.php';
include '../config/core.php';// Make sure this file contains your DB connection details

function fetchPreferences($tableName, $columnName)
{
    global $conn;
    $preferences = [];
    $query = "SELECT $columnName FROM $tableName";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $preferences[] = $row[$columnName];
        }
    }
    return $preferences;
}

$likes = fetchPreferences('Likes', 'LikeText');
$dislikes = fetchPreferences('Dislikes', 'DislikeText');
$knows = fetchPreferences('Knows', 'KnowText');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Preference Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <link rel="stylesheet" href="../public/css/preferences.css">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon-16x16.png">
    <link rel="manifest" href="../assets/images/site.webmanifest">
    <link rel="stylesheet" href="../public/css/snackbar.css">
</head>
<body>
<?php if (isset($_GET['msg'])): ?>
    <div id="snackbar"><?php echo htmlspecialchars($_GET['msg']); ?></div>
    <script>
        window.onload = function() {
            var snackbar = document.getElementById('snackbar');
            snackbar.className = "show";
            setTimeout(function(){ snackbar.className = snackbar.className.replace("show", ""); }, 3000);
        };
    </script>
<?php endif; ?>
<nav class="container-fluid">
    <ul>
        <li><strong>Preferences</strong></li>
    </ul>
</nav>
<main class="container">
    <div id="likesSection" class="section active">
        <h2>Likes</h2>
        <div class="cards">
            <?php foreach ($likes as $index => $like): ?>
                <div class="card" data-preference-id="<?php echo $index+1; ?>" onclick="toggleSelection(this)"><?php echo htmlspecialchars($like); ?></div>
            <?php endforeach; ?>
        </div>
    </div>
    <div id="dislikesSection" class="section">
        <h2>Dislikes</h2>
        <div class="cards">
            <?php foreach ($dislikes as $index => $dislike): ?>
                <div class="card" data-preference-id="<?php echo $index+1; ?>" onclick="toggleSelection(this)"><?php echo htmlspecialchars($dislike); ?></div>
            <?php endforeach; ?>
        </div>
    </div>
    <div id="knowsSection" class="section">
        <h2>Knows</h2>
        <div class="cards">
            <?php foreach ($knows as $index => $know): ?>
                <div class="card" data-preference-id="<?php echo $index+1; ?>" onclick="toggleSelection(this)"><?php echo htmlspecialchars($know); ?></div>
            <?php endforeach; ?>
        </div>
    </div>
</main>
<div class="navigation">
    <div id="likesButton" class="toggle-circle"></div>
    <div id="dislikesButton" class="toggle-circle"></div>
    <div id="knowsButton" class="toggle-circle"></div>
    <div id="doneButton" class="hidden">Done</div>
</div>
<script src="../public/js/preferences.js"></script>
</body>
</html>
