var Pages = "http://localhost/framework/Pages/";
var serverUrl = "http://localhost/framework/Webapp";
var News_Sources = ["CNN", "BBC", "TECHCRUNCH", "GOOGLE", "WIRED"];

(function(){
    Route();
    getModel();
})();

function checkData(type)
{
    if(sessionStorage.getItem(type) == null)
    {
        var req = {
            "type" : "View_Feed",
            "services" : "Rss",
            "name" : type,
        };
        server(type, "GET", req);
        return sessionStorage.getItem(type);
    }
    else if(sessionStorage.getItem(type) != null)
    {
        return sessionStorage.getItem(type);
    }
}


