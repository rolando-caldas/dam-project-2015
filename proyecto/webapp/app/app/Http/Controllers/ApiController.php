<?php

/**
 * DAM Project 2015
 *
 * @link      https://github.com/rolando-caldas/dam-project-2015
 * @copyright 2015 Rolando Caldas Sánchez
 * @license   http://opensource.org/licenses/MIT MIT license
 */

// Indicamos el espacio de nombres al que pertenece
namespace App\Http\Controllers;

// Cargamos las clases de otros espacios de nombres a utilizar
use App\Http\Controllers\Controller;
use GuzzleHttp;
use Illuminate\Http\Request;

/**
 * ApiController es la clase abstracta que extiende de Controller destinada
 * a ser la clase base para todos los controladores que necesiten comunicarse
 * con la Django REST Api del Proyecto (http://api.demosonline.org/
 * 
 * @author Rolando Caldas Sánchez <rolando.caldas@gmail.com>
 */
abstract class ApiController extends Controller {

    /**
     * Dominio web desde el cual acceder a la API
     * 
     * @var string 
     */
    private $host = 'http://api.homestead.app:8080/';

    /**
     * Array con el nombre de usuario y contraseña con el cual el sistema
     * se va a conectar con la API, el primer item del array es el nombre
     * de usuario y el segundo la contraseña.
     * 
     * @var string[]
     */
    private $auth = ['rolando', '123456'];

    /**
     * Propiedad destinada a almacenar la información sobre las excepciones
     * producidas durante el proceso de conexión a la API
     *  
     * @var mixed
     */
    protected $error;

    /**
     * Array asociativo con las diferentes entidades existentes en la API. Se
     * utiliza un array asociativo para que a lo largo del tiempo se mantengan
     * constantes en el código el nombre de las entidades, de este modo, aunque
     * en el futuro el modelo de datos haga que la entidad cliente pase a estar
     * en la API reflejada como "clientes" o "customers", sólo habrá que cambiar
     * el valor en el array asociativo a "customers" manteniendo como clave el
     * valor original "cliente" y, de esta forma, el código seguirá funcionando
     * sin tener que hacer modificaciones recursivas en la webAp.
     * 
     * @var string[] 
     */
    protected static $entities = [
        'cliente' => 'cliente',
        'entrega' => 'entrega',
        'envio' => 'envio',
        'transportista' => 'transportista',
    ];

    /**
     * Método para lanzar el formulario de creación de un nuevo item de la
     * entidad indicada de la API
     * 
     * @param Request $request Objeto de Laravel que contiene la información
     *  de la request.
     * @param string $entity Nombre de la entidad sobre la cual se quiere crear
     *  un nuevo elemento
     * 
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function add(Request $request, $entity) {

        $return = $this->isEntity($entity);

        if ($return === true) {

            $data = $this->loadData($request);
            $old = $request->old();

            if (!empty($old)) {
                $data = array_merge($data, $old);
            }
            $return = view($entity . '.add', $data);
        }

        return $return;
    }

    /**
     * Método para listar todos los elementos de una entidad, existentes 
     * en la API.
     * 
     * @param string $entity
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function all($entity) {

        $return = $this->isEntity($entity);

        if ($return) {
            $trans = $this->get($entity . '.json');
            if ($trans) {
                $return = view($entity . '.all', [$entity . 's' => json_decode($trans->getBody())]);
            } else {
                $return = view('500', [], 500);
            }
        }
        return $return;
    }

    /**
     * Por seguridad, se crea este método para que antes de realizar acciones
     * con la API, o relacionadas con ella, se coteje si la entidad que se 
     * desea utilizar existe en la propiedad self::$entities retornando true
     * en caso de éxito o la vista de error404 en caso contrario.
     * 
     * @param string $entity
     * @return true | \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    protected function isEntity($entity) {

        $return = true;

        if (!in_array($entity, self::$entities)) {

            $return = view('404', [], 404);
        }

        return $return;
    }

    /**
     * Método para mostrar el formulario de edición de un item de una 
     * entidad de la API
     * 
     * @param Request $request
     * @param type $id
     * @param type $entity
     * @return type
     */
    public function edit(Request $request, $id, $entity) {

        $return = $this->isEntity($entity);

        if ($return === true) {

            $data = $this->loadData($request);
            $old = $request->old();

            /*
             * Si la petición viene con el contenido del formulario, significa
             * que se está cargando el formulario tras haber sido enviado y
             * fallado la validación del mismo, por lo que no necesitamos solicitar
             * a la API la info, se puede pintar directamente la vista.
             * 
             * En caso contrario, se pide la información.
             */
            if (!empty($old)) {
                $data[$entity] = $old;
                $return = view($entity . '.edit', $data);
            } else {
                $item = $this->get($entity . '/' . $id . '.json');

                if ($item) {
                    $data[$entity] = json_decode($item->getBody());
                    $return = view($entity . '.edit', $data);
                } else {
                    $return = view('404', [], 404);
                }
            }
        }

        return $return;
    }

