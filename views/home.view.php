<?php 
// making connections to execute queries and checking sessions
require __DIR__ . '/../app/dbConnection.php';

if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $query = "SELECT firstname,lastname FROM users WHERE id='" . $_SESSION['user_id'] . "' LIMIT 1";
    $user = mysqli_query($db, $query);
    $row = $user->fetch_assoc();
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
            <?php }?>
        </div>
    </div>
</div>

<?php
require 'layouts/footer.php';
?>
