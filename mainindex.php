<?php
// Database connection details
$host = 'localhost';
$db = 'sujancom_demo';
$user = 'sujancom_demouser';
$pass = 'sujan.sujan';

// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

// Retrieve the search term from the form
$search = isset($_POST['search']) ? $_POST['search'] : '';

// Prepare and execute the SQL query using full-text search
if ($search) {
    $sql = "SELECT title, content FROM pastes
            WHERE MATCH(content, description) AGAINST(:search IN BOOLEAN MODE)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['search' => $search]);

    // Fetch the results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $results = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
        }
        pre {
            background: #f4f4f4;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            white-space: pre-wrap; /* Preserve formatting */
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 20px;
        }
        body {
    font-family: Arial, sans-serif;
    margin: 20px;
    background-color: #f4f4f4;
    color: #333;
}

h1 {
    color: #0056b3;
    font-size: 2em;
    border-bottom: 2px solid #0056b3;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

form {
    margin-bottom: 20px;
    padding: 10px;
    background: #ffffff;
    border: 1px solid #ddd;
    border-radius: 4px;
}

input[type="text"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 1em;
}

button {
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    background-color: #0056b3;
    color: #ffffff;
    font-size: 1em;
    cursor: pointer;
    margin-top: 10px;
}

button:hover {
    background-color: #004494;
}

ul {
    list-style-type: none;
    padding: 0;
}

li {
    background: #ffffff;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-bottom: 20px;
    padding: 15px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

h2 {
    font-size: 1.5em;
    margin: 0 0 10px;
}

pre {
    background: #f9f9f9;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    overflow-x: auto;
    white-space: pre-wrap;
    font-family: monospace;
    font-size: 0.9em;
}

p {
    font-size: 1.1em;
    color: #555;
}

    </style>
</head>
<body>
    <h1>Search Results</h1>
    <form action="#" method="post">
        <input type="text" name="search" placeholder="Enter description to search" value="<?php echo htmlspecialchars($search, ENT_QUOTES); ?>">
        <button type="submit">Search</button>
    </form>
    
    <?php if ($results): ?>
        <ul>
            <?php foreach ($results as $result): ?>
                <li>
                    <h2><?php echo htmlspecialchars($result['title'], ENT_QUOTES); ?></h2>
                    <pre><?php echo $result['content']; ?></pre> <!-- No encoding here -->
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No results found.</p>
    <?php endif; ?>
</body>
</html>
