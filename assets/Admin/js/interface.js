/** functions */
function dashboard()
{
   "use strict"
    var req = {
        0 : {
            type : "View_All_Users",
            services : "Account",
            name : "Account",
        },
        1 : {
            type : "View_All_Post",
            services : "Blog",
            name : "Blog",
        }
    };
    $.each(req, function(index, data){
        checkData(data['type'], data);
    });
    var dats = JSON.parse(JSON.stringify(req));
    var dat = [];
    $.each(dats, function(index, data){
        dat = JSON.parse(checkData(data['type'], ""));
        $('#'+data['type']+'_count').html('<div class="easy-pie main-pie text-info" data-percent="'+dat.length+'"><div class="percent">'+dat.length+'</div><div class="pie-title">Total '+data['name']+' Created</div></div>');
    })
}

function userManager()
{
    arrs = JSON.parse(checkData("View_All_Users", ""));
    bindData(arrs, "users", "tbody");
    /*$("table").jPut({
        jsonData: arrs,
        name: "users",
    });*/
}

function blogManager()
{
    arrs = JSON.parse(checkData("View_All_Post", ""));
    bindData(arrs, "blog-manager", "tbody");
}

function binder(id, req, url, type)
{
    $('#'+id).jPut({
        dataName:'',    //object name if the json data is in specified object
        jsonData: projects, //(jsonData/ajax_url) is required    your json data to append/prepend
        ajax_url: url,//ajax:Specifies the URL to send the request to. Default is the current page
        ajax_data: '', //ajax:specifies data to be sent to the server
        ajax_type: type, //ajax:specifies the type of request. (GET or POST)
        name: cat, //*required field jput template name
        limit: 20, //default:0         limit the number of record to show
        prepend:false, //default:false     If you want to prepend data make it true. By default data will append 
        done:function(e){   
                            //on success (e will be the json data)
            },
        error:function(msg){
            alert('Error Message:'+msg);    //On error
        }
    });
}

function previewModel(id, name, uname, image, email)
{
    $('#desc_name').html(name);
    $('#desc_uname').html(uname);
    $('#desc_image').attr('src', image);
    $('#desc_email').html('<i class="glyphicon glyphicon-envelope"></i> '+email);
    //bindData(arrs, "desc", "div");
}