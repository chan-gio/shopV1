<?php
// Include your database connection file
include_once('connet.php'); // Replace with the actual file name

// Assuming you have a table named 'categories' with columns 'id' and 'category_name'
$query = "SELECT id, catename FROM categories";
$result = mysqli_query($conn, $query);

if ($result) {
    // Start building the HTML for the dropdown menu
    $html = '';

    while ($row = mysqli_fetch_assoc($result)) {
        // Add each category as a list item in the dropdown menu
        $html .= '<li><a href="#">' . $row['catenamr'] . '</a></li>';
    }

    // Output the HTML
    echo $html;

    // Free result set
    mysqli_free_result($result);
} else {
    // Handle the error if the query fails
    echo "Error: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
