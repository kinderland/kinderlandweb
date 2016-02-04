<?php

function renderMenu($permissions) {

    if (in_array(SYSTEM_ADMIN, $permissions)) {
        return APPPATH . 'views/include/admin_upper_menu.php';
    }

    if (in_array(DIRECTOR, $permissions)) {
        return APPPATH . 'views/include/director_left_menu.php';
    }

    if (in_array(SECRETARY, $permissions)) {
        return APPPATH . 'views/include/secretary_left_menu.php';
    }

    if (in_array(COORDINATOR, $permissions)) {
        return APPPATH . 'views/include/coordinator_left_menu.php';
    }

    if (in_array(DOCTOR, $permissions)) {
        return APPPATH . 'views/include/doctor_left_menu.php';
    }

    if (in_array(MONITOR, $permissions)) {
        return APPPATH . 'views/include/monitor_left_menu.php';
    }

    return APPPATH . 'views/include/secretary_left_menu.php';
}

?>