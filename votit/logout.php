<?php

require_once('lib/config.php');
require_once('lib/session.php');
session_regenerate_id(true);
session_unset();
session_destroy();
header('Location: login.php');
session_unset();