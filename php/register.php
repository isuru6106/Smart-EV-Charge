<?php

include "db.php";

/* GET DATA */

$full_name = trim($_POST['full_name']);

if(
!preg_match(
"/^[A-Za-z ]{2,200}$/",
$full_name
)
){

    die(
    "Name can contain only letters and spaces."
    );

}

$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$password = $_POST['password'];
$role = $_POST['role'];
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$password = $_POST['password'];
$role = $_POST['role'];

/* VALIDATION */

/* Empty fields */

if (
    empty($full_name) ||
    empty($email) ||
    empty($phone) ||
    empty($password) ||
    empty($role)
) {
    echo "
    <script>
    alert('Please fill all required fields');
    window.history.back();
    </script>";
    exit();
}

/* Email validation */

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "
    <script>
    alert('Invalid email address');
    window.history.back();
    </script>";
    exit();
}

/* Sri Lankan phone validation */

if (!preg_match('/^0[0-9]{9}$/', $phone)) {
    echo "
    <script>
    alert('Invalid phone number');
    window.history.back();
    </script>";
    exit();
}

/* Password validation */

if (
    !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/', $password)
) {
    echo "
    <script>
    alert('Password must contain at least 8 characters, uppercase, lowercase, number and special character');
    window.history.back();
    </script>";
    exit();
}

/* CHECK DUPLICATE EMAIL */

$check_stmt = $conn->prepare(
    "SELECT id FROM users WHERE email = ?"
);

$check_stmt->bind_param("s", $email);
$check_stmt->execute();

$result = $check_stmt->get_result();

if ($result->num_rows > 0) {

    echo "
    <script>
    alert('Email already exists');
    window.history.back();
    </script>";
    exit();
}

/* HASH PASSWORD */

$password_hash = password_hash(
    $password,
    PASSWORD_DEFAULT
);

/* INSERT USER */

$stmt = $conn->prepare(
    "INSERT INTO users
    (
        full_name,
        email,
        phone,
        password_hash,
        role
    )
    VALUES
    (
        ?, ?, ?, ?, ?
    )"
);

$stmt->bind_param(
    "sssss",
    $full_name,
    $email,
    $phone,
    $password_hash,
    $role
);

if ($stmt->execute()) {

    $user_id = $conn->insert_id;

    /* EV OWNER */

    if ($role == "ev_owner") {

        $vehicle_model =
            $_POST['vehicle_model'];

        $battery_capacity =
            $_POST['battery_capacity'];

        $vehicle_stmt = $conn->prepare(
            "INSERT INTO vehicles
            (
                user_id,
                model,
                battery_capacity
            )
            VALUES
            (
                ?, ?, ?
            )"
        );

        $vehicle_stmt->bind_param(
            "iss",
            $user_id,
            $vehicle_model,
            $battery_capacity
        );

        $vehicle_stmt->execute();
    }

    /* CENTER OWNER */

    if ($role == "center_owner") {

        $center_name = $_POST['center_name'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $charging_ports = $_POST['charging_ports'];
        $price_per_kwh = $_POST['price_per_kwh'];
        $open_time = $_POST['open_time'];
        $close_time = $_POST['close_time'];
        $description = $_POST['description'];
        $facilities = $_POST['facilities'];
        $emergency_contact = $_POST['emergency_contact'];

        $center_stmt = $conn->prepare(
            "INSERT INTO charging_centers
            (
                owner_id,
                center_name,
                address,
                city,
                latitude,
                longitude,
                total_slots,
                available_slots,
                price_per_kwh,
                open_time,
                close_time,
                description,
                facilities,
                emergency_contact,
                status
            )
            VALUES
            (
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Open'
            )"
        );

        $center_stmt->bind_param(
            "isssssiidsssss",
            $user_id,
            $center_name,
            $address,
            $city,
            $latitude,
            $longitude,
            $charging_ports,
            $charging_ports,
            $price_per_kwh,
            $open_time,
            $close_time,
            $description,
            $facilities,
            $emergency_contact
        );

        $center_stmt->execute();
    }

    echo "
    <script>
    alert('Registration Successful!');
    window.location.href='../login.html';
    </script>";

} else {

    echo "
    <script>
    alert('Registration failed');
    window.history.back();
    </script>";
}

$conn->close();

?>