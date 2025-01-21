<?php
session_start();


$validUsers = [
    ['email' => 'username@email.com', 'password' => 'Password', 'name' => 'username']
    
];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $authenticated = false;
    foreach ($validUsers as $user) {
        if ($user['email'] === $email && $user['password'] === $password) {
            
            $_SESSION['user'] = $user;
            $authenticated = true;
            break;
        }
    }

    if ($authenticated) {
        
        header("Location: employeelist.php");
        exit();
    } else {
        
        header("Location: index.html?error=InvalidCredentials");
        exit();
    }
} else {
    
    header("Location: index.html");
    exit();
}
?>
