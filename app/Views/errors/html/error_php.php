<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<h4>A PHP Error was encountered</h4>

<p>Severity: <?php echo $severity; ?></p>
<p>Message:  <?php echo $message; ?></p>
<p>Filename: <?php echo $filepath; ?></p>
<p>Line Number: <?php echo $line; ?></p>

<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

	<p>Backtrace:</p>
	<?php foreach (debug_backtrace() as $error): ?>

		<?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

			<p style="margin-left:10px">
			File: <?php echo $error['file'] ?><br />
			Line: <?php echo $error['line'] ?><br />
			Function: <?php echo $error['function'] ?>
			</p>
			<?php
			$date = date('Y-m-d H:i:s');
// Get the IP address of the user
			$ip = $_SERVER['REMOTE_ADDR'];
// Get the URL of the page where the message originated
			$url = $_SERVER['REQUEST_URI'];
// Check if the message is a PHP error
			$message .= " | PHP Error: {$error['function']} in {" . $error['file'] . "} on line {" . $error['line'] . "}";
			$level = 'error';
// Build the log message
			$log_message = "[{$date}] [{$level}] [{$ip}] [{$url}] {$message}\n";
// Write the log message to the log file
			file_put_contents(APPPATH . '/logs/errors.log', $log_message, FILE_APPEND);
			?>
		<?php endif ?>

	<?php endforeach ?>

<?php endif ?>

</div>
