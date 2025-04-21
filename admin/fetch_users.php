<?php
require('../connection.php');

header('Content-Type: application/json');

$response = []; // Initialize the response array

// Check if a search term is provided
if (isset($_POST['search']) && $_POST['search'] !== '') {
    // Sanitize the input by trimming and removing all spaces
    $searchValue = $_POST['search'];
    $searchValue = trim($searchValue);  // Remove leading and trailing spaces
    $searchValue = preg_replace('/\s+/', '', $searchValue); // Remove all internal spaces

    // Add wildcard characters for LIKE search
    $searchValue = '%' . $searchValue . '%';

    // SQL query to search and include 'is_deleted' in the WHERE clause
    $sql = "SELECT *, 
            CASE 
                WHEN is_active = 1 THEN 'Active' 
                ELSE 'Blocked' 
            END AS status 
            FROM rfid_user 
            WHERE (first_name LIKE ? 
                OR last_name LIKE ? 
                OR rfid_uid LIKE ? 
                OR reg_date LIKE ? 
                OR plate_number LIKE ? 
                OR (CASE 
                    WHEN is_active = 1 THEN 'Active' 
                    ELSE 'Blocked' 
                END LIKE ?)
                OR is_deleted LIKE ?)  -- Include is_deleted in search
            ORDER BY reg_date DESC";  // Added DESC to order by registration date in descending order

    // Prepare and execute the statement
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$searchValue, $searchValue, $searchValue, $searchValue, $searchValue, $searchValue, $searchValue]);
} else {
    // If no search term is provided, return all users (active or blocked) ordered by reg_date DESC
    // But only for users where is_deleted = 'UlXzoe'
    $sql = "SELECT *, 
            CASE 
                WHEN is_active = 1 THEN 'Active' 
                ELSE 'Blocked' 
            END AS status 
            FROM rfid_user 
            WHERE is_deleted = 'UlXzoe'  -- Only fetch users where is_deleted = 'UlXzoe'
            ORDER BY reg_date DESC";  // Ordering by reg_date DESC to get the most recent users first
    
    // Execute the query
    $stmt = $pdo->query($sql);
}

// Fetch the rows from the database
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Add total count to the response
$response['total'] = count($rows);
$response['data'] = $rows;

// Return the response as JSON
echo json_encode($response);
?>
