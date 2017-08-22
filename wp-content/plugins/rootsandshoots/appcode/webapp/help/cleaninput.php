<?php
function cleanInput($input)
{
	var_dump($input);
    foreach($input as $key => $value)
    {
    	if(is_string($value))//enkel voor strings
		{
    		//HTML tags en PHP code verwijderen
    		echo "key: ".$key."<br />";
    		echo "value: ".$value."<br />";
			echo "type: "; gettype($value); echo "<br />";
        	$value = strip_tags($value);
        	//witruimte an het begin en einde verwijderen
        	$value = trim($value);
        	//2 spaties vervangen door één spatie
        	while(strpos($value, '  ') != FALSE)
        	{
            	$value = str_replace('  ', ' ',$value);
        	}
        	$input[$key] = $value;
    		
		}//end if
        
    }//end foreach
    return $input;
	
}
?>


