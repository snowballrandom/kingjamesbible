<?php
ini_set("auto_detect_line_endings", true);

$file = fopen("Revelation.txt", 'r');
while(!feof($file))
  {
  $data = fgets($file);
  //preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $data);
  
  // Get all the verse numbers
  preg_match_all("/[+-]?\d+[\d\.Ee+]*/", $data, $matches);
  @$verse_num = array(@$matches[0][0]);
  
  // Remove numbers from text
  $text_only = trim(str_replace(range(0,9),'',$data));
  
  // Get Chapter Numbers
  $chap = stristr($data, 'CHAPTER');
  preg_match_all('!\d+!', $chap, $chap_fix);

  // Push text onto the end of the verse num array     
  array_push($verse_num, $text_only);
  
  // remove all null chapter values
   if($chap_fix[0][0] !== NULL){
       // Keep chapters that have a value
   $chapter = $chap_fix[0][0];
   }
   
  // Database Stuff
  $s_data = array(
    'Testament' => 'New',
    'Chapter_Name' => 'Revelation',
    'Chapter_Id' => $chapter,
    'Verse_Id' => $verse_num[0],
    'Verse_Text' => $verse_num[1],    
  );
  $this->db->insert('bible', $s_data);
  
  
  var_dump($chapter);
  var_dump($verse_num); 
  }
  
fclose($file);
?>		
