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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <title>Dashboard</title>
</head>
<body>

<?php
    session_start();
    //sql to delete a record
    $deleteCode = !empty($_GET['id']) ? $_GET['id'] : false;
    
    if($deleteCode){
        echo "<script>
            window.alert(".$deleteCode.")
        </script>";

        $sql = "DELETE FROM visitors WHERE code='$deleteCode'";

        if ($conn->query($sql) === TRUE) {
            header("Location: admin-dashboard.php");
        } else {
            echo "Error deleting record: " . $conn->error;
        }

        $conn->close();
    }
?>
<div class="container">
    <img height="200px" width="200px" class="rounded float-left img-fluid img-thumbnail" src="<?php echo $_SESSION['current_user_image_url']; ?>" alt="" />
    <div class="form-row">
        <button type="button" class="btn btn-danger"><a name="logout" id="logout" href="logout.php">Logout</a></button>
    </div>
    <br>
</div>

<form onsubmit="searchValidations()" class="container" method="GET" action="search.php">
    <div class="container">
        <div class="form-row">
            <div class="form-group col-md-6">
                <input type="text" class="form-control" id="query" name="query" placeholder="Search">
            </div>
            <div class="form-group col-md-6">
                <button type="submit" class="btn btn-success" name="submit" id="submit">Submit</button>
            </div>
        </div>
    </div>
</form>

<div class="container">
    <h3 align="center"><?php echo "You are logged in as " . $_SESSION['current_user_fname'];?></h3><br />  
        <div class="table-responsive" id="pagination_data">  
    </div>
</div>

<script>  
 $(document).ready(function(){  
      load_data();  
      function load_data(page)  
      {  
           $.ajax({  
                url:"pagination.php",  
                method:"POST",  
                data:{page:page},  
                success:function(data){  
                     $('#pagination_data').html(data);  
                }  
           })  
      }  
      $(document).on('click', '.pagination_link', function(){  
           var page = $(this).attr("id");  
           load_data(page);  
      });  
 });  
 </script>

<!-- Optional JavaScript -->
    <script src="index.js"></script>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
