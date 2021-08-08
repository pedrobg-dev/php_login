<?php

    session_start();
    
    if (isset($_SESSION['user_id'])) {
        header('Location: /php_login');
    }

    require 'database.php';

    $message = '';

    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $records = $conn->prepare('SELECT id, email, password FROM users WHERE email=:email');
        $records->bindParam(':email', $_POST['email']);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);
    

        if(count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
            $_SESSION['user_id'] = $results['id'];
            header('Location: /php_login');
        } else {
            $message = 'Sorry, Those credentials do not match';
        }

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">    
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">    
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Login</title>
</head>
<body>
    <?php require 'partials/header.php' ?>
    <h1>Login</h1>
    <span>or <a href="singup.php">SingUp</a></span>

    <?php if(!empty($message)): ?>
        <p><?= $message ?></p>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <input type="text" name="email" placeholder="Enter your mail">
        <input type="password" name="password" placeholder="Enter your password">
        <input type="submit" value="Send">
    </form>

</body>
</html>