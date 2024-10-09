<?php

session_start();


include_once 'connectdb.php';


$username = $password = '';
$error = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

 
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

 
    if ($user && password_verify($password, $user['password'])) {
        
        $_SESSION['username'] = $username;
        $_SESSION['uid'] = $user['uid']; 
        header("Location: add_project.php");
        exit();
    } else {
       
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 300px;
            margin: 100px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .register-link {
            text-align: center;
        }
        .register-link a {
            color: #007bff;
            text-decoration: none;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
       

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $username; ?>">
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
            </div>
            <div class="error"><?php echo $error; ?></div>
            <div>
                <input type="submit" value="Login">
            </div>
        </form>
        <div class="register-link">
            <p>Don't have an account? <a href="register.php">Register here</a>.</p>
        </div>
    </div>
</body>
</html>

