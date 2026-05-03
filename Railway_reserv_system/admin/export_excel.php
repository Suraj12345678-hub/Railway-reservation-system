<?php
include('../includes/db.php'); 
session_start();

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Booking_Report.csv');

$output = fopen('php://output', 'w');
fputcsv($output, array('PNR No', 'Passenger Name', 'Age', 'Gender', 'Coach', 'Date', 'Status'));

$query = "SELECT pnr, passenger_name, passenger_age, passenger_gender, coach, travel_date, status FROM bookings ORDER BY id DESC";
$result = mysqli_query($conn, $query);

while($row = mysqli_fetch_assoc($result)){
    fputcsv($output, $row);
}

fclose($output);
exit();
?>