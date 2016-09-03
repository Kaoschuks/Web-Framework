<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>php feed reader demo</title>
<style type="text/css">
*{
font-family:Arial, Helvetica, sans-serif;
}
h1{margin:0;}
b{color:#333333;font-size:.8em}
form {
width:500px;
margin:auto;
background:#FFCC66;
padding:10px;
text-align:center;
}
div {
margin:auto;
padding:4px;
background:#EAEAEA;
width:600px;
border-bottom:solid thick #FFFFFF;
}
span{
display:block;
text-align:center;
}
</style>
</head>
<body>
<form action="<?=$_SERVER['PHP_SELF']; ?>" method="POST">
<b>Enter Feed Url</b><br />
<input name="url" type="text" style="width:400px;"><input name="Submit" type="submit" value="Get Feed">
</form>
<?php
if(!empty($_POST['url']))
{
$url=$_POST['url'];
include_once('Simple/autoloader.php');
require '../simple_html_dom/simple_html_dom.php';
$feed = new SimplePie();
$feed->set_feed_url($url);
$feed->enable_cache(false);
$feed->set_output_encoding('Windows-1252');
$feed->init();
$feed->handle_content_type();
echo "<span><h1>".$feed->get_title()."</h1>";
echo "<b>".$feed->get_description()."</b></span><hr />";
$itemCount=$feed->get_item_quantity();
$items=$feed->get_items();
    $image = null;
foreach($items as $item)
{
echo "Link ".$item->get_permalink()."<br />";
    echo "title".$item->get_title()."<br />";
    echo "date".$item->get_date()."<br />";
if ($category = $item->get_category())
echo "Category: ".$category->get_label()."<br />";
    echo "Description ".$item->get_description()."<br />";
        if($image === null)
        {
            if($enclosure = $item->get_enclosure())
            {
                $image = $enclosure->get_link();
            }
        }
        elseif($image === null)
        {
            $htmlDOM = new simple_html_dom();
            $htmlDOM->load($item->get_description());
            @ $image = $htmlDOM->find('img', 0)->src;
            unset($htmlDOM);
        }
        elseif($image === null)
        {
            $htmlDOM = new simple_html_dom();
            $htmlDOM->load($item->get_content());
            @ $image = $htmlDOM->find('img', 0)->src;
            unset($htmlDOM);
        }
    echo "Image : ".$image."<br /><br />";
}
}
?>
</body>
</html>
