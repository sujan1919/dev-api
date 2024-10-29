<?php
// search-api.php

header('Content-Type: application/json');

// Database connection settings
$host = 'localhost';
$dbname = 'sujancom_dev2';
$user = 'sujancom_dev2user';
$pass = 'sujan.sujan';

// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database connection failed.']);
    exit;
}

// Get search term from query parameter
$searchTerm = isset($_GET['query']) ? $_GET['query'] : '';

// Split search term into chunks
$chunks = explode(' ', $searchTerm);

// Prepare SQL query with placeholders
$sql = "SELECT id, title, description, content FROM pastes WHERE";
$conditions = [];
$params = [];

// Create conditions based on chunks
foreach ($chunks as $chunk) {
    if (!empty($chunk)) {
        $conditions[] = "(title LIKE :chunk OR description LIKE :chunk OR content LIKE :chunk)";
        $params[':chunk'] = '%' . $chunk . '%';
    }
}

$sql .= ' ' . implode(' OR ', $conditions);

try {
    // Prepare and execute the query
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    
    // Fetch results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Format the results
    $formattedResults = [];
    foreach ($results as $row) {
        $formattedResults[] = [
            'id' => $row['id'],
            'title' => htmlspecialchars($row['title']),
            'description' => htmlspecialchars($row['description']),
            'content' => htmlspecialchars($row['content']),
        ];
    }
    
    // Return results as JSON
    echo json_encode($formattedResults);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Query failed.']);
}
?>
