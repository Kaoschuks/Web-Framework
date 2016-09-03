<?php

/**
 * Variables short summary.
 *
 * Variables description.
 *
 * @version 1.0
 * @author Kaos
 */

//@ define('SERVICE_ACTIVATION', "false");
@ define('CDN', "http://localhost/framework/assets/");
@ define('ADMIN_CDN', "http://localhost/framework/assets/Admin/");
@ define('SITE', "http://localhost/framework/");
@ define('ERR', "http://localhost/framework/404");
@ define('USER_PATH', "http://localhost/framework/assets/files/");
@ define('ADMIN_Err', "http://localhost/framework/Admin/Error");
@ define('ADMIN_Login', "http://localhost/framework/Admin/Login");

/* site meta variables */
define("SHORT_ICON", "");
define("APP_NAME", "");
define("COYPRIGHT", "");
define("AUTHOR", "");

/* google meta variables */
define("GOOGLE_AUTHOR", "");
define("GOOGLE_NAME", "");
define("GOOGLE_PAGE", "");
@ define("GOOGLE_PUBLISHER_URL", $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
define("GOOGLE_IMAGE", "");

/* facebook meta variables */
define("FB_DESCRIPTION", "");
define("FB_TYPE", "");
define("FB_TITLE", "");
define("FB_IMAGE", "");
define("FB_SECURE_IMAGE", "");
define("FB_ADMIN", "");
define("FB_SITE_NAME", "");
@ define("FB_URL", $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

 class Variables
{
    public $Page_Routes = array(
        "/Home" => "Home",
        "/Contact" => "Contact",
        "/Help" => "Help",
        "/Login" => "Login",
        "/Register" => "Register",
        "/Blog" => "Blog",
        "/Admin" => "Admin",
    );
     
    public $Feeds = array(
        "News" => array(
            "Trending" => array(
                "World" => "https://news.google.com/news?topic=w&output=rss",
                "Technology" => "https://news.google.com/news?topic=t&output=rss",
                "Business" => "https://news.google.com/news?topic=b&output=rss",
                "Sport" => "https://news.google.com/news?topic=s&output=rss",
                "Entertainment" => "https://news.google.com/news?topic=e&output=rss",
            ),
            "World" => array(
                "CNN" => "http://rss.cnn.com/rss/edition_world.rss",
                "BBC" => "http://feeds.bbci.co.uk/news/world/rss.xml",
                "GOOGLE" => "https://news.google.com/news?topic=w&output=rss",
                "REUTERS" => "http://feeds.reuters.com/reuters/topNews",
            ),
            "Technology" => array(
                "TECHCRUNCH" => "http://feeds.feedburner.com/TechCrunch",
                //"TECHWORLD" => "http://www.techworld.com/news/rss",
                //"NEWYORKTIMES" => "http://feeds.nytimes.com/nyt/rss/Technology",
                "GOOGLE" => "https://news.google.com/news?topic=t&output=rss",
                "WIRED" => "http://feeds.wired.com/wired/index",
                "BBC" => "http://feeds.bbci.co.uk/news/technology/rss.xml",
                "CNN" => "http://rss.cnn.com/rss/edition_technology.rss",
                "HOLLYWOODREPORTER" => "http://feeds.feedburner.com/TheHollywoodReporter-Technology?format=xml",
                //"CBNC" => "http://www.cnbc.com/id/19854910/device/rss/rss.html",
            ),
           "Business" => array(
                "BBC" => "http://feeds.bbci.co.uk/news/business/rss.xml",
                "CNN" => "http://rss.cnn.com/rss/money_latest.rss",
                "GOOGLE" => "https://news.google.com/news?topic=b&output=rss",
                //"CBNC" => "http://www.cnbc.com/id/10001147/device/rss/rss.html",
                //"FINANCIALTIMES" => "http://www.ft.com/rss/personal-finance/investments/trading-ideas",
                //"ECONOMIST" => "http://www.economist.com/sections/business-finance/rss.xml",
            ),
            "Entertainment" => array(
                "BBC" => "http://feeds.bbci.co.uk/news/entertainment_and_arts/rss.xml",
                "GOOGLE" => "https://news.google.com/news?topic=e&output=rss",
                "CNN" => "http://rss.cnn.com/rss/edition_entertainment.rss",
                "HOLLYWOOD-REPORTER" => "http://feeds.feedburner.com/thr/boxoffice",
                //"EONLINE" => "http://feeds.feedburner.com/EtsBreakingNews",
                //"TMZ" => "http://www.tmz.com/rss.xml",
                //"NEWYORKERHUMOR" => "http://www.newyorker.com/feed/humor",
            ),
            "Sport" => array(
                "GOOGLE" => "https://news.google.com/news?topic=s&output=rss",
                "CNN" => "http://rss.cnn.com/rss/edition_sport.rss",
                //"TMZ" => "http://www.tmz.com/category/TMZsports/rss.xml",
                //"NEWYORKTIMES" => "http://feeds1.nytimes.com/nyt/rss/Sports",
                //"APSPORTS" => "http://hosted.ap.org/lineups/SPORTSHEADS-rss_2.0.xml?SITE=VABRM&SECTION=HOME",
                "SPORTILLUSTRATED" => "http://www.si.com/rss/si_topstories.rss",
            ),
            "Fashion" => array(
                //"TMZ" => "http://www.tmz.com/category/fashion/rss.xml",
                "EONLINE" => "http://feeds.etonline.com/ETFashion",
            ),
        ),
        "DIY" => array(
        ),
    );
     
    public $Method = array(
        "POST" => array("Register", "Login", "Create_File", "Create_Feed", "Delete_Feed", "Update_Feed", "Create_Users", "Delete_Users", "Update_Users", "Create_Post", "Delete_Post", "Update_Post", "Add_Comment", "Delete_Comment", "Update_Comment"),
        "GET" => array("View_Feed", "View_Users", "View_All_Users", "View_All_Post", "View_Post", "View_All_Comment", "shareCount", "generateSiteMap", "webRanking"),
    );
}
