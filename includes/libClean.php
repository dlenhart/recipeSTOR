<?php


function stringFixedWidth($str, $wid)
{
  if (strlen($str) < $wid)
  {
    for ($x = strlen($str); $x < $wid; $x++)
    {
      $str = $str . "&nbsp;";
    }
    return $str;
  }
  if (strlen($str) == $wid) { return $str; }
  if (strlen($str) > $wid)
  {
    $str = substr($str, 0, $wid - 1);
    $str = $str . "<img src=img/ellipsis.gif width=7 height=10>";
    return $str;
  }
}

function formatSize1000($rawSize)  
{ 
   if ($rawSize / 1000000 > 1)  
       return round($rawSize/1000000, 1) . 'MB';  
   else if ($rawSize / 1000 > 1)  
       return round($rawSize/1000, 1) . 'KB';  
   else  
       return round($rawSize, 1) . 'b'; 
}

function formatSize($rawSize)  
{ 
   if ($rawSize / 1048576 > 1)  
       return round($rawSize/1048576, 1) . 'MB';  
   else if ($rawSize / 1024 > 1)  
       return round($rawSize/1024, 1) . 'KB';  
   else  
       return round($rawSize, 1) . 'b'; 
}

function tagExists($tag, $str)
{
  $arr = tagsGetArr($str);
  for ($x = 0; $x <= count($arr); $x++)
  {
    if (strtolower($arr[$x]) == strtolower($tag))
    {
      return true;
    }
  }
  return false;
}

function tagsGetArr($str)
{
  $arr = split(",", $str);
  $cnt = -1;
  $RV = "";
  for ($x = 0; $x < count($arr); $x++)
  {
    $str = $arr[$x];
    $str = preg_replace("/\W/", " ", $str);
    $str = trim($str);
    for ($y = 0; $y <= 10; $y++)
    {
      $str = str_replace("  ", " ", $str);
    }
    if ($str != "")
    {
      $cnt++;
      $RV[$cnt] = $str;
    }
  }
  return $RV;
}

function tagsTrim($str)
{
  $RV = $str;
  $ri = substr($RV, strlen($RV) - 2, 2);
  if ($ri == ", ")
  {
    $RV = substr($RV, 0, strlen($RV) - 2);
  }
  $ri = substr($RV, strlen($RV) - 1, 1);
  if ($ri == ",")
  {
    $RV = substr($RV, 0, strlen($RV) - 1);
  }
  $le = substr($RV, 0, 1);
  if ($le == " ")
  {
    $RV = substr($RV, 1, strlen($RV) - 1);
  }
  return $RV;
}

function tagsClean($str)
{
  $arr = split(",", $str);
  $RV = "";
  for ($x = 0; $x < count($arr); $x++)
  {
    $str = $arr[$x];
    $str = preg_replace("/\W/", " ", $str);
    $str = trim($str);
    for ($y = 0; $y <= 10; $y++)
    {
      $str = str_replace("  ", " ", $str);
    }
    if ($str != "")
    {
      $RV = $RV . $str;
      $RV = $RV . ", ";
    }
  }
  #$ri = substr($RV, strlen($RV) - 2, 2);
  #if ($ri == ", ")
  #{
  #  $RV = substr($RV, 0, strlen($RV) - 2);
  #}
  return " " . $RV;
}



function generateRandomWord ($length = 8)
{

  // start with a blank password
  $password = "";

  // define possible characters
  $possible = "0123456789bcdfghjkmnpqrstvwxyz"; 
    
  // set up a counter
  $i = 0; 
    
  // add random characters to $password until $length is reached
  while ($i < $length) { 

    // pick a random character from the possible ones
    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
        
    // we don't want this character if it's already in the password
    if (!strstr($password, $char)) { 
      $password .= $char;
      $i++;
    }

  }
  return $password;  
}


function sqlClean($string)
{
	// Remove SQL string metacharacters and "funky" characters.
	// XXX: This is supposed to be rewritten according to an explicitly permissible character set
	// XXX: This is quite specific to SQL Server.  Different RDBMSs use different
	//        escaping conventions.
	
	// Strip control characters other than Tab, CR, LF (potential security	issues)
	
	$string = preg_replace("/[^A-z0-9\.\?\/\\\`\@\!\#\$\%\^\&\*\(\)\-\_\+\=\:\;\<\>\,\[\]\{\}\|\n\r\n\t\~\ \'\"]/", ' ', $string);
	$string = str_replace("'", "''",$string);	
	return $string; 
} 

