function newsViewModel(cat)
{
    var ui = "<div";
    $.each(News_Sources, function(key, id){
        ui += ' jPut="'+cat+"_"+id+'"><h5>'+id+'</h5><h5>'+cat+'</h5><h3>{{title}}</h3><p>{{description}}</p><a href="{{link}}">{{title}}</a><span>{{date}}</span><img src="{{image}}" /></div><div';
    })
    $('#'+cat).html(ui);
}

var arrs = [];

function Route()
{
    var page = $('body').attr('data-page');
    if(page != null)
    {
        loadUrlContent(page, page, "");
    }
    
    $("a[data-page]").on('click', function(e){
        e.preventDefault();
        var $this = $(this);
        loadUrlContent($this.text(), $this.attr("data-page"), $this.attr("href"));
    });
}

function loadUrlContent(title, url, link)
{
    document.title = title;
    window.history.pushState({title : title, url : url}, title, link);
    var file = $.get(Pages+url);
    file.done(function(data){$("#content").html(data);});
    file.fail(function(jqXHR, status, errorMsg){
        if(status == 'timeout'){console.log(errorMsg);}
        if(status == 'error'){}
    });
}

function server(type, method, request) 
{
    $.ajax({
        type : method,
        url : serverUrl,
        data : request,
        dataType : "json",
        global : false,
        success : function(content, textStatus, jqXHR) {
            saveModel(type, content.response.output);
            bindModel(type);
        },
        complete: function() {

         //setTimeout(getWorld, 5000);
          },

        error: function( xhr, textStatus ) {

            }
    });
}

function getModel()
{
    $(document).on('click', 'a[data-model]', function(e){
        e.preventDefault();
        var $this = $(this),
        model = $this.attr("data-model"),
        cat = $this.attr("data-catgeory");
        viewModel(model, cat);
    });
}

function viewModel(type, cat)
{
    arrs = JSON.parse(checkData(type));
    switch(cat)
    {
        case "Fashion":
        case "Sport":
        case "Entertainment":
        case "Technology":
        {
            newsViewModel(cat);
            bindData(arrs[cat], cat);
            break;
        }
        default:
        {
            $.each(arrs, function(index, data){
                newsViewModel(index);
                bindData(arrs[index], index);
            })
        }
    }
}

function saveModel(type, data)
{
    sessionStorage.setItem(type, JSON.stringify(data));
}

function bindData(data, cat)
{
    $.each(data, function(index, arr){
        $("#"+cat).jPut({
            jsonData: arr,
            name: cat+"_"+index,
        });
    });
}