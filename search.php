<?php
include 'config.php';

if(isset($_GET['start_location']) && isset($_GET['end_location'])) {
    $startLocation = $_GET['start_location'];
    $endLocation = $_GET['end_location'];

    $sql = "SELECT buses.*, route.*, bus_images.image1_url, bus_images.image2_url, bus_images.image3_url 
        FROM buses 
        INNER JOIN route ON buses.bus_id = route.bus_id
        INNER JOIN bus_images ON buses.bus_id = bus_images.bus_id
        WHERE route.start_location = ? AND route.end_location = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ss", $startLocation, $endLocation);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
       while ($row = $result->fetch_assoc()) {
            echo "<p>Bus Model: " . $row['model'] . "</p>";
            echo "<p>Capacity: " . $row['capacity'] . "</p>";
            echo "<p>License Plate: " . $row['license_plate'] . "</p>";
            if (isset($row['image1_url'])) {
                echo "<img src='" . $row['image1_url'] . "' alt='Image 1'>";
            }
            // if (isset($row['image2_url'])) {
            //     echo "<img src='" . $row['image2_url'] . "' alt='Image 2'>";
            // }
            // if (isset($row['image3_url'])) {
            //     echo "<img src='" . $row['image3_url'] . "' alt='Image 3'>";
            // }
            echo "<hr>";
            "<br><br>";
        }
    } else {
        echo "No buses found for the given route.";
    }

    $connection->close();
} else {
    header("Location: search.html");
    exit();
}
?>
