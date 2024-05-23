<?php

session_start();

$recepyId = $_POST['recepy_id'];

$_SESSION['recepy_id'] = $recepyId;

header("Location: ../../comment.php");