<?php
    require('config/config.php');
    require('config/db.php');

    $flag = 0;
    $message = 'hello';
    $visibility = 'none';

    // check for submit
    if(isset($_POST['submit'])){
        // echo 'submitted';
        // Get form data
        $user_id = mysqli_real_escape_string($conn ,$_POST['username']);
        $pass = mysqli_real_escape_string($conn, $_POST['password']);
        $new_pass = mysqli_real_escape_string($conn, $_POST['new_password']);
        $hash2 = password_hash($new_pass, PASSWORD_DEFAULT);

        $query = "SELECT * FROM login_creds WHERE username LIKE '$user_id'";

 
        // get result
        $result = mysqli_query($conn , $query);

        // Fetch data
        $creds = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if (empty($creds)) {
            # code...
            $flag = 'alert alert-dismissible alert-danger';
            $message = 'Invalid username';
        } else {
            # code...
            foreach($creds as $cred){
                if (password_verify($pass, $cred['password'])) {
                    # code...
                    $flag = 'alert alert-dismissible alert-success';
                    
                    $query = "UPDATE login_creds SET
                                password = '$hash2'
                            WHERE username LIKE '$user_id'";
                    if(mysqli_query($conn,$query)){
                        $message = 'Password sucessfully updated!';
                    }
                    else {
                        echo 'ERROR: '. mysqli_error($conn);
                    }
                }
                else{
                    $flag = 'alert alert-dismissible alert-danger';
                    $message = 'Incorrect Password';
                }
            }
            
        }
        $visibility = 'block';
        
        //Free the result
        mysqli_free_result($result);
        
    }

    // CLose Connection
    mysqli_close($conn);
?>

<?php include('inc/header.php'); ?>
    <div class="conatiner mx-5 my-5 px-5">
        <div class="<?php echo $flag ?>" style = "display : <?php echo $visibility ?>">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong><?php echo $message; ?></strong> 
        </div>
        <h1 class = " mx-2 my-2">Change Password</h1>
        <div class="card px-4 py-4 my-3">
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                <fieldset>
                    <div class="form-group">
                        <label class="form-label mt-4">Username</label>
                        <input type="text" class="form-control" name="username" placeholder="Enter username" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label mt-4">Old Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter old password" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label mt-4">New Password</label>
                        <input type="password" class="form-control" name="new_password" placeholder="Enter new password" required>
                    </div>
                    <input type="submit" name="submit" value = "Change" class="btn btn-warning my-4"> 
                </fieldset>
            </form>
        </div>
    </div>
<?php include('inc/footer.php'); ?>