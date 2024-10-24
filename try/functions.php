<?php
function validate_username($username) {
    return strlen($username) >= 4;
}

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validate_password($password) {
    return strlen($password) >= 6;
}

?>
