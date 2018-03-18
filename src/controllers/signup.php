
<?php

require_once(DP_PLUGIN_DIR . 'helpers.php');
require_once(DP_PLUGIN_DIR . 'models/user.php');
require_once(DP_PLUGIN_DIR . 'class.passwordhash.php');


if ( isset( $_POST['signup_nonce'] ) && !wp_verify_nonce( $_POST['signup_nonce'], 'submit' ) ) {
    die( 'Bad token' );
}

$error = '';
$info = '';

if ( isset( $_POST['signup_nonce'] ) ) {
    try {
        $first = valid_name(not_empty($_POST['first_name']));
        $last = valid_name(not_empty($_POST['last_name']));
        $email = valid_email(not_empty($_POST['email']));
        $pass = valid_password(not_empty($_POST['password']));
        $pass2 = not_empty($_POST['confirm_password']);

        if($pass !== $pass2)
            throw new Exception("Passwords do not match");

        $hash = Password::hash($pass);

        $userData = array(
            'first_name' => $first,
            'last_name' => $last,
            'email' => $email,
            'password' => $hash,
            'role_id' => 1
        );

        // Check that the email address is not taken already
        $inuse = User::query_id_from_email($email);
        if(count($inuse) === 0)
        {
          $user = new User($userData);
          $user->commit();

          $info = "Account created";
        }
        else
        {
          $error = "$email already has associated account";
          // TODO consider refilling input values minus email
        }
    }
    catch (Exception $e) {
        error_log($e);

        $error = $e->getMessage();
        if ( get_class($e) === PDOException) {
            $error = "Database error";
        }
    }
}

DanceParty::render_view_with_template( 'signup_view.php',
    array(
        'error' => $error,
        'info' => $info
    ) );

?>
