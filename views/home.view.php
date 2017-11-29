<?php 
require __DIR__ . '/../app/dbConnection.php';
if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
    $query = "SELECT firstname FROM users WHERE id='" . $_SESSION['user_id'] . "'";
    $user = mysqli_query($db, $query);

    var_dump($user); exit;
}
require 'layouts/header.php';

?>

<div class="container">
    <div class="row">
        <div class=" col-md-offset-4 col-md-4">
            <h2>Sign In</h2>
            
        </div>
    </div>
</div>

<?php
require 'layouts/footer.php';
?>
