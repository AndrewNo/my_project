$('#item').bind('click', function () {
    var id_item = $('#item').data("id-item");
    $.ajax(
        {
            url: "/shop/view/index.html",
            type: "GET",
            data: ({id: id_item}),
            dataType: "html",

        }).done(function (html) {

        $("#results").append(html);
    });
    console.log(id_item);
});