    /**
     * Método que lanza una petición de lectura a la API y retorna la 
     * información procesada o false en caso de que falle.
     * 
     * @param string $url URL sobre la cual relizar la petición HTTP
     * @param array $args Argumentos a agregar a la petición HTTP
     * 
     * @return fale | stdClass
     */
    final protected function get($url, $args = null) {

        $return = false;

        try {

            $client = new GuzzleHttp\Client();
            $res = $client->get($this->host . $url, $this->mixArgs($args));

            if ($res) {
                $this->error = false;
                $return = $res;
            }
        } catch (GuzzleHttp\Exception\ClientException $ex) {
            $this->error = $ex;
        }
        return $return;
    }

    /**
     * Método para solicitar la creación de un item en la entidad indicada
     * de la API
     * 
     * @param array $data Información a agregar en el nuevo item de la entidad.
     * @param string $url URL de la API que atiende las creaciones de items
     *  para la entidad
     * @param string $path URL de la webApp a la que debe redirigir el sistema
     *  cuando la API retorna éxito en la creación del item.
     * @param string $message Mensaje que debe visualizarse por pantalla cuando
     *  el item se crea correctamente
     * @return false|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    final protected function itemCreate($data, $url, $path, $message) {

        $return = false;

        $item = $this->post($url, ['body' => $data]);

        if ($item === false) {
            $return = $this->redirectBackError(true);
        } else {

            $data = json_decode($item->getBody());
            $return = redirect(str_replace("{id}", $data->id, $path))->with('success', $message);
        }

        return $return;
    }

    /**
     * Método para solicitar la actualización de un item en la entidad indicada
     * de la API
     * 
     * @param array $data Información a actualizar en el item de la entidad.
     * @param string $url URL de la API que atiende la edición del item concreto
     *  de la entidad
     * @param string $path URL de la webApp a la que debe redirigir el sistema
     *  cuando la API retorna éxito en la modificación del item.
     * @param string $message Mensaje que debe visualizarse por pantalla cuando
     *  el item se crea correctamente
     * @return false|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    final protected function itemUpdate($data, $url, $path, $message) {

        $return = false;

        $item = $this->put($url, ['body' => $data]);

        if ($item === false) {
            $return = $this->redirectBackError(true);
        } else {

            $data = json_decode($item->getBody());
            $return = redirect(str_replace("{{id}}", $data->id, $path))->with('success', $message);
        }

        return $return;
    }

    /**
     * Método que analiza la Request en buusca de mensajes enviados desde 
     * la última URL que deban ser mostradas en la actual carga del site.
     * 
     * @param Request $request
     * @return array
     */
    final protected function loadData(Request $request) {

        $data = [];

        if ($request->session()->has('info')) {
            $data['info'] = $this->processMessage($request->session()->get('info'));
        }

        if ($request->session()->has('success')) {
            $data['success'] = $this->processMessage($request->session()->get('success'));
        }

        if ($request->session()->has('warning')) {
            $data['warning'] = $this->processMessage($request->session()->get('warning'));
        }

        if ($request->session()->has('error')) {
            $data['error'] = $this->processMessage($request->session()->get('error'));
        }

        return $data;
    }

    /**
     * Método utilizado antes de las peticiones a la API para incorporar la
     * autenticación del usuario a la petición.
     * 
     * @param array $args
     * @return array
     */
    private function mixArgs($args) {

        if (empty($args)) {
            $args = [];
        }

        $args['auth'] = $this->auth;

        return $args;
    }

    /**
     * Método que lanza una petición de creación a la API y retorna la 
     * información procesada o false en caso de que falle.
     * 
     * @param string $url URL sobre la cual relizar la petición HTTP
     * @param array $args Argumentos a agregar a la petición HTTP
     * 
     * @return fale | stdClass
     */
    final protected function post($url, $args = null) {

        $return = false;

        try {

            $client = new GuzzleHttp\Client();
            $res = $client->post($this->host . $url, $this->mixArgs($args));

            if ($res) {
                $this->error = false;
                $return = $res;
            }
        } catch (GuzzleHttp\Exception\ClientException $ex) {
            $this->error = $ex;
        }

        return $return;
    }

    /**
     * Método que se encarga de procesar información y estructurarla en el
     * formato esperado para renderizar los mensajes de alertas en el site.
     * 
     * @param mixed $data
     * @return \stdClass
     */
    private function processMessage($data) {

        $return = [];

        $array = is_object($data) ? get_object_vars($data) : $data;

        if (is_array($array)) {
            foreach ($array AS $key => $value) {
                foreach ($value AS $text) {
                    $item = new \stdClass();
                    $item->key = $key;
                    $item->value = $text;

                    $return[] = $item;
                }
            }
        } else {
            $item = new \stdClass();
            $item->key = '';
            $item->value = $data;
            $return[] = $item;
        }
        return $return;
    }

    /**
     * Método que lanza una petición de modificación a la API y retorna la 
     * información procesada o false en caso de que falle.
     * 
     * @param string $url URL sobre la cual relizar la petición HTTP
     * @param array $args Argumentos a agregar a la petición HTTP
     * 
     * @return fale | stdClass
     */
    final protected function put($url, $args = null) {

        $return = false;

        try {

            $client = new GuzzleHttp\Client();
            $res = $client->put($this->host . $url, $this->mixArgs($args));

            if ($res) {
                $this->error = false;
                $return = $res;
            }
        } catch (GuzzleHttp\Exception\ClientException $ex) {
            $this->error = $ex;
        }

        return $return;
    }

    /**
     * Método encargado de obtener el error retornado por una petición a la
     * API y poder retornar a la misma pantalla con el error generado.
     * 
     * @param boolean $input Informa si se debe agregar la información del
     *  formulario original o no.
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    final protected function redirectBackError($input = false) {

        $return = null;

        if ($input === true) {
            $return = redirect()->back()->withInput()->with('error', json_decode($this->error->getResponse()->getBody()->getContents()));
        } else {
            $return = redirect()->back()->with('error', json_decode($this->error->getResponse()->getBody()->getContents()));
        }

        return $return;
    }

    /**
     * Método para obtener los datos de un item de una entidad almacenada en
     * la API.
     * 
     * @param Request $request Objeto de Laravel que contiene la información
     *  de la request.
     * @param int $id Identificador del item 
     * @param string $entity Nombre de la entidad
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */    
    public function view(Request $request, $id, $entity) {

        $return = $this->isEntity($entity);

        if ($return === true) {
            $data = $this->loadData($request);
            $trans = $this->get($entity . '/' . $id . '.json');

            if ($trans) {
                $data[$entity] = json_decode($trans->getBody());
                $return = view($entity . '.view', $data);
            } else {
                $return = view('404', [], 404);
            }
        }
        
        return $return;
    }

}
