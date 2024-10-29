<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation</title>
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
    color: #000000; 
    overflow: auto; 
}

.container {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    padding: 20px;
    width: 90%;
    max-width: 600px;
    text-align: center;
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.25);
    box-sizing: border-box;
    max-height: 90vh; 
    overflow-y: auto;
}

h1 {
    margin: 0 0 20px;
    color: #000000; 
    font-size: 1.8em;
    font-weight: 600;
}

h2 {
    color: #000000; 
    font-size: 1.4em;
    margin: 20px 0;
}

p {
    font-size: 1em;
    color: #000000; 
    line-height: 1.5;
    margin: 0 0 15px;
}

.code {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 6px;
    padding: 10px;
    border: 1px solid rgba(255, 255, 255, 0.25);
    font-family: monospace;
    color: #00bfae;
    margin: 10px 0;
    word-wrap: break-word;
    overflow-x: auto;
}

a {
    color: #00bfae;
    text-decoration: none;
    font-weight: bold;
}

a:hover {
    text-decoration: underline;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    h1 {
        font-size: 1.5em;
    }

    h2 {
        font-size: 1.2em;
    }

    p {
        font-size: 0.9em;
    }

    .code {
        font-size: 0.9em;
    }
}


    </style>
</head>
<body>
    <div class="container">
        <h1>API Documentation</h1>
        <p>Welcome to the API documentation. Follow the instructions below to obtain an API key and use it to make requests.</p>
        
        <h2>1. Get Your API Key</h2>
        <p>To get an API key, send a request to the following URL:</p>
        <div class="code">
            <a href="https://api.sujan1919.com.np/get-api.php" target="_blank">https://api.sujan1919.com.np/get-api.php</a>
        </div>
        <p>You will receive an API key in response that you can use to access the API.</p>
        
        <h2>2. Make API Requests</h2>
        <p>Once you have your API key, you can use it to search by making a request to:</p>
        <div class="code">
            https://api.sujan1919.com.np/search.php?api-key=YOUR_API_KEY&search=YOUR_QUERY
        </div>
        <p>Replace <code>YOUR_API_KEY</code> with the API key you obtained, and <code>YOUR_QUERY</code> with the term you want to search for.</p>
        
        <h2>Example Request</h2>
        <p>Here is an example of a request:</p>
        <div class="code">
            https://api.sujan1919.com.np/search.php?api-key=949074d0629fb8484d16a4e98f80ea431726645279&search=destructor
        </div>
        <p>This will search for the term "destructor".</p>
    </div>
</body>
</html>
