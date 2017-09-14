$(document).ready(function(){
    $("div a").filter(function() {
        return location.href == this.href;
    })
        .attr('id', "active")
        .css('background-color','limegreen');
});