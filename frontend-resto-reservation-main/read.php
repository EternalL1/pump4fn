<?php

include ("db.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounts</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>List of Users</h2>
        <a class="btn btn-primary" href=" /frontend-resto-reservation-main/register.php " role="button">Register</a>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">username</th>
                    <th scope="col">username</th>
                    <th scope="col">password</th>
                    <th scope="col">phone</th>
                    <th scope="col">email</th>
                </tr>
            </thread>
            <tbody>
                <?php
                $sql = "SELECT * FROM users";
                $result = mysqli_query($conn, $sql);
                if($result){
                    $row=mysqli_fetch_assoc($result);{
                    $id =  $row['id'];   
                    $username = $row['username'];
                    $password = $row['password'];
                    $phone = $row['phone'];
                    $email = $row['email'];    
                    echo ' <tr>
                    <th scope= "row">'.$id.'</th>
                    <td>'.$username.'</td>
                    <td>'.$password.'</td>
                    <td>'.$phone.'</td>
                    <td>'.$email.'</td>
                </tr>';    
                    
                    
                    }
                
                }
                
                
                ?>
                <tr>        
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <td>
                        <a class= 'btn btn-primary btn-sm' href = '/frontend-resto-reservation-main/edit.php'> Edit</a>
                        <a class= 'btn btn-primary btn-sm' href = '/frontend-resto-reservation-main/delete.php'> Delete</a>
                    </td>
                </tr>
            </tbody>     
        </div>       
</body>
</html>