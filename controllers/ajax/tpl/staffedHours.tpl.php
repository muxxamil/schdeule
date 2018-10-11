<?php
	include_once('../../../config/defaults.php');
?>

<h3>Staffed Hours</h3>

<?php
if(empty($_POST["staffHours"][from]) || empty($_POST["staffHours"][to]) || (date_format(date_create($_POST["staffHours"][from]), 'Y-m-d h:i:s A') == date_format(date_create($_POST["staffHours"][to]), 'Y-m-d h:i:s A')) ) {
?>
-
<?php
return;
}

$from = (date_format(date_create($_POST["staffHours"][from]), 'Y-m-d') < $_POST['date']) ? "00:00:00 AM" : date_format(date_create($_POST["staffHours"][from]), 'h:i:s A');

$to = (date_format(date_create($_POST["staffHours"][to]), 'Y-m-d') > $_POST['date']) ? "11:59:59 PM" : date_format(date_create($_POST["staffHours"][to]), 'h:i:s A');

?>

From: <?php echo $from; ?>
<br/>
To: <?php echo $to; ?>