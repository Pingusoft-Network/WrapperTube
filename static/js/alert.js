function showAlert(id) {
    $(id).fadeIn();
}

function addAlert(id, text) {
    $(".alerts").append("<div class='alert' style='display: none;' id=" + id + ">" + text + "<div style=\"float:right;background-color:white;width:15px;height:15px;border:1px solid gray;color:gray;display:block;font-weight:bold;border-radius:3px;margin-right:7px;cursor:pointer;\" onclick=\"$(this).parent().remove();\">x</div>&nbsp;</div>");
}
