var Pages = "http://localhost/framework/Pages/Admin/";
var serverUrl = "http://localhost/framework/Webapp";
var Url = "http://localhost/framework/";
var urls = ["Dashboard", "Blogs-Manager","Settings", "Analytics", "Users-Manager", "Feeds-Manager"];
var errs = ["400", "401", "402", "403", "404", "500", "501", "503"];
var arrs = [];
//var csrf = $('body').attr('verify');
var csrf = "Kaos chuks";
var page = $('body').attr('data-page');

window.onload = function(){
    //Route();
    $('button[data-function="Login"]').on('click', function(){
        functionality();
    });
}

/* getting data fom server and saving */
function server(type, method, request) 
{
    $.ajax({
        type : method,
        url : serverUrl,
        data : request,
        dataType : "json",
        global : false,
        success : function(content, textStatus, jqXHR) {
            //saveModel(type, content.response.output);
            //viewModel(type);
            error(type, content);
        },
        beforeSend: function (xhr) {
            xhr.setRequestHeader("Authorization", "Basic " + btoa("kels : kaosc"));
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.setRequestHeader('Content-Length', request.length);
            xhr.setRequestHeader('Accept', "application/json");
            xhr.setRequestHeader('X_CSRF_TOKEN', csrf);
        },
        complete: function() {

         //setTimeout(getWorld, 5000);
        },

        error: function( xhr, textStatus ) {

        }
    });
}

function saveModel(type, data)
{
    sessionStorage.setItem(type, JSON.stringify(data));
}

/* Routing  */
function Route()
{
    if(page != null && page != "Dashboard")
    {
        loadUrlContent(page, page, "");
        //viewModel(page);
    }  
    elseif(page != null && page == "Dashboard")
    {
        //loadUrlContent(page, page, "");
        viewModel(page);
    }   
    
    $("a[data-page]").on('click', function(e){
        e.preventDefault();
        var $this = $(this);
        var pag = $this.attr("data-error");
        if(pag != null)
        {
            loadErrUrlContent($this.attr("data-page"), "Error", $this.attr("href"));
        }
        else if(pag == null)
        {
            loadUrlContent($this.text(), $this.attr("data-page"), $this.attr("href"));
        }
    });
}

/* Changing the page content */
function loadUrlContent(title, url, link)
{
    document.title = title;
    window.history.pushState({title : title, url : url}, title, link);
    var file = $.get(Pages+url);
    file.done(function(data){
        $("body").html(data);
        viewModel(url);
    });
    file.fail(function(jqXHR, status, errorMsg){
        if(status == 'timeout'){console.log(errorMsg);}
        if(status == 'error'){$("#content").html(errorView(url, status, errorMsg));}
    });
}

function loadErrUrlContent(title, url, link)
{
    document.title = title;
    window.history.pushState({title : title, url : url}, title, link);
    var file = $.get(Pages+url);
    file.done(function(data){$(".error-content").html(data)});
    file.fail(function(jqXHR, status, errorMsg){
        if(status == 'timeout'){console.log(errorMsg);}
        if(status == 'error'){errorView(url, status, errorMsg)}
    });
}

function errorView(url, status, msg)
{   
    var emsg = '<div class="block-header"><h2 class="text-danger">Resource Loading Error </h2></div><div class="container"><div class="col-sm-12 col-xs-12 col-md-12 animated bounceIn"><div class="card"><div class="card-header"><h1>Sorry but there was an error: <h4>resource  <strong class="text-danger">'+url+'</strong> not found with status   <strong class="text-danger">'+status+'</strong> and message <strong class="text-danger">'+msg+'</strong> from server</h4></h1></div></div></div>';
    $("#content").html(emsg);
}

/* binding data to various page */
function bindData(data, cat, id)
{
    $(id).jPut({
        jsonData: data,
        name: cat,
    });
}

function checkData(type, req)
{
    if(sessionStorage.getItem(type) == null)
    {
        server(type, "GET", req);
        return sessionStorage.getItem(type);
    }
    else if(sessionStorage.getItem(type) != null)
    {
        return sessionStorage.getItem(type);
    }
}

function viewModel(type)
{
    switch(type)
    {
        case "Dashboard":
        {
            //dashboard();
            break;
        }
        case "Blogs-Manager":
        {
            //blogManager();
            break;
        }
        case "Users-Manager":
        {
            //userManager();
            break;
        }
        default:
        {
            break;
        }
    }
}

function functionality()
{
    switch($('#func').attr('data-function'))
    {
        case "Login":
        {
            var request = {uname: $('input[name="uname"]').val(), passwd: $('input[name="passwd"]').val(), type: "Login", services: "Auth"};
            server("Login", "POST", request);
            break;
        }
        default:
        {
            alert("Error processing functionality "+$('#func').attr('data-function'));
        }
    }
}

function error(type, content)
{
    switch(type)
    {
        case "Login":
        {
            if(content.response.output == "Incorrect username or password"){$('.error').html(content.response.output)}else{saveModel("User", content.response.output.user); window.location = "Dashboard"}
            break;
        }
        default:
        {
            
        }
    }
}
