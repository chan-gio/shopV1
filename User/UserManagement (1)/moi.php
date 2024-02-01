<?php
// Include your database connection file
include_once('connect.php'); // Replace with the actual file name

// Assuming you have a table named 'categories' with columns 'id' and 'category_name'
$query = "SELECT cateid, catename FROM categories";
$result = mysqli_query($conn, $query);

if ($result) {
    // Start building the HTML for the dropdown menu
    $html = '';

    while ($row = mysqli_fetch_assoc($result)) {
        // Add each category as a list item in the dropdown menu
        $html .= '<li><a href="#">' . $row['catename'] . '</a></li>';
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
<!-- ... (your HTML code) ... -->

<a href="#" id="category-dropdown">
    Danh mục
    <i class="nav-arrow-down ti-angle-down"></i>
</a>
<ul class="subnav" id="category-dropdown-menu">
    <!-- Categories will be dynamically loaded here using PHP -->
</ul>
<script>
    // Wrap the JavaScript code in $(document).ready()
    $(document).ready(function () {
        // Hover event for the category dropdown
        $("#category-dropdown").mouseenter(function () {
            // Fetch and display categories from displayCategories.php
            $.ajax({
                type: "GET",
                url: "./displayCategories.php",
                success: function (data) {
                    $("#category-dropdown-menu").html(data);
                    $("#category-dropdown-menu").show();
                }
            });
        });

        $("#category-dropdown").mouseleave(function () {
            // Hide the category dropdown menu when not hovering
            $("#category-dropdown-menu").hide();
        });
    });
</script>