function sqlCleanForceNumeric($string) {
	return sqlClean($string);
}


function sqlLikeClean($string)
{
	// Fill in later.  Needs to be very restrictive
	// allows only a-z A-z 0-9 and .
	// we replace all of the bad characters with a single character wild card
	return preg_replace("/[^A-z0-9\.]/", '_', $string);
}

function htmlClean($string)
{
	
	$string = str_replace('&', '&amp;',$string);  // do this first, obviously
	$string = str_replace('<', '&lt;', $string);
	$string = str_replace('>', '&gt;', $string);
	$string = str_replace('\\', '', $string);
	$string = str_replace("'", '`', $string);
	$string = str_replace('"', '&quot;', $string);
	$string = str_replace("``", '`', $string);
	
	// FIXME: Use Recode to map 8-bit character sets to HTML ampersand entities here.
	return $string;
} 

function htmlClean2($string) {
        $search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
                         "'<[\/\!]*?[^<>]*?>'si",           // Strip out html tags
                         "'([\r\n])[\s]+'",                 // Strip out white space
                         "'&(quot|#34);'i",                 // Replace html entities
                         "'&(amp|#38);'i",
                          "'&(lt|#60);'i",
                          "'&(gt|#62);'i",
                         "'&(nbsp|#160);'i",
                         "'&(iexcl|#161);'i",
                         "'&(cent|#162);'i",
                         "'&(pound|#163);'i",
                         "'&(copy|#169);'i",
                         "'&#(\d+);'e");                    // evaluate as php

        $replace = array ("",
                          "",
                          "\\1",
                          "\"",
                          "&",
                          "<",
                          ">",
                          " ",
                          chr(161),
                          chr(162),
                          chr(163),
                          chr(169),
                          "chr(\\1)");

        return preg_replace ($search, $replace, $string);
}

// WS Mod: 3/30/2006
// htmlCleanTextile()
//  - parameters: $text (string)
//  - this function htmlCleans's a string and then replaces
//  the character entity for quotes with regular quotes.
//  this should be reasonably safe as it still stops
//  html tags from being rendered.
function htmlCleanTextile($text) {

	$text = htmlClean($text);
	
	//undo quote replacement
	$text = str_replace('&quot;','"',$text);
	
	return $text;

}


function toRoman($num) {

if ($num == 0) { return "0"; }

if ($num < 0 || $num > 9999) { return -1; } // out of range

$r_ones = array(1=> "I", 2=>"II", 3=>"III", 4=>"IV", 5=>"V", 6=>"VI", 7=>"VII", 8=>"VIII", 
9=>"IX");
$r_tens = array(1=> "X", 2=>"XX", 3=>"XXX", 4=>"XL", 5=>"L", 6=>"LX", 7=>"LXX", 
8=>"LXXX", 9=>"XC");
$r_hund = array(1=> "C", 2=>"CC", 3=>"CCC", 4=>"CD", 5=>"D", 6=>"DC", 7=>"DCC", 
8=>"DCCC", 9=>"CM");
$r_thou = array(1=> "M", 2=>"MM", 3=>"MMM", 4=>"MMMM", 5=>"MMMMM", 6=>"MMMMMM", 
7=>"MMMMMMM", 8=>"MMMMMMMM", 9=>"MMMMMMMMM");

$ones = $num % 10;
$tens = ($num - $ones) % 100;
$hundreds = ($num - $tens - $ones) % 1000;
$thou = ($num - $hundreds - $tens - $ones) % 10000;

$tens = $tens / 10;
$hundreds = $hundreds / 100;
$thou = $thou / 1000;

$rnum = "";
if ($thou) { $rnum .= $r_thou[$thou]; }
if ($hundreds) { $rnum .= $r_hund[$hundreds]; }
if ($tens) { $rnum .= $r_tens[$tens]; }
if ($ones) { $rnum .= $r_ones[$ones]; }

return $rnum;

} // function to_roman($num)

?>