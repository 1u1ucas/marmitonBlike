<?php
session_start();
session_destroy();

header('Location: ../../index.php?success=Vous avez bien été déconnecté');