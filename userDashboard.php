<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location:login.php");
    exit();
}
include("dbConnection.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
</head>

<body>
    <?php
    echo "Welcome ".$_SESSION['username']." |";
    ?>
    <a href="logout.php">logout</a>
    <hr>
    <div class="sort" style="display: flex;">
        <form method="GET">
            <label for="category">Category</label>
            <select name="category">
                <option value="">--Select category--</option>
                <option value="Musical_Instrument" <?php echo (isset($_GET['category']) && $_GET['category'] == "Musical_Instrument") ? "selected" : "" ?>>
                    Musical Instrument
                </option>
                <option value="Books" <?php echo (isset($_GET['category']) && $_GET['category'] == "Books") ? "selected" : "" ?>>
                    Books
                </option>
                <option value="Dress" <?php echo (isset($_GET['category']) && $_GET['category'] == "Dress") ? "selected" : "" ?>>
                    Clothing
                </option>
            </select>

            <label for="sort_by">Sort</label>
            <select name="sort_by">
                <option value="">--Sort by--</option>
                <option value="price_asc" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == "price_asc") ? "selected" : "" ?>>Price Asc</option>
                <option value="price_desc" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == "price_desc") ? "selected" : "" ?>>Price Desc</option>
                <option value="name_asc" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == "name_asc") ? "selected" : "" ?>>Name Asc</option>
                <option value="name_desc" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == "name_desc") ? "selected" : "" ?>>Name Desc</option>
            </select>
            <input type="submit" value="Filter" name="filterBtn">
        </form>

        <div style="padding-left: 100px;">
            <form method="get">
                <input type="search" placeholder="Search" name="search" value="<?php
                    echo isset($_GET['searchBtn']) ? $_GET['search'] : '';
                    ?>">
                <input type="submit" value="Search" name="searchBtn">
            </form>
        </div>
    </div>
    <hr>

    <div>
        <h4>Advance Search:</h4>
        <form method="get">
            <label>Search:</label>
            <input type="search" placeholder="Search" name="filSearch" value="<?php
                    echo isset($_GET['advanceFilterBtn']) ? $_GET['filSearch'] : '';
                    ?>">

            <label>Category:</label>
            <select name="filterCat">
                <option value="">--Select Category--</option>
                <option value="Musical_Instrument" <?php echo (isset($_GET['filterCat']) && $_GET['filterCat'] == "Musical_Instrument") ? "selected" : "" ?>>Musical Instrument</option>
                <option value="Books" <?php echo (isset($_GET['filterCat']) && $_GET['filterCat'] == "Books") ? "selected" : "" ?>>Books</option>
                <option value="Dress" <?php echo (isset($_GET['filterCat']) && $_GET['filterCat'] == "Dress") ? "selected" : "" ?>>Clothing</option>
            </select>

            <label>Sort</label>
            <select name="filterSort_by">
                <option value="">--Sort by--</option>
                <option value="price_asc" <?php echo (isset($_GET['filterSort_by']) && $_GET['filterSort_by'] == "price_asc") ? "selected" : "" ?>>Price Asc</option>
                <option value="price_desc" <?php echo (isset($_GET['filterSort_by']) && $_GET['filterSort_by'] == "price_desc") ? "selected" : "" ?>>Price Desc</option>
                <option value="name_asc" <?php echo (isset($_GET['filterSort_by']) && $_GET['filterSort_by'] == "name_asc") ? "selected" : "" ?>>Name Asc</option>
                <option value="name_desc" <?php echo (isset($_GET['filterSort_by']) && $_GET['filterSort_by'] == "name_desc") ? "selected" : "" ?>>Name Desc</option>
            </select>

            <label>Price:</label>
            <input type="text" placeholder="Min Price" name="minPrice" value="<?php
                    echo isset($_GET['advanceFilterBtn']) ? $_GET['minPrice'] : '';
                    ?>">
            <input type="text" placeholder="Max Price" name="maxPrice" value="<?php
                    echo isset($_GET['advanceFilterBtn']) ? $_GET['maxPrice'] : '';
                    ?>">

            <input type="submit" name="advanceFilterBtn" value="Filter">
        </form>
    </div>
    <hr>

    <?php

    $query = "SELECT * FROM product WHERE 1=1";

    if (isset($_GET['advanceFilterBtn'])) {
        if (isset($_GET['filSearch']) && !empty($_GET['filSearch'])) {
            $filSearch = $_GET['filSearch'];
            $query .= " AND Name LIKE '%$filSearch%'";
        }

        if (isset($_GET['filterCat']) && !empty($_GET['filterCat'])) {
            $filCat = $_GET['filterCat'];
            $query .= " AND Category = '$filCat'";
        }

        if (isset($_GET['minPrice'])) {
            $filMinPrice = $_GET['minPrice'];
            if (empty($filMinPrice)){
                $filMinPrice = 0;
            }
            $query .= " AND Price >= $filMinPrice";
        }

        if (isset($_GET['maxPrice']) ) {
            $filMaxPrice = $_GET['maxPrice'];
            if (empty($filMaxPrice)){
                $filMaxPrice = 9999999;
            }
            $query .= " AND Price <= $filMaxPrice";
        }

        if (isset($_GET['filterSort_by']) && !empty($_GET['filterSort_by'])) {
            $sortedBy = $_GET['filterSort_by'];
            switch ($sortedBy) {
                case 'price_asc':
                    $query .= " ORDER BY Price ASC";
                    break;

                case 'price_desc':
                    $query .= " ORDER BY Price DESC";
                    break;

                case 'name_asc':
                    $query .= " ORDER BY Name ASC";
                    break;

                case 'name_desc':
                    $query .= " ORDER BY Name Desc";
                    break;
            }
        }
    }

    ?>



    <div>
        <?php
        // PHP code to handle category filter
        if (isset($_GET['filterBtn'])) {
            $query = "SELECT * FROM product ";
            if (isset($_GET['category']) && !empty($_GET['category'])) {
                $selectedCategory = $_GET['category'];
                $query .= " WHERE Category = '$selectedCategory'";
            }
            if (isset($_GET['sort_by']) && !empty($_GET['sort_by'])) {
                $sortedBy = $_GET['sort_by'];
                switch ($sortedBy) {
                    case 'price_asc':
                        $query .= " ORDER BY Price ASC";
                        break;

                    case 'price_desc':
                        $query .= " ORDER BY Price DESC";
                        break;

                    case 'name_asc':
                        $query .= " ORDER BY Name ASC";
                        break;

                    case 'name_desc':
                        $query .= " ORDER BY Name Desc";
                        break;
                }
            }
        }

        if (isset($_GET['searchBtn'])) {
            $searched = $_GET['search'];
            $query = "SELECT * FROM product WHERE Name LIKE '%$searched%'";
        }

        // Execute the query and display results
        echo "<div>";
        // echo "<h2>$selectedCategory</h2>";
        echo "</div>";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
        echo "<div class='selectCategory' style='display: flex; flex-wrap: wrap;'>";
        while ($row = mysqli_fetch_array($result)) {
            echo "<div style='padding: 20px;'>";
            // echo $row['ID']. "<br>";
            $image = $row['Image'];
            echo "<img src='images/$image' width='200px' height='200px'><br>";
            echo "Name: " . $row['Name'] . "<br>";
            echo "Price: $" . $row['Price'] . "<br>";
            echo "Category: " . $row['Category'] . "<br>";
            echo "</div>";
        }
        echo "</div>";
        ?>
    </div>
</body>

</html>