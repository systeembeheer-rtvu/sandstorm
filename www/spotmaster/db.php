<?php
// spotmaster opzoeker!

require_once("/mnt/data/include/config.inc.php");
require_once("/mnt/data/include/mysqli.inc.php");
$dbh = new sql;
$dbh -> connect();

    function dec_to_hex($value)
    {
        return asciibin2hex(dec2bin($value));
    }
    
    function dec2bin($dec){
    // Better function for dec to bin. Support much bigger values, but doesn’t support signs
        for($b='',$r=$dec;$r>1;){
            $n = floor($r/2); $b = ($r-$n*2).$b; $r = $n; // $r%2 is inaccurate when using bigger values (like 11.435.168.214)!
        }
        return ($r%2).$b;
    }
    
    function asciibin2hex($str) {
        //Binary to HEX list
        $steps = 0;
        $inhex = "";
        
        $binary['0000'] = "0";
        $binary['0001'] = "1";
        $binary['0010'] = "2";
        $binary['0011'] = "3";
        $binary['0100'] = "4";
        $binary['0101'] = "5";
        $binary['0110'] = "6";
        $binary['0111'] = "7";
        $binary['1000'] = "8";
        $binary['1001'] = "9";
        $binary['1010'] = "A";
        $binary['1011'] = "B";
        $binary['1100'] = "C";
        $binary['1101'] = "D";
        $binary['1110'] = "E";
        $binary['1111'] = "F";
        
        $var = strlen($str) - 4;
        
        while($var > -4){
//        while($steps <= 9) {
            $steps++;
            if($var < 0)
            {
                $temp ="";
                for($i = $var; $i<0; $i++)
                    $temp .= "0";
                $calc = 4 + $var;   
                $temp .= substr($str,0,$calc);
            }
            else
                $temp = substr($str,$var,4);
            
            $inhex = $binary[$temp] . $inhex;
            
            $var = $var - 4;
        }
        
        return $inhex;    
    }



$query = " 
	update spotmaster set ACTIVE = 0
";
$dbh -> do_query($query,__LINE__,__FILE__);

$tags = file("tagholders.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($tags as &$value) {
//# ^(.*?)\b(\d{5,})\b(.*?)(\d)(.*?)(\d)(.*?)(\d{1,})
	if (preg_match('/^(.*?)\b(\d{5,})\b(.*?)(\d)(.*?)(\d)(.*?)(\d+)/im', $value, $regs)) {	
	    	$naamtemp = $regs[1];
		$tag = $regs[2];
		$tagnummer = $regs[4];
		$disabled = $regs[6];
		$department = $regs[8];
		
		$taghex = str_pad(dec_to_hex($tag),10,"0",STR_PAD_LEFT);
		$naam = preg_replace('/\s+/', ' ',$naamtemp);
		$naam = trim($naam);
		
//		echo "$naam ($tag)<br />";

		$query = "
			replace into spotmaster
			(TAG,TAGHEX,NAAM,TAGNR,DISABLED,DEPARTMENT,ACTIVE)
			values (?,?,?,?,?,?,1)
		";
		$sth = $dbh -> do_placeholder_query($query,array($tag,$taghex,$naam,$tagnummer,$disabled,$department),__LINE__,__FILE__);		
	}
	
}

$tags = file("lastuse.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($tags as &$value) {
//# ^(.*?)\b(\d{5,})\b(.*?)(\d)(.*?)(\d)(.*?)(\d{1,})
	if (preg_match('/^(\d+)\s*(\d+)/im', $value, $regs)) {
	    	$tag = $regs[1];
		$lastuse = $regs[2];
		// echo "$lastuse ($tag)<br />";
		$query = "
			update spotmaster
			set LASTUSE = ?
			where TAG = ?
			 and active = 1
		";
		$sth = $dbh -> do_placeholder_query($query,array($lastuse,$tag),__LINE__,__FILE__);	
		
	}
	
}

echo "echo %date% %time% >log.txt\n";

$query = " 
	select NAAM,TAGHEX
	from spotmaster
	where DISABLED = 0
	and ACTIVE = 1
	and DEPARTMENT in (1,35,67)
	order by NAAM,TAGNR desc
";

// department RTV Utrecht / RTV Utrecht Reclame / De Kroon Receptie

$sth = $dbh -> do_query($query,__LINE__,__FILE__);
while (list($naam,$taghex) = $dbh -> fetch_array($sth)) {	

		echo <<<DUMP
dsquery user -name "$naam" | dsmod user -pager $taghex\n
if %errorlevel% NEQ 0 echo $naam>>log.txt\n
DUMP;

}
echo "\n";
?>