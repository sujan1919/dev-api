<?php
// Include the database configuration file
include('config.php');

// Generate a new API key
function generateApiKey() {
    return bin2hex(random_bytes(16)) . time();
}

// Insert the API key into the database
try {
    // Generate API key
    $apiKey = generateApiKey();
    
    // Prepare the SQL query
    $sql = "INSERT INTO api_keys (api_key) VALUES (:api_key)";
    $stmt = $pdo->prepare($sql);
    
    // Execute the query with the generated API key
    $stmt->execute(['api_key' => $apiKey]);
    
} catch (PDOException $e) {
    die('Failed to insert API key: ' . $e->getMessage());
}

// Output the generated API key
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Key</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, rgba(240, 244, 248, 0.8), rgba(228, 233, 240, 0.8));
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            backdrop-filter: blur(10px);
            color: black;
        }

        .container {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 30px;
            width: 80%;
            max-width: 500px;
            text-align: center;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.25);
        }

        h1 {
            margin: 0 0 20px;
            color: black;
            font-size: 2em;
            font-weight: 600;
        }

        .api-key {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 15px;
            font-size: 1.2em;
            color: #ffffff;
            word-wrap: break-word;
            position: relative;
        }

        .copy-icon {
            cursor: pointer;
            font-size: 1.5em;
            color: #00bfae;
            transition: color 0.3s ease;
        }

        .copy-icon:hover {
            color: #00a89a;
        }

        .api-key span {
            flex: 1;
            text-align: left;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            color: black;
        }

        .api-key span::selection {
            background: rgba(0, 191, 174, 0.3);
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>API Key Generated</h1>
        <div class="api-key">
            <span id="apiKey"><?php echo htmlspecialchars($apiKey, ENT_QUOTES); ?></span>
            <span class="copy-icon" onclick="copyApiKey()">&#128203;</span>
        </div>
    </div>
    <script>
        function copyApiKey() {
            const apiKeyText = document.getElementById('apiKey').textContent;
            navigator.clipboard.writeText(apiKeyText).then(() => {
                alert('API key copied to clipboard!');
            }).catch(err => {
                console.error('Failed to copy API key: ', err);
            });
        }
    </script>
</body>
</html>
