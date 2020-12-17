<?php
    include('./connection.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>New Visitor</title>
  </head>
  <body>

  <?php
    $codeToEdit = !empty($_GET['id']) ? $_GET['id'] : false;
    //code to run on form submission
    if(isset($_POST['submit'])) {
        $codeToUpdate = !empty($_POST['codeToUpdate']) ? $_POST['codeToUpdate'] : false;
        $fname = !empty($_POST['fname']) ? $_POST['fname'] : false;
        $lname = !empty($_POST['lname']) ? $_POST['lname'] : false;
        $mobile = !empty($_POST['mobile']) ? $_POST['mobile'] : false;
        $telephone = !empty($_POST['telephone']) ? $_POST['telephone'] : false;
        $homeAddress = !empty($_POST['homeAddress']) ? $_POST['homeAddress'] : false;
        $officeAddress = !empty($_POST['officeAddress']) ? $_POST['officeAddress'] : false;
        $email = !empty($_POST['email']) ? $_POST['email'] : false;
        $description = !empty($_POST['description']) ? $_POST['description'] : false;
        $code = !empty($_POST['code']) ? $_POST['code'] : false;
        $age = !empty($_POST['age']) ? $_POST['age'] : false;
        $nic = !empty($_POST['nic']) ? $_POST['nic'] : false;

        if($codeToUpdate && $fname && $lname && $mobile && $telephone && $homeAddress && $officeAddress && $email && $description && $code && $age && $nic){
            $sql = $conn->prepare("UPDATE visitors SET fname=?,
                                                       lname=?,
                                                       mobile=?,
                                                       telephone=?,
                                                       homeAddress=?,
                                                       officeAddress=?,
                                                       email=?,
                                                       descrption=?,
                                                       code=?,
                                                       age=?,
                                                       nic=? 
                                   WHERE code=?");
            $sql -> bind_param("ssssssssssss",
                                $fname,
                                $lname,
                                $mobile,
                                $telephone,
                                $homeAddress,
                                $officeAddress,
                                $email,
                                $description,
                                $code,
                                $age,
                                $nic,
                                $codeToUpdate);
            $sql->execute();

            if ($sql->affected_rows > 0) {
                header("Location: admin-dashboard.php");
            } else {
                echo "Error: ". $conn->error;
            }
        }else{
            //redirect to same page
            header("Location: ./edit-visitor.php?id=".$codeToEdit);
        }
    }
  ?>

    <?php
        $sql = "SELECT * FROM visitors WHERE code = '$codeToEdit'";
        $result = $conn -> query($sql);
        if ($result -> num_rows > 0) {
            //records exists
            while ($row = $result->fetch_assoc()) {
                echo "
                <form onsubmit='formValidations1()' class='container' method='POST' action=".$_SERVER['PHP_SELF'].">
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label for='fname'>First Name</label>
                            <input type='text' class='form-control' id='fname' name='fname' value=".$row['fname'].">
                        </div>
                        <div class='form-group col-md-6'>
                            <label for='lname'>Last Name</label>
                            <input type='text' class='form-control' id='lname' name='lname' value=".$row['lname'].">
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label for='mobile'>Mobile</label>
                            <input type='text' class='form-control' id='mobile' name='mobile' value=".$row['mobile'].">
                        </div>
                        <div class='form-group col-md-6'>
                            <label for='telephone'>Telephone</label>
                            <input type='text' class='form-control' id='telephone' name='telephone' value=".$row['telephone'].">
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='homeAddress'>Home Address</label>
                        <input type='text' class='form-control' id='homeAddress' name='homeAddress'  value=".$row['homeAddress'].">
                    </div>
                    <div class='form-group'>
                        <label for='officeAddress'>Office Address</label>
                        <input type='text' class='form-control' id='officeAddress' name='officeAddress' value=".$row['officeAddress'].">
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label for='email'>Email</label>
                            <input type='email' class='form-control' id='email' name='email' value=".$row['email'].">
                        </div>
                        <div class='form-group col-md-6'>
                            <label for='description'>Description</label>
                            <input type='text' class='form-control' id='description' name='description' value=".$row['descrption'].">
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='code'>Code</label>
                        <textarea class='form-control' id='code' name='code' rows='3'>".$row['code']."</textarea>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label for='age'>Age</label>
                            <input type='number' class='form-control' id='age' name='age' value=".$row['age'].">
                        </div>
                        <div class='form-group col-md-6'>
                            <label for='nic'>NIC</label>
                            <input type='text' class='form-control' id='nic' name='nic' value=".$row['nic'].">
                        </div>
                    </div>
                    <input id='codeToUpdate' name='codeToUpdate' type='hidden' value='$codeToEdit'>
                    <button type='submit' class='btn btn-primary' name='submit' id='submit'>Submit</button>
                </form>
                ";
            }
        }
    ?>
    
    <!-- Optional JavaScript -->
    <script src="index.js"></script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>