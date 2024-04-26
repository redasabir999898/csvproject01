<?php
// Correct password
$correct_password = "sabir*01*08*2004";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get entered password
    $entered_password = $_POST['password'];

    // Verify password
    if ($entered_password === $correct_password) {
        // Rediriger vers la page csvsimu01.php
        header('Location: csvsimu01.php');
        exit; // Assure que le script s'arrête après la redirection
    } else {
        echo '<p style="color: red; text-align: center;">Incorrect password. Please try again.</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Protected Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 100px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2, h3 {
            color: #333;
            text-align: center;
        }

        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .code {
            display: none;
            margin-top: 20px;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <?php if(isset($show_page_content) && $show_page_content): ?>
    <!-- Display the page content if the password is correct -->
    <div class="container">
        <h1>Password Protected Page</h1>
        <div class="code">
            <h2>Your Code Here</h2>
            <!-- Include the content of csvsimu01.php -->
            <?php include 'csvsimu01.csv'; ?>
        </div>
    </div>
    <?php else: ?>
    <!-- Display the password form if the password is not yet entered or incorrect -->
    <div class="container">
        <h1>Password Protected Page</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="password">Enter Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Submit">
        </form>
        <?php if(isset($password_error)): ?>
        <!-- Display an error message if the password is incorrect -->
        <p style="color: red; text-align: center;"><?php echo $password_error; ?></p>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</body>
</html>
