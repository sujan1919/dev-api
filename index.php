<?php
// // Database connection details
// $host = 'localhost';
// $db = '';
// $user = '';
// $pass = '';

// // Create a new PDO instance
// try {
//     $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//     die('Connection failed: ' . $e->getMessage());
// }
include('config.php');

// Initialize variables
$results = [];
$error = '';
$apiKey = '';
$search = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $apiKey = isset($_POST['api-key']) ? $_POST['api-key'] : '';
    $search = isset($_POST['search']) ? $_POST['search'] : '';

    // Validate the API key
    $sql = "SELECT COUNT(*) FROM api_keys WHERE api_key = :api_key";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['api_key' => $apiKey]);

    if ($stmt->fetchColumn() == 0) {
        $error = 'Invalid API key';
    } else {
        // Prepare and execute the SQL query
        if ($search) {
            $sql = "SELECT title, content FROM pastes
                    WHERE MATCH(content, description) AGAINST(:search IN BOOLEAN MODE)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['search' => $search]);

            // Fetch the results
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DEV Search API </title>
    <link rel="stylesheet" type="text/css" target="_blank" href="api.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/brands.min.css" integrity="sha512-EJp8vMVhYl7tBFE2rgNGb//drnr1+6XKMvTyamMS34YwOEFohhWkGq13tPWnK0FbjSS6D8YoA3n3bZmb3KiUYA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    
    <!-- header starts  -->
    <nav>
      <div class="logo">
        <a href="#"><img src="dev-api.png" alt="logo" /></a>
      </div>
      <ul>
        <li>
          <a href="documentation.php" target="_blank">Documentation <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
        </li>
        <li>
          <a href="https://dev.sujan1919.com.np" target="_blank">DEV <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
        </li>
        <li>
          <a href="get-api.php" target="_blank">API KEY <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
        </li>
        <li>
          <a href="https://instagram.com/webwithfreelancer" target="_blank">Contact Us <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
        </li>
      </ul>
      <div class="hamburger">
        <span class="line"></span>
        <span class="line"></span>
        <span class="line"></span>
      </div>
    </nav>
    <div class="menubar">
      <ul>
        <li>
          <a href="#">Home</a>
        </li>
        <li>
          <a href="#">Services</a>
        </li>
        <li>
          <a href="#">Blog</a>
        </li>
        <li>
          <a href="#">Contact Us</a>
        </li>
      </ul>
    </div>
 <!-- header ends  -->
    <form action="#" method="post">
        <label for="api-key">API Key:</label>
        <input type="text" name="api-key" id="api-key" value="<?php echo htmlspecialchars($apiKey, ENT_QUOTES); ?>" required>
        
        <label for="search">Search Query:</label>
        <input type="text" name="search" id="search" value="<?php echo htmlspecialchars($search, ENT_QUOTES); ?>" required>
        
        <button type="submit">Search</button>
    </form>
    
    <?php if ($error): ?>
        <p class="error"><?php echo htmlspecialchars($error, ENT_QUOTES); ?></p>
    <?php elseif ($results): ?>
        <ul>
            <?php foreach ($results as $result): ?>
                <li>
                    <h2><?php echo htmlspecialchars($result['title'], ENT_QUOTES); ?></h2>
                    <pre><?php echo $result['content']; ?></pre> <!-- No encoding here -->
                </li>
            <?php endforeach; ?>
        </ul>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <p>No results found.</p>
    <?php endif; ?>
</body>
<script src="api.js"></script>
</html>
