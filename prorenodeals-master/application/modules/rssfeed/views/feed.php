<?php
echo '<?xml version="1.0" encoding="utf-8"?>' . "n";
?>
<rss version="2.0"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
    xmlns:admin="http://webns.net/mvcb/"
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
    xmlns:content="http://purl.org/rss/1.0/modules/content/">
<channel>
<title><?php echo $feed_name; ?></title>
<link>
<?php echo $feed_url; ?>
</link>
<description><?php echo $page_description; ?></description>
<dc:language><?php echo $page_language; ?></dc:language>
<dc:creator><?php echo $creator_email; ?></dc:creator>
<dc:rights>Copyright <?php echo gmdate("Y", time()); ?></dc:rights>
<admin:generatorAgent rdf:resource="http://www.codeigniter.com/" />
<!-- repeat this block for more items -->
<?php
foreach($feed_post as $key=>$val)
{
?>
<item>
<title><?php echo ucwords($val['title']);?></title>
<link><?php echo VPATH;?>jobdetails/details/<?php echo $val['project_id'];?>/<?php echo $this->auto_model->getcleanurl($val['title']);?></link>
<guid><?php echo VPATH;?>jobdetails/details/<?php echo $val['project_id'];?>/<?php echo $this->auto_model->getcleanurl($val['title']);?></guid>
<?php
//////////////////////For Email/////////////////////////////
$pattern = "/[^@\s]*@[^@\s]*\.[^@\s]*/";
$replacement = "[*****]";
$val['description']=preg_replace($pattern, $replacement, $val['description']);
/////////////////////Email End//////////////////////////////////

//////////////////////////For URL//////////////////////////////
$pattern = "/[a-zA-Z]*[:\/\/]*[A-Za-z0-9\-_]+\.+[A-Za-z0-9\.\/%&=\?\-_]+/i";
$replacement = "[*****]";
$val['description']=preg_replace($pattern, $replacement, $val['description']);
/////////////////////////URL End///////////////////////////////

/////////////////////////For Bad Words////////////////////////////
$healthy = explode(",",BAD_WORDS);
$yummy   = array("[*****]");
$val['description'] = str_replace($healthy, $yummy, $val['description']);
/////////////////////////Bad Words End////////////////////////////

/////////////////////////// For Mobile///////////////////////////////

$pattern = "/(?:1-?)?(?:\(\d{3}\)|\d{3})[-\s.]?\d{3}[-\s.]?\d{4}/x";
$replacement = "[*****]";
$val['description'] = preg_replace($pattern, $replacement, $val['description']);

////////////////////////// Mobile End////////////////////////////////
?>
<description> <?php echo $val['description'];?> </description>
<pubDate><?php echo date('d M, Y',strtotime($val['post_date']));?></pubDate>
</item>
<?php
}
?>
<!-- end item Block -->
</channel>
</rss>