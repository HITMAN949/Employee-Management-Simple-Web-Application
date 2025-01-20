<?php
session_start();


$validUsers = [
    ['email' => 'sanaa.el.mansouri@ocpgroup.ma', 'password' => 'sanaa.el.mansouri123', 'name' => 'Sanaa El Mansouri'],
    ['email' => 'adil.moussaoui@ocpgroup.ma', 'password' => 'adil.moussaouid123', 'name' => 'Adil Moussaoui'],
    ['email' => 'nora.el.khattabi@ocpgroup.ma', 'password' => 'nora.el.khattabi123', 'name' => 'Nora El Khattabi']
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
