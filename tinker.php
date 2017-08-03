
<?php

$tweet = "this has a #hashtag and #hello and #good or #bad";

preg_match_all("/(#\w+)/", $tweet, $matches);

foreach ($matches[1] as $key => $value) {
	$value = str_replace('#','',$value);
    echo $value.' ';
    # code for inserting into database...
}
?>  