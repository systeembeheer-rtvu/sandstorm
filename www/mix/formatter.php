<?php


$subject = $_POST['subject'];
// var_dump($subject);
echo <<<DUMP
<html>
<head>
<title>Formatter</title>
</head>
<body>
<h1>formatter</h1>
<form method="post" action="formatter.php" style="display:inline;" name="bounce" id="bounce">
<textarea name="subject" rows="10" cols="50" id="command">$subject</textarea>
<input type="submit" name="execute" value="Format body" />
</form>
<br>
DUMP;

$subject = str_replace("[","\n[",$subject);
$subject = str_replace("<","\n<",$subject);

echo <<<DUMP
<textarea name="subject2" rows="40" cols="150" id="command">$subject</textarea>
</body>
</html>
DUMP;
?>