function DatabaseInsert(type) {
    $.ajax({
        url: "resources/include/databaseFunction.php?insert=" + type,
        context: document.body
    }).done(function (result) {
        $(".index_time").append("<div class='temp'>" + result + "</div>").html($(".index_time_source").html());
        var alarmStatus = $(".index_status").append("<div class='temp'>" + result + "</div>").html($(".index_status_source").html()).text();
        $(".temp").remove();

        if (alarmStatus == "ON") {
            $(".onButton").addClass("disabled");
            $(".offButton").removeClass("disabled");
        }
        else if (alarmStatus == "OFF") {
            $(".onButton").removeClass("disabled");
            $(".offButton").addClass("disabled");
        }
    });
}

setInterval(function(){
    $.ajax({
        url: "resources/include/checkdata.php",
        context: document.body,
        success: function(data){
            if (data == "true"){
                location.reload();
            }
        }
    });
}, 4000);