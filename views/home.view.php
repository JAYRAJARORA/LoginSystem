<?php 
// making connections to execute queries and checking sessions
require __DIR__ . '/../app/dbConnection.php';

if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $query = "SELECT username,firstname,lastname,role_id FROM users WHERE id='" . $_SESSION['user_id'] . "' LIMIT 1";
    $user = mysqli_query($db, $query);
    $row = $user->fetch_assoc();
    
    if($row['role_id']==2){
        $query_for_admin = "SELECT firstname,lastname,email FROM users where username!='" . $row['username'] . "' LIMIT 50";
        $show_users_for_admin = mysqli_query($db, $query_for_admin);
    }
}
else {
    header('Location: login.view.php');
}
// styling the page
require 'layouts/header.php';

?>

<div class="container">
    <div class="row">
        <div class=" col-md-offset-4 col-md-4">
            <h1>Your Profile</h1>
            <!-- checking the values before displaying -->
            <?php if(isset($_SESSION['user_id'])&& !empty($_SESSION['user_id'])){?>
            <p>Welcome  <span class="text-info">  <?php  echo $row['firstname']." ".$row['lastname']; ?></span> 
            </p>
        <h3> List of users are:</h3>
        </div>
         <?php } if ($row['role_id']==2 && $show_users_for_admin->num_rows > 0) {?>
        
        <div class=" col-md-offset-2 col-md-6">
            <table class="table">
                <thead><tr>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Email</th>
            </tr>
            </thead> 
            <tbody>
                <?php while($row = $show_users_for_admin->fetch_assoc()) {?>
                <tr>
                    <td><?php echo $row['firstname'];?></td>
                    <td><?php echo $row['lastname']?></td>
                    <td><?php echo $row['email']?></td>
                </tr>
                <?php } ?>
            </tbody>        
            <?php } ?> 
        </div>
    </div>
</div>

<?php
require 'layouts/footer.php';
?>
