<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "api-project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user input from the query parameter
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Prepare the SQL query to filter content based on user input
$sql = "SELECT title, description FROM pastes WHERE title LIKE ? OR description LIKE ?";
$stmt = $conn->prepare($sql);

// Bind parameters and execute
$searchParam = "%$search%";
$stmt->bind_param("ss", $searchParam, $searchParam);
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Fetch data and format as JSON
$pastes = [];
while ($row = $result->fetch_assoc()) {
    $pastes[] = $row;
}

// Set header to JSON and output the result
header('Content-Type: application/json');
echo json_encode($pastes);

// Close connection
$stmt->close();
$conn->close();
?>
