<?php
require_once("../config.inc.php");
require_once("../mysql.inc.php");
$dbh = new sql;
$dbh -> connect();

/*
$query = <<<eof
    LOAD DATA INFILE 'factuurdetails.csv'
     INTO TABLE telefoon_gesprekken
     FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
     LINES TERMINATED BY '\n'
    (Beller,Bestemming,Nummer,KB,Duur,TypeDienst,Start,Einde,Kosten)
eof;

$sth = $dbh -> do_query($query,__LINE__,__FILE__);
*/

$handle = fopen("Factuurdetails11.csv", "r");
$i=0;
while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
if($i>0){
    $query = "
    	INSERT into telefoon_gesprekken
    	(Beller,Bestemming,Nummer,KB,Duur,TypeDienst,Start,Einde,Kosten)
    	values(?,?,?,?,?,?,?,?,?) 
    	";
    $sth = $dbh->do_placeholder_query($query,array($data[0],$data[1],$data[2],$data[3],$data[4],$data[5],$data[6],$data[7],$data[8]),__LINE__,__FILE__);
}
$i=1;
}
echo "Done!";

?>


