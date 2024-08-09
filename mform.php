<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST['model']) && isset($_POST['capacity']) && isset($_POST['licensePlate']) &&
        isset($_POST['busImage1']) && isset($_POST['busImage2']) && isset($_POST['busImage3']) &&
        isset($_POST['driverName']) && isset($_POST['licenseNumber']) && isset($_POST['contact']) &&
        isset($_POST['startlocation']) && isset($_POST['endlocation']) &&
        isset($_POST['distance']) && isset($_POST['duration']) &&
        isset($_POST['departureTime']) && isset($_POST['arrivalTime']) && isset($_POST['date'])

    ) {
        $model = $_POST['model'];
        $capacity = $_POST['capacity'];
        $licensePlate = $_POST['licensePlate'];
        $busImage1 = $_POST['busImage1'];
        $busImage2 = $_POST['busImage2'];
        $busImage3 = $_POST['busImage3'];
        $driverName = $_POST['driverName'];
        $licenseNumber = $_POST['licenseNumber'];
        $contact = $_POST['contact'];
        $startLocation = $_POST['startlocation'];
        $endLocation = $_POST['endlocation'];
        $distance = $_POST['distance'];
        $duration = $_POST['duration'];
        $departureTime = $_POST['departureTime'];
        $arrivalTime = $_POST['arrivalTime'];
        $date = $_POST['date'];
        

        $stmt = $connection->prepare("INSERT INTO buses (model, capacity, license_plate) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $model, $capacity, $licensePlate);
        $stmt->execute();
        $bus_id = $stmt->insert_id;

        $stmt = $connection->prepare("INSERT INTO bus_images (bus_id, image1_url, image2_url, image3_url) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $bus_id, $busImage1, $busImage2, $busImage3);
        $stmt->execute();

        $stmt = $connection->prepare("INSERT INTO drivers (bus_id, name, license_number, contact) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $bus_id, $driverName, $licenseNumber, $contact);
        $stmt->execute();
        // $driver_id = $stmt->insert_id;

        $stmt = $connection->prepare("INSERT INTO route (bus_id, start_location, end_location, distance, duration) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issii", $bus_id, $startLocation, $endLocation, $distance, $duration);
        $stmt->execute();

        $stmt = $connection->prepare("INSERT INTO schedules (bus_id, departure_time, arrival_time, date) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $bus_id, $departureTime, $arrivalTime, $date);
        $stmt->execute();

        header("Location: dashboard.html");
        exit();
    } else {
        echo "All form fields are required.";
    }
} else {
    echo "Form submission method not detected.";
}
?>
