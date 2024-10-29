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
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Retrieve API key from URL
$apiKey = isset($_GET['api-key']) ? $_GET['api-key'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Validate the API key
$sql = "SELECT COUNT(*) FROM api_keys WHERE api_key = :api_key";
$stmt = $pdo->prepare($sql);
$stmt->execute(['api_key' => $apiKey]);

if ($stmt->fetchColumn() == 0) {
    http_response_code(403);
    echo json_encode(['error' => 'Invalid API key']);
    exit;
}

// Prepare and execute the SQL query
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

// Set the content type to JSON
header('Content-Type: application/json');

// Return results in JSON format
echo json_encode($results);
?>
