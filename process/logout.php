<?php
session_start();
session_unset();

// destroy the session
session_destroy();

$data = array(
    'status' => true,
    'msg' => 'logout',
);

echo json_encode($data);
