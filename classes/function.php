<?php
// Function to check if the logged-in user is the owner of the message content
function i_own_content($message)
{
    if (!isset($_SESSION['users_id'])) {
        return false;
    }

    if ($message['sender'] == $_SESSION['users_id']) {
        return true;
    }

    return false;
}
?>
