<?php
    include('./connection.php');
    include('./exportToPdf.php');
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
    <title>Search Results</title>
</head>

<body>

<?php
    // gets value sent over search form
    $query = $_GET['query'];

    $min_length = 0;
    // you can set minimum length of the query if you want

    if (strlen($query) >= $min_length) { // if query length is more or equal minimum length then

        $query = htmlspecialchars($query);
        // changes characters used in html to their equivalents, for example: < to &gt;

        $query = mysqli_real_escape_string($conn,$query);
        // makes sure nobody uses SQL injection

        $raw_results = mysqli_query($conn,"SELECT * FROM visitors WHERE (`fname` LIKE '%" . $query . "%') OR (`code` LIKE '%" . $query . "%')") OR die(mysqli_error($conn));

        $numOfResults = mysqli_num_rows($raw_results);

        if ($numOfResults > 0) { // if one or more rows are returned do following
            echo "<div class='container'>
                    <table class='table table-bordered'>
                        <h3 align='center'> Searching for: ". $query ."</h3><br/> 
                        <tr>
                            <th width='20%'>Name</th>                                    <th width='20%'>Number</th>
                            <th width='20%'>Email</th>
                            <th width='20%'>Address</th>
                            <th width='20%'>Code</th>
                        </tr>
            ";
            $output = '';
            while($row = mysqli_fetch_array($raw_results)){
                $output .= '
                        <tr>  
                            <td>'.$row["fname"].' '.$row["lname"].'</td>
                            <td>'.$row["mobile"].'</td>
                            <td>'.$row["email"].'</td>
                            <td>'.$row["homeAddress"].'</td>
                            <td>'.$row["code"].'</td>
                            <td><span><a href="edit-visitor.php?id='.$row["code"].'">Edit</a></span></td>
                            <td><span><a href="admin-dashboard.php?id='.$row['code'].'">Delete</a></span></td>
                        </tr>';

                echo '  
                        <tr>  
                            <td>'.$row["fname"].' '.$row["lname"].'</td>
                            <td>'.$row["mobile"].'</td>
                            <td>'.$row["email"].'</td>
                            <td>'.$row["homeAddress"].'</td>
                            <td>'.$row["code"].'</td>
                            <td><span><a href="edit-visitor.php?id='.$row["code"].'">Edit</a></span></td>
                            <td><span><a href="admin-dashboard.php?id='.$row['code'].'">Delete</a></span></td>
                        </tr>
                ';  
            }
            echo '  </table>
                    <br/>
                    <div style="width: 50%; margin: 0 auto;">
                        <div class="row">
                            <form method="post" class="col-md-6">
                                <input type="submit" name="export-excel" class="btn btn-success" value="Export to Excel" />
                            </form>
                            <form method="post" class="col-md-6">
                                <input type="submit" name="export-pdf" class="btn btn-success" value="Export to PDF" />
                            </form>
                        </div>
                    </div>
                 </div>
            ';

        } else { // if there is no matching rows do following
            echo "No results";
        }
    } else { // if query length is less than minimum
        echo "Minimum length is " . $min_length;
    }
?>

<?php
    //export to excel
    if(isset($_POST["export-excel"])){
        $filename ="download.xls";
        header('Content-type: application/ms-word');
        header('Content-Disposition: attachment; filename='.$filename);
    }

    //export to PDF
    if(isset($_POST["export-pdf"])){
        createPDF('<table>'.$output.'</table>');
    }
?>

</body>

</html>