<?php
    $page['classes']['load'] = new ftp();
    require_once($page['root'] . "/libs/phpmailer/class.phpmailer.php");

    class ftp
    {
        private $sql;
        
        function __construct()
        {
            global $global_ftp;
            
            $this->sql = new sql();
            $this->sql->connect2(
                $global_ftp['DATABASE_SERVER'],
                $global_ftp['DATABASE_USER'],
                $global_ftp['DATABASE_PASSWORD'],
                $global_ftp['DATABASE_NAME']
            );
        } 
        
        function GetFileName()
        {
            if(isset($_GET['status']))
               return "bedankt";
            return "ftp";
        }
        
        function CheckPage()
        {
            return 0;
        }
        
        function NavigatieBalk()
        {}
        
        function GetVars()
        {
            return array(
                "input" => array(
                    "naam" => array("naam","post",""),
                    "email" => array("email","post",""),
                    "omschrijving" => array("omschrijving", "post", ""),
                    "email" => array("email", "post", "")
                )
            );
        }
        
        function DoRun()
        {
            global $input, $page, $output;
            
            $this->weergeven();
            
            if(isset($_POST['submit']))
            {
                $queryvars = array($input['naam']);
                $query = "
                    select user from users where user = ?
                ";
                
                $sth = $this->sql->do_placeholder_query($query,$queryvars,__line__,__file__);
                
                if($this->sql->total_rows($sth) == 0 && $this ->checkInput())
                {
                    $input['password'] = createPassword(8);
                    
                    $queryvars = array(
                        $input['naam'],
                        md5($input['password']),
                        "/data/ftp/" . $input['naam'],
                        $input['omschrijving'],
                        date('Y-m-d', strtotime('+1 week')),
                        $output['naam']
                    );
                    
                    $query = "INSERT INTO users (user, password, uid, gid, dir, comment, verloopdatum, AangevraagdDoor) values (?, ?, 65534, 21, ?, ?, ?, ?)";
                    
                    $this->sql->do_placeholder_query($query,$queryvars,__line__,__file__);

                    $ftp_server = "ftp.rtvutrecht.nl";
                    $ftp_user = $input['naam'];
                    $ftp_pass = $input['password'];
                    
                    try{
                        $conn_id = ftp_connect($ftp_server);
                        ftp_login($conn_id, $ftp_user, $ftp_pass);
                        ftp_close($conn_id);
                    }
                    catch (Exception $e)
                    {}
                    
                    $this->Sendmail();
                    
                    $output['redirect'] = $page['settings']['locations']['file'] ."?id=ftp&status=saved";
                }
                else
                    $output['info'] = "Gebruikersnaam is niet geldig";
            }
        }
        
        function GetSidebarType()
        {
            return "user";
        }
        
        //overige functions
        
        function checkInput()
        {
            global $input;
            
            if(!preg_match('/\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,6}\b/i', $input['email']))
                return false;

	    if (!preg_match('/\A[a-z0-9]*\Z/i', $input['naam']))
                return false;
            
            return true;
        }
        
        function Sendmail()
        {
            global $input, $page;
            
            $mail = new PHPMailer();
            
            // Geef de afzender aan
            $mail->From = "no-reply@rtvutrecht.nl";
            $mail->FromName = "RTV Utrecht";
            
            // Bepaal de geadresseerden
            $mail->AddAddress($input['email']); // Eerste geadresseerde
            
            // Inhoud van de mail
            $mail->Subject = "FTP gegevens RTV Utrecht";
            $mail->Body = "Beste,

Bij deze ontvang je de FTP gegevens voor de RTV Utrecht FTP-server

Serveradres: ftp.rtvutrecht.nl
Gebruikersnaam: " . $input['naam'] . "
Wachtwoord: " . $input['password'] . "

LET OP: dit account is 7 dagen geldig!

Met vriendelijke groet,
Afdeling ICT
RTV Utrecht";
            
            // Maximaal aantal karakters
            //$mail->WordWrap = 50;
            
            // Probeer de mail te versturen
            if(!$mail->Send())
            {
                $array['message'] = "Er ging iets mis tijdens het versturen, namelijk: " . $mail->ErrorInfo;
            }
            else
            {
                $array['message'] = "De mail is verstuurd.";
            }

            $mail = new PHPMailer();

            $mail->From = "no-reply@rtvutrecht.nl";
            $mail->FromName = "RTV Utrecht";
            
            // Bepaal de geadresseerden
            $mail->AddAddress("ict@rtvutrecht.nl"); // Eerste geadresseerde          
            
            $mail->Subject = "FTP account aangevraagd";
            $mail->Body = "Beste ICT'er

Er is een FTP account aangevraagd door {$input['email']}.

Gebruikersnaam: " . $input['naam'] . "

Commmentaar:
{$input['omschrijving']}

Om eventueel de verloopdatum aan te passen kijk op:
http://intranet/ict/toppiedesk2/toppiedesk.php?id=ftp&searchoid={$input['naam']}

Met vriendelijke groet,
Afdeling ICT
RTV Utrecht";
            if ($input['omschrijving']) $mail->Send();
            
        }
        
        function weergeven()
        {
            global $input, $page, $output;
            
            $queryvars = array($_SERVER['REMOTE_ADDR']);
            $query = "
                select naam
                from telefoonlijst
                where workstationip = ?
            ";
            
            $sth = $page['classes']['sql']->do_placeholder_query($query,$queryvars,__line__,__file__);
            $vars = $page['classes']['sql']->fetch_array($sth);
            $output['naam'] = $vars['naam'];
            $output['email'] = strtolower(str_replace(" ",".",$vars['naam'])."@rtvutrecht.nl");
            
            if($output['email'] == "@rtvutrecht.nl")
                $output['setemail'] = 0;
            else
                $output['setemail'] = 1;
        }
    }
?>