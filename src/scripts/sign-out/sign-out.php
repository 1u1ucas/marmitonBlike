<?php
session_start();

unset($_SESSION['id']);

header('Location: ../../index.php?success=Vous avez bien été déconnecté');