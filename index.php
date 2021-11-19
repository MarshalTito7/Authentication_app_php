<?php
    require('config/config.php');
    require('config/db.php');


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

        var_dump($creds);
        
        
    }
    
    //Free the result
    mysqli_free_result($result);

    // CLose Connection
    mysqli_close($conn);

?>

<?php include('inc/header.php'); ?>
    <div class="container my-5">
        <h1 class = " mx-2 my-2">Sign In</h1>
        <div class="card px-4 py-4 my-3">
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                <fieldset>                      
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="form-label mt-4">Username</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter username" name = "username">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1" class="form-label mt-4">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name = "password" placeholder="Password">
                    </div>
                    <input type="submit" name="submit" value = "Login" class="btn btn-warning my-4">  
                </fieldset>
            </form>
        </div>    
    </div>
<?php include('inc/footer.php'); ?>