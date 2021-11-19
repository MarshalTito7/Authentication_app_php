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
                if ($pass !== $cred["password"]) {
                    $flag = 'alert alert-dismissible alert-danger';
                    $message = 'Incorrect Password';
                } elseif ($pass === $cred["password"]) {
                    # code...
                    $flag = 'alert alert-dismissible alert-success';
                    $message = 'Welcome! Sucessful Login';
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
    <div class="container my-5">
        <div class="<?php echo $flag ?>" style = "display : <?php echo $visibility ?>">
            <button type="button" id="close" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>
                <?php echo $message; ?>
            </strong>
        </div>
        <h1 class = " mx-2 my-2">Sign Up</h1>
        <div class="card px-4 py-4 my-3">
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                <fieldset>                      
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="form-label mt-4">Username</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter username" name = "username" required>
                        <small id="emailHelp" class="form-text text-muted">We'll never share your credentials with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1" class="form-label mt-4">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name = "password" placeholder="Password" required>
                    </div>
                    <input type="submit" name="submit" value = "Create Profile" class="btn btn-success my-4">  
                </fieldset>
            </form>
        </div>
    </div>   
<?php include('inc/footer.php'); ?>