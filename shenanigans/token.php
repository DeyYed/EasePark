<?php
session_start();

// Generate a form token if it doesn't exist
if (empty($_SESSION['form_token'])) {
    $_SESSION['form_token'] = bin2hex(random_bytes(32));
}

// Initialize a variable to hold the success message
$message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the form token is valid
    if (isset($_POST['form_token']) && hash_equals($_SESSION['form_token'], $_POST['form_token'])) {
        // Form token is valid
        $message = 'Form submitted successfully!';
        echo $message;
    } else {
        // Invalid form token
        $message = 'Invalid form token.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Token Test</title>
</head>
<body>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <input type="hidden" name="form_token" value="<?php echo htmlspecialchars($_SESSION['form_token'], ENT_QUOTES, 'UTF-8'); ?>">
    <button type="submit">Submit</button>
  </form>
</body>
</html>
