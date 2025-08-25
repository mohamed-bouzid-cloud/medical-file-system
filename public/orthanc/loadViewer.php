<?php
$instanceID = $_GET['instanceID'] ?? null;
if (!$instanceID) {
    die("No instanceID provided");
}

// Example: redirect to Orthanc rendered image or load viewer JS
$orthancUrl = "http://localhost:8042/instances/$instanceID/rendered";

// You can redirect or output HTML with iframe/JS here
header("Location: $orthancUrl");
exit;
