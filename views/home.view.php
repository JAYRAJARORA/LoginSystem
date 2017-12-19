<?php

require __DIR__ . '/../app/dbConnection.php';

if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $query = "SELECT username,firstname,lastname,role_id FROM users 
              WHERE id='" . $_SESSION['user_id'] . "' LIMIT 1";
    $user = mysqli_query($db, $query);
    $row = $user->fetch_assoc();

    if (2 === $row['role_id']) {
        $query_for_admin = "SELECT username,firstname,lastname,email,address,gender,
                            city,zip FROM users where username!='" . $row['username'] . "' 
                            ORDER BY address DESC LIMIT 10";
        $show_users_for_admin = mysqli_query($db, $query_for_admin);
    }
} else {
    header('Location: login.view.php');
}

/* styling the page */
require 'layouts/header.php';

?>

<div class="container">
    <div class="row">
        <div class=" col-md-offset-4 col-md-4">
            <h1>Your Profile</h1>
            <?php
            if (isset($_SESSION['user_id'])
                && !empty($_SESSION['user_id'])
            ){
            ?>
            <p>Welcome
                <span class="text-info">
                    <b><?php
                        echo $row['firstname'] .' '. $row['lastname'];
                        ?>
                    </b>
                </span>
            </p>
        </div>
    </div>
    <br/>
    <?php
    if (2 === $row['role_id']
        && ($show_users_for_admin->num_rows > 0)
    ){
    ?>
    <div class="container">
        <div class="row">
            <h3> List of users are:</h3>
            <table class="table">
                <thead>
                <tr>
                    <th>Username</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Pincode</th>
                    <th>Gender</th>
                </tr>
                </thead>
                <tbody>
                <?php
                while ($row = $show_users_for_admin->fetch_assoc()) {
                ?>
                <tr>
                <td><?php echo $row['username'] ?></td>
                <td><?php echo $row['firstname']; ?></td>
                <td><?php echo $row['lastname'] ?></td>
                <td><?php echo $row['email'] ?></td>
                <td><?php echo $row['address'] ?></td>
                <td><?php echo $row['city'] ?></td>
                <td><?php echo $row['zip'] ?></td>
                <td><?php echo $row['gender'] ?></td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
            <?php }
            } ?>
        </div>
    </div>
</div>

<?php
require 'layouts/footer.php';
?>
