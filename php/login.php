<?php

session_start();
include "db.php";

/* Only allow POST requests */

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../login.html");
    exit();
}

/* Get form data */

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

/* Check empty fields */

if (empty($email) || empty($password)) {
    die("Please enter email and password.");
}

/* Secure query */

$stmt = $conn->prepare("
    SELECT
        id,
        full_name,
        email,
        password_hash,
        role
    FROM users
    WHERE email = ?
");

$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

/* User exists */

if ($result->num_rows == 1) {

    $user = $result->fetch_assoc();

    /* Verify password */

    if (password_verify($password, $user['password_hash'])) {

        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['role'] = $user['role'];

        /* Redirect by role */

        if ($user['role'] == 'admin') {

            header("Location: ../admin/admin-dashboard.html");
            exit();

        } elseif ($user['role'] == 'center_owner') {

            header("Location: ../center/center-dashboard.html");
            exit();

        } elseif ($user['role'] == 'ev_owner') {

            header("Location: ../owner/owner-dashboard.html");
            exit();

        } else {

            echo "Invalid user role.";
            exit();

        }

    } else {

        echo "

    <script>

    alert('❌ Wrong Password! Please try again.');

    window.location.href='../login.html';

    </script>

";

exit();

    }

} else {

    echo "User not found.";
    exit();

}

$stmt->close();
$conn->close();

?>