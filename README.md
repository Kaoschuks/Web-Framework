# Web-Framework
Web application framework designed with various configuration, nth tier architecture and logics also data mappers and configuration

# Installation
Import Database.sql
Go to Entities/Db_config.php and change db config constants
Also change Entities/Variables.php defined variables to your site own
Open .htaccess and change site rewrite base from /framework/ to /YOUR-SITE/ and ./localhost/framework/ to ./localhost/YOUR-SITE/


# Usage
Run site on localhost/YOUR-SITE/ 
to view various queries go to localhost/YOUR-SITE/Webapp

# Queries
Add variables to Framework.php

Create rss feeds 
$_SERVER['REQUEST_METHOD'] = "POST";
$_REQUEST = array(
        "type" => "Create_Feed",
        "name" => "News",
        "services" => "Rss",
);

        Update rss feeds 
$_SERVER['REQUEST_METHOD'] = "POST";
$_REQUEST = array(
        "type" => "Update_Feed",
        "name" => "News",
        "services" => "Rss",
);

        Veiw rss feeds
$_SERVER['REQUEST_METHOD'] = "GET";
$_REQUEST = array(
        "type" => "Veiw_Feed",
        "name" => "News",
        "services" => "Rss",
);

# Architecture

framework.php is the first file to load the whole framework
htaccess my main site config file
Data layer/Security contains my files and libs for data security classes
Data Layer/DMining contains my classes for data mining
Data Layer/Compression contains my custom compression algorithms
Data Layer/DBManager contains my custom db and rss mapper
Service Layer/Security/  contains my services security classes


visit 
https://www.oreilly.com/ideas/software-architecture-patterns/page/2/layered-architecture
http://www.guidanceshare.com/wiki/Application_Architecture_Guide_-_Chapter_9_-_Layers_and_Tiers
to get insight on its architecture and its layers implementation

