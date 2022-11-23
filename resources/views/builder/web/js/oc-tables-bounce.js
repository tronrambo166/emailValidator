/*!
 * Alan Da Silva - Viwari (https://codecanyon.net/user/viwari/portfolio)
 * Copyright 2017 Berevi Collection
 * Licensed (https://codecanyon.net/licenses/standard)
 * See full license https://codecanyon.net/licenses/terms/regular
 */

$(document).ready(function() {
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
});

function format(d) {
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px; width:100%;">' + 
        '<tr>' + 
            '<td style="vertical-align:top;">Bounce details:</td>' + 
            '<td>' + d.info + '</td>' + 
        '</tr>' + 
    '</table>';
}
