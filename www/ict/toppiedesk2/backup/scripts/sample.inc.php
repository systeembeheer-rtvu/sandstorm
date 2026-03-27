<?php
    $page['classes']['load'] = new Sample();

    class Sample
    {
        //aanroep tpl file
        function GetFileName()
        {
            //Naam van .tpl file die aangeroepen moet worden
            return "Sample";
        }
        
        //op te halen variabelen
        function GetVars()
        {
            //variabelen die opgehaald worden uit de get en post
            //de varname is aan te roepen via $input['varname']
            return array(
                "input" => array(
                    "varname" => array( //onder deze naam komt de variabel beschikbaar binnen de php code
                        "id" , // naam van de get/post variabel
                        "get", // uit welke global veriabel de variabel gehaald mag worden (both (voor get en post), get, post, cookie en session)
                        "int" // type variabel (int, alpha en alphanum)
                    ),
                )
            );
        }
        
        //code voor de navigatiebalk
        function NavigatieBalk()
        {
            global $input, $page, $output;
            
            //met false wordt een onderdeel niet getoont
            //voor javascript code is "" genoeg. de javascript code wordt in het bijbehorende .js bestand gezet
            
            $output["navbar"]["new"] = $page['settings']['locations']['file'] . "?id=incidentnieuw"; //waarde voor een nieuw object
            $output["navbar"]["save"] = $page['settings']['locations']['file'] . "?id=incidentnieuw"; //waarde voor het opslaan van een object
            $output["navbar"]["prev"] = "false"; //waarde voor een vorig object
            $output["navbar"]["next"] = "false"; //waarde voor een volgend object
            $output["navbar"]["archive"] = "false"; //waarde voor een nieuw object
            $output['navbar']['autocomplete'] = ""; //class die gebruikt wordt voor de autocomplete (tel, naam, categorie)
            $output['navbar']['id'] = "incidentzoeken"; //id die in de adresbalk komt te staan om het juiste script aan te roepen
        }
        
        //deze int geeft aan of de pagina beveiligd is. 0 = niet beveiligd, 1 = beveiligd
        function CheckPage()
        {
            return 0;
        }
        
        //run methode is naar eigen wens in te vullen
        function DoRun()
        {
            //redirect van een pagina
            $output['redirect'] = $page['settings']['locations']['file'] ."?id=configoverzicht";
        }
        
        function GetSidebarType()
        {
            //de sidebar die getoont wordt (configuratie, contract, incident, wijziging of settings)
            //zodra hij leeg blijft wordt er geen sidebar getoont
            return "";
        }
    }
?>