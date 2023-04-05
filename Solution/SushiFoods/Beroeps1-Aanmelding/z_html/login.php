<?php
    require "requires/config.php";
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (trim($_POST['username']) == NULL) {
            Header("Location:login.html?error4");
        }
        if (trim($_POST['password']) == NULL) {
            Header("Location:login.html?error3");
        }        
        $query = $con->query("SELECT * FROM users WHERE username = '".$con->real_escape_string($_POST['username'])."'");

        if ($query->num_rows == 1) {
            $row = $query->fetch_assoc();
            if (password_verify($_POST['password'],$row['password'])) {
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $_POST['username'];
                
                $con->query("UPDATE users SET last_login = '".date('Y-m-d')."' WHERE id = '".$row['id']."'");
                
                if ($_SERVER['HTTP_REFFER'] != "") {
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                } else {
                    Header("Location: ../../SushiSolution". $_SESSION['username']."");

                }
            } else {
                Header("Location: ../../SushiSolution". $_SESSION['username']."");
            }
        } else {
            Header("Location:login.html?error2");
        }
    }
    
?>