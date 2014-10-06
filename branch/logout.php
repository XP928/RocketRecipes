<?php
if(session_destroy())
{
print"<h2>You have been logged out successfully.</h2>";
print "<h3><a href='index.php'>Click here</a> to return to the main page.</h3>";
}
?>