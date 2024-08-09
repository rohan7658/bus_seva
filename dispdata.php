<?php
include 'config.php';

$sql = "SELECT * FROM buses
        INNER JOIN bus_images ON buses.bus_id = bus_images.bus_id
        INNER JOIN drivers ON buses.bus_id = drivers.bus_id
        INNER JOIN route ON buses.bus_id = route.bus_id
        INNER JOIN schedules ON buses.bus_id = schedules.bus_id";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    $busDetails = array();

    while ($row = $result->fetch_assoc()) {
        $busDetail = array(
            'model' => $row['model'],
            'capacity' => $row['capacity'],
            'license_plate' => $row['license_plate'],
            'images' => array(
                'image1' => $row['image1_url'],
                'image2' => $row['image2_url'],
                'image3' => $row['image3_url']
            ),
            'driver' => array(
                'name' => $row['name'],
                'license_number' => $row['license_number'],
                'contact' => $row['contact']
            ),
            'route' => array(
                'start_location' => $row['start_location'],
                'end_location' => $row['end_location'],
                'distance' => $row['distance'],
                'duration' => $row['duration']
            ),
            'schedule' => array(
                'departure_time' => $row['departure_time'],
                'arrival_time' => $row['arrival_time'],
                'date' => $row['date']
            )
        );

        $busDetails[] = $busDetail;
    }

    $connection->close();

    header('Content-Type: application/json');
    echo json_encode($busDetails);
} else {
    echo "No bus details found";
}
?>
