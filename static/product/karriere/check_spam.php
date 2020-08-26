<?php

function checkSpam($postData)
{
  $score = 0;
  $blockingWords = array('adult', 'dating');

  if (isset($postData['honeypot']) && $postData['honeypot']!="") $score += 1000;

  foreach ($postData as $key => $value) {
    if(preg_match('/(?:http|https):\/\/((?:[\w-]+)(?:\.[\w-]+)+)(?:[\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?/', $value)) $score += 1000;
    foreach ($blockingWords as $w) {
      if(stripos($value, $w)!==false) $score += 1000;
    }
  }

  return $score >= 1000;
}