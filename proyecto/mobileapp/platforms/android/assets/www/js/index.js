/**
 * DAM Project 2015
 *
 * @link      https://github.com/rolando-caldas/dam-project-2015
 * @copyright 2015 Rolando Caldas Sánchez
 * @license   http://opensource.org/licenses/MIT MIT license
 */


/*
 * Definimos el módulo mobileApp como módulo de angularJS. Este móduo es
 * nuestra aplicación.
 */
var mobileApp = angular.module('mobileApp', []);

/**
 * Agregamos como factory la functión Base64 para poder codificar
 * los datos de conexión a la API
 */
mobileApp.factory('Base64', function () {
    var keyStr = 'ABCDEFGHIJKLMNOP' +
            'QRSTUVWXYZabcdef' +
            'ghijklmnopqrstuv' +
            'wxyz0123456789+/' +
            '=';
    return {
        encode: function (input) {
            var output = "";
            var chr1, chr2, chr3 = "";
            var enc1, enc2, enc3, enc4 = "";
            var i = 0;

            do {
                chr1 = input.charCodeAt(i++);
                chr2 = input.charCodeAt(i++);
                chr3 = input.charCodeAt(i++);

                enc1 = chr1 >> 2;
                enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
                enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
                enc4 = chr3 & 63;

                if (isNaN(chr2)) {
                    enc3 = enc4 = 64;
                } else if (isNaN(chr3)) {
                    enc4 = 64;
                }

                output = output +
                        keyStr.charAt(enc1) +
                        keyStr.charAt(enc2) +
                        keyStr.charAt(enc3) +
                        keyStr.charAt(enc4);
                chr1 = chr2 = chr3 = "";
                enc1 = enc2 = enc3 = enc4 = "";
            } while (i < input.length);

            return output;
        },
        decode: function (input) {
            var output = "";
            var chr1, chr2, chr3 = "";
            var enc1, enc2, enc3, enc4 = "";
            var i = 0;

            // remove all characters that are not A-Z, a-z, 0-9, +, /, or =
            var base64test = /[^A-Za-z0-9\+\/\=]/g;
            if (base64test.exec(input)) {
                alert("There were invalid base64 characters in the input text.\n" +
                        "Valid base64 characters are A-Z, a-z, 0-9, '+', '/',and '='\n" +
                        "Expect errors in decoding.");
            }
            input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

            do {
                enc1 = keyStr.indexOf(input.charAt(i++));
                enc2 = keyStr.indexOf(input.charAt(i++));
                enc3 = keyStr.indexOf(input.charAt(i++));
                enc4 = keyStr.indexOf(input.charAt(i++));

                chr1 = (enc1 << 2) | (enc2 >> 4);
                chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
                chr3 = ((enc3 & 3) << 6) | enc4;

                output = output + String.fromCharCode(chr1);

                if (enc3 != 64) {
                    output = output + String.fromCharCode(chr2);
                }
                if (enc4 != 64) {
                    output = output + String.fromCharCode(chr3);
                }

                chr1 = chr2 = chr3 = "";
                enc1 = enc2 = enc3 = enc4 = "";

            } while (i < input.length);

            return output;
        }
    };
});

/**
 * Creamos el controlador enviosCtrl encargado de obtener el listado
 * de envíos pendientes del transportista y gestionar la parte de la vista
 * asociada a enviosCtrl
 */
mobileApp.controller('enviosCtrl', function ($scope, $rootScope, $http, Base64) {

    /**
     * Indicamos que por defecto su vista está activa
     */
    $scope.hide = false;

    /**
     * Método para capturar el click sobre un envío del listado y trasladar
     * el control de la aplicación al controlador entregaCtrl
     * 
     * @param {type} val
     * @returns {undefined}
     */
    $scope.activaEntrega = function (val) {
        $scope.hide = true;
        $rootScope.$emit("loadEntrega", val);
    };

    $scope.carga = function () {

        /**
         * Generamos el listado de envíos
         */
        $http.defaults.headers.common['Authorization'] = 'Basic ' + Base64.encode(config.user + ':' + config.pass);
        $http({method: 'GET', url: config.url + 'envio/transportista/' + config.transportista + '/pendiente.json'}).success(function (response) {
            $scope.envios = response;
        });
    };
    /**
     * Método que captura el evento activarEnviosCtrl para que el control
     * de la aplicación vuelva a enviosCtrl
     */
    $rootScope.$on('activarEnviosCtrl', function () {
        $scope.hide = false;
        $scope.carga();
    });


    $scope.carga();
});

/**
 * Controlador scanCtrl encargado de gestionar el proceso de scaneo de un
 * código QR
 */
