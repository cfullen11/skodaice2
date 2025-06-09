<?php
// Set headers for security and CORS
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

// Database credentials - store these securely in production!
$host = "skodaicedb.cjb4baksbin5.us-east-1.rds.amazonaws.com";
$dbname = "stats";
$username = "webreader";
$password = "fakepwd";

try {
    // Connect to database
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Prepare and execute query
    $stmt = $conn->prepare("SELECT id, name, color, season, league, year FROM teams");
    $stmt->execute();
    
    // Fetch results as associative array
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Return JSON response
    echo json_encode($result);
    
} catch(PDOException $e) {
    // Return error (in production, don't expose detailed error messages)
    http_response_code(500);
    echo json_encode(["error" => "Database error", "message" => "Could not fetch data"]);
}
?>