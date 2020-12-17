<?php
    include('./connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Login</title>
</head>
<body>

<?php
    //code to run on form submission
    if(isset($_POST['submit'])) {
        $email = !empty($_POST['email']) ? $_POST['email'] : false;
        $password = !empty($_POST['password']) ? $_POST['password'] : false;

        if($email && $password){
            //hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = $conn -> query($sql);

            if ($result -> num_rows == 1) {
                while ($row = $result->fetch_assoc()) {
                    $hash = $row['hashedPassword'];
                    if(password_verify($password, $hash)){
                        //create session
                        session_start();
                        $_SESSION['current_user_fname'] = $row['fname'];
                        $_SESSION['current_user_email'] = $row['email'];
                        $_SESSION['current_user_image_url'] = $row['image_file'];

                        header("Location: ./admin-dashboard.php");
                    }else{
                        echo "<script>
                                window.alert('Password Incorrect!')
                            </script>";
                    }
                }
            } else {
                echo "<script>
                        window.alert('Email Incorrect!')
                    </script>";
            }
            $conn->close();
        }else{
            //redirect to same page
            //header("Location: ./admin-signup.php");
        }
    }
?>

<form onsubmit="loginValidations()" class="container" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Email">
        </div>
        <div class="form-group col-md-6">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </div>
    </div>
    <button type="submit" class="btn btn-primary" name="submit" id="submit">Submit</button>
</form>

<!-- Optional JavaScript -->
    <script src="index.js"></script>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>