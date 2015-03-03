<?php

function get_longest_common_subsequence($string_1, $string_2)
{
        $string_1_length = strlen($string_1);
        $string_2_length = strlen($string_2);
        $return          = "";
 
        if ($string_1_length === 0 || $string_2_length === 0)
        {
                // No similarities
                return $return;
        }
 
        $longest_common_subsequence = array();
 
        // Initialize the CSL array to assume there are no similarities
        for ($i = 0; $i < $string_1_length; $i++)
        {
                $longest_common_subsequence[$i] = array();
                for ($j = 0; $j < $string_2_length; $j++)
                {
                        $longest_common_subsequence[$i][$j] = 0;
                }
        }
 
        $largest_size = 0;
 
        for ($i = 0; $i < $string_1_length; $i++)
        {
                for ($j = 0; $j < $string_2_length; $j++)
                {
                        // Check every combination of characters
                        if ($string_1[$i] === $string_2[$j])
                        {
                                // These are the same in both strings
                                if ($i === 0 || $j === 0)
                                {
                                        // It's the first character, so it's clearly only 1 character long
                                        $longest_common_subsequence[$i][$j] = 1;
                                }
                                else
                                {
                                        // It's one character longer than the string from the previous character
                                        $longest_common_subsequence[$i][$j] = $longest_common_subsequence[$i - 1][$j - 1] + 1;
                                }
 
                                if ($longest_common_subsequence[$i][$j] > $largest_size)
                                {
                                        // Remember this as the largest
                                        $largest_size = $longest_common_subsequence[$i][$j];
                                        // Wipe any previous results
                                        $return       = "";
                                        // And then fall through to remember this new value
                                }
 
                                if ($longest_common_subsequence[$i][$j] === $largest_size)
                                {
                                        // Remember the largest string(s)
                                        $return = substr($string_1, $i - $largest_size + 1, $largest_size);
                                }
                        }
                        // Else, $CSL should be set to 0, which it was already initialized to
                }
        }
 
        // Return the list of matches
        return $return;
}


// echo get_longest_common_subsequence(strtolower('AMAN SAMAIYAR'), 'aman samaiyar loves blue');

require_once("../../../includes/initialize.php");

function getdistance ($pin, $address)
{
	$maxlen = 0;
	$dist = 0;
	$query2 = mysql_query("SELECT * FROM pindata WHERE pincode='$pin'");
	while($pindata = mysql_fetch_array($query2))
	{
		$lengthofcommon = strlen(get_longest_common_subsequence(strtolower($address),strtolower($pindata['address'])));
		if($lengthofcommon > $maxlen)
		{
			$maxlen = $lengthofcommon;
			$dist = $pindata['distance'];
		}
	}
	return $dist;
	
}

echo "<pre>";

$query1 = mysql_query("SELECT * FROM distance_from_home WHERE distance=0");
while($rowname = mysql_fetch_array($query1))
{
	$id = $rowname['student_id'];
	$query = mysql_query("SELECT * FROM present_address WHERE student_id='$id' LIMIT 1");
	$queryresult = mysql_fetch_array($query);
	if(trim(strtolower($queryresult['present_country'])) == 'india')
	{
		$pin = $queryresult['present_pin'];
		$address = $queryresult['present_add_line'].",".$queryresult['present_city'];
		$distance = getdistance($pin, $address);
		echo $pin." | ".$address." | ".$distance."<br />";
		$query4 = mysql_query("UPDATE distance_from_home SET distance={$distance} WHERE student_id='$id'");
	}
	
}

echo 'Done';
//echo get_longest_common_subsequence('aman samaiyar', 'blue is aman samaiyar\'s fav color');

echo "</pre>";

?>