mobileApp.controller('scanCtrl', function ($scope, $rootScope, $http, Base64) {

    /**
     * Método que lanza el escaneador de códigos QR
     * @returns {undefined}
     */
    $scope.runScan = function () {
        cordova.plugins.barcodeScanner.scan(
                function (result) {
                    var decode = JSON.parse(result.text);

                    /*
                     * Si el código QR tiene el formato esperado, se dispara
                     * el evento loadEntrega para trasladar el control
                     * de la aplicación al controlador entregaCtrl
                     */
                    if (typeof (decode) === 'object') {
                        $rootScope.$emit("loadEntrega", decode.id);
                    }
                },
                function (error) {
                    /*
                     * Si el código QR no tiene el formato esperado,
                     * se dispara el evento activarEnviosCtrl para devolver
                     * el control de la app a entregaCtrl y se lanza
                     * una alerta con el error
                     */
                    $rootScope.$emit('activarEnviosCtrl');
                    alert(error);
                }
        );
    };

});

/**
 * Controlador que gestion la vista de enviar la información sobre la 
 * entrega a la API
 */
mobileApp.controller('entregaCtrl', function ($scope, $rootScope, $http, Base64) {


    $scope.canvas = null;

    $scope.signaturePad = null;

    $scope.stroke = {
        thin: {
            minWidth: '0.5',
            maxWidth: '2.5'
        },
        normal: {
            minWidth: '2.5',
            maxWidth: '4.5'
        },
        strong: {
            minWidth: '4.5',
            maxWidth: '6.5'
        },
        stronger: {
            minWidth: '6.5',
            maxWidth: '8.5'
        }
    };

    /**
     * Indicamos que si vista no está activa
     */
    $scope.hide = true;

    /**
     * Definimos la variable dónde se almacenará e id de envío
     */
    $scope.entrega = '';

    /**
     * Método que captura el evento loadEntrega y carga la vista de 
     * generar entrega.
     */
    $rootScope.$on('loadEntrega', function (event, args) {
        $scope.hide = false;
        $scope.canvas = document.querySelector("#firmaArea");
        $scope.canvas.width = 300;
        $scope.canvas.height = 200;

        $scope.signaturePad = new SignaturePad($scope.canvas);
        $scope.entrega = args;
    });

    /**
     * Método que retorna el control de la app a enviosCtrl
     * @returns {undefined}
     */
    $scope.cancelar = function () {
        $scope.hide = true;
        $rootScope.$emit('activarEnviosCtrl');
    };

    /**
     * Método para limpia el área canvas de recogida de firma
     * @returns {undefined}
     */
    $scope.clear = function () {
        $scope.signaturePad.clear();
    };

    /**
     * Método que envía la información de la entrega a la API 
     * @returns {undefined}
     */
    $scope.enviar = function () {

        /**
         * Se genera el objeto data con la información necesaria
         * para crear una entrega
         */
        data = {
            envio: $scope.entrega,
            fecha_entrega: new Date().toISOString(),
            firma: $scope.canvas.toDataURL(),
            transportista: config.transportista,
            observaciones: document.querySelector("#observaciones").innerHTML
        };

        /**
         * Solicita a la API crear la entrega
         */
        $http.defaults.headers.common['Authorization'] = 'Basic ' + Base64.encode(config.user + ':' + config.pass);
        $http({
            method: 'POST',
            url: config.url + 'entrega.json',
            data: {
                envio: $scope.entrega,
                fecha_entrega: new Date().toISOString(),
                firma: $scope.canvas.toDataURL(),
                transportista: config.transportista,
                observaciones: document.querySelector("#observaciones").value
            }}).success(function (response) {
            /**
             * Cuando la entrega se crea correctamente, se tiene que limpiar
             * el área de firma y, si el envío se marcó como cerrado solicitar
             * nuevamente a la API que se marque el envío como cerrado.
             */
            $scope.clear();
            if (document.querySelector("#cerrarEnvio").checked === true) {
                document.querySelector("#cerrarEnvio").checked = false;

                $http.defaults.headers.common['Authorization'] = 'Basic ' + Base64.encode(config.user + ':' + config.pass);
                $http({
                    method: 'GET',
                    url: config.url + 'envio/' + $scope.entrega + '.json',
                    data: {
                        entregado: true
                    }
                }).success(function (response) {

                    response.entregado = true;

                    $http.defaults.headers.common['Authorization'] = 'Basic ' + Base64.encode(config.user + ':' + config.pass);
                    $http({
                        method: 'PUT',
                        url: config.url + 'envio/' + $scope.entrega + '.json',
                        data: response
                    }).success(function (response) {
                        $scope.cancelar();
                    });

                });

            } else {
                $scope.cancelar();
            }
        });
    };
});
