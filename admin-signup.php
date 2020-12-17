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
    <title>Signup</title>
</head>
<body>

<?php
    //code to run on form submission
    if(isset($_POST['submit'])) {
        $fname = !empty($_POST['fname']) ? $_POST['fname'] : false;
        $email = !empty($_POST['email']) ? $_POST['email'] : false;
        $password = !empty($_POST['password']) ? $_POST['password'] : false;
        $confirmPassword = !empty($_POST['confirm-password']) ? $_POST['confirm-password'] : false;

        $fileName = !empty(basename($_FILES["image-file"]["name"])) ? basename($_FILES["image-file"]["name"]) : 'Not provided';

        //if image is uploadeds
        if($fileName){
            $targetDir = "uploads/";
            $targetFilePath = $targetDir . $email . $fileName;
            $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

            // Allow certain file formats
            $allowTypes = array('jpg','png','jpeg','gif','pdf');
            if(in_array($fileType, $allowTypes)){
                // Upload file to server
                if(move_uploaded_file($_FILES["image-file"]["tmp_name"], $targetFilePath)){
                    $statusMsg = "File upload successful";
                }else{
                    $statusMsg = "Sorry, there was an error uploading your file.";
                }
            }else{
                $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
            }
            // Display status message
            echo $statusMsg;
        }

        if($fname && $email && $password && $confirmPassword && $password == $confirmPassword){
            //hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (fname, email, hashedPassword, image_file)
                    VALUES ('$fname','$email','$hashedPassword', '$targetFilePath')";

            if ($conn->query($sql) === TRUE) {
                echo "New user created successfully";
            } else {
                if($conn->error == "Duplicate entry '$email' for key 'PRIMARY'"){
                    echo "<script>
                            window.alert('Email already exists')
                        </script>";
                }else{
                    echo "Error: ". $conn->error;
                }
            }
            $conn->close();
        }else{
            //redirect to same page
            //header("Location: ./admin-signup.php");
        }
    }
?>

<form enctype="multipart/form-data" onsubmit="formValidations2()" class="container" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="fname">Name</label>
            <input type="text" class="form-control" id="fname" name="fname" placeholder="Name">
        </div>
        <div class="form-group col-md-6">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Email">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </div>
        <div class="form-group col-md-6">
            <label for="confirm-password">Confirm Password</label>
            <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="Confirm Password">
        </div>
    </div>
    <div class="form-group">
        <label for="image">Image</label>
        <input type="file" class="form-control" id="image-file" name="image-file">
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