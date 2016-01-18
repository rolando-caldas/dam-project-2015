/**
 * DAM Project 2015
 *
 * @link      https://github.com/rolando-caldas/dam-project-2015
 * @copyright 2015 Rolando Caldas Sánchez
 * @license   http://opensource.org/licenses/MIT MIT license
 */

$(document).ready(function() {

    $("#qr").qrcode({
        "size" : 100,
        "text" : document.querySelector('#qrInfo').innerHTML
    });
    
});