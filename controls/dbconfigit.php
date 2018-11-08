<?php 
define ("DB_HOST", "localhost"); // set database host
define ("DB_USER", "root"); // set database user
define ("DB_PASS", ""); // set database password
define ("DB_NAME", "technify"); // set database name

$con = @mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$con) {
    trigger_error('Could not connect to MySQL: ' . mysqli_connect_error());
}
$date = date("Y-m-d H:i:s");

/* Registration Type (Automatic or Manual) 
 1 -> Automatic Registration (users will receive activation code and they will be automatically approved after clicking activation link)
 0 -> Manual Approval (users will not receive activation code and you will need to approve every user manually)
*/
$user_registration = 1;  // set 0 or 1

define("COOKIE_TIME_OUT", 10); //specify cookie timeout in days (default is 10 days)
define('SALT_LENGTH', 9); // salt for password

//define ("ADMIN_NAME", "admin"); // sp

/* Specify user levels */
define ("SUPER_ADMIN_LEVEL", 2689);
define ("ADMIN_LEVEL", 119);
define ("STAFF_LEVEL", 2);
define ("USER_LEVEL", 1);
define ("GUEST_LEVEL", 0);

?>