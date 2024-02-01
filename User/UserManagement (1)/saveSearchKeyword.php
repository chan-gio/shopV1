<?php
session_start();

// Check if the keyword is set
if (isset($_POST['keyword'])) {
    $keyword = $_POST['keyword'];

    // Save the search keyword in the session
    $_SESSION['searchKeyword'] = $keyword;

    echo "Search keyword saved successfully.";
} else {
    echo "Invalid request.";
}
?>
