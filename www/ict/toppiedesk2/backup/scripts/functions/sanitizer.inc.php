<?php
    class Sanitizer
    {
        function SanitizeInput($value)
        {
            if(isset($value) && is_string($value))
            {
                //$value = stripslashes($value);
            }
            
            return $value;
        }
        
        function SanitizeOutput($value)
        {
            if(is_string($value))
            {
                $value = htmlspecialchars($value);
                $value = nl2br($value);
            }
            
            return $value;
        }
    }
?>