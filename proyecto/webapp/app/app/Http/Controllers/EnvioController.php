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
use Illuminate\Http\Request;

/**
 * EnvioController es el controlador encargado de gestionar todo el contenido
 * de la sección "Envio" de la webApp.
 * 
 * @author Rolando Caldas Sánchez <rolando.caldas@gmail.com>
 */
class EnvioController extends ApiController {

    /**
     * Constante para utilizar en el controlador que define el nombre
     * de la entidad principal que gestiona.
     */
    const ENTITY = 'envio';

    /**
     * 
     * Mostrar la sección de agregar envio
     * 
     * @param Request $request Objeto de Laravel que contiene la información
     *  de la request.
     * @param string $entity Nombre de la entidad sobre la cual se quiere crear
     *  un nuevo elemento
     * 
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */    
    public function add(Request $request, $entity = self::ENTITY) {

        $data = $this->loadData($request);
        $old = $request->old();

        if (!empty($old)) {
            $data = array_merge($data, $old);
        }
                
        $cliente = $this->get('cliente.json');
        if ($cliente) {
            $data['clientes'] = json_decode($cliente->getBody());
        }    
        
        $transportista = $this->get('transportista.json');

        if ($transportista) {

            $data['clientes'] = json_decode($cliente->getBody());
            $data['transportistas'] = json_decode($transportista->getBody());
        }

        return view($entity . '.add', $data);
    }

    /**
     * Listar todos los envios
     * 
     * @param string $entity
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */    
    public function all($entity = self::ENTITY) {
        return parent::all($entity);
    }
    
    /**
     * Método que se encarga de recibir los datos el formulario de creación
     * de nuevo envío y solicitar a la API su creación.
     * 
     * @param Request $request Objeto de Laravel que contiene la información
     *  de la request.
     * @return false|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */    
    public function create(Request $request) {

        $client = explode(':', $request->input("cliente"));
        $trans = explode(':', $request->input("transportista"));
        
        $data = [
            'direccion' => $request->input("direccion"),
            'destinatario' => $request->input("destinatario"),
            'cliente' => array_shift($client),
            'transportista' => array_shift($trans),
        ];
        
        return $this->itemCreate($data, self::ENTITY . '.json', self::ENTITY . '/view/{id}', 'Envio creado correctamente');
    }

    /**
     * Método para mostrar el formulario de edición de un envío
     * 
     * @param Request $request Objeto de Laravel que contiene la información
     *  de la request.
     * @param int $id Identificador del envio
     * @param string $entity Nombre de la entidad
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */     
    public function edit(Request $request, $id, $entity = self::ENTITY) {
        return parent::edit($request, $id, $entity);
    }

    /**
     * Método que muestra el código QR asociado al envío, que ha de pegarse
     * como etiqueta en el paquete.
     * 
     * @param Request $request Objeto de Laravel que contiene la información
     *  de la request.
     * @param int $id Identificador del envío
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function qr(Request $request, $id) {
        
        
        $data = $this->loadData($request);
        $envio = $this->get(self::ENTITY . '/' . $id . '.json');

        if ($envio) {
            $data[self::ENTITY] = json_decode($envio->getBody());
            $data['qrInfo'] = json_encode([
                'id' => $id,
                'url' => str_replace('/qr', '/view', $request->url()),
            ]);            
        
            $return = view(self::ENTITY . '.qr', $data);
        } else {
            $return = view('404', [], 404);
        }
  
        return $return;
        
    }
 
    /**
     * Método que se encarga de recibir los datos el formulario de edición
     * de un envío existente y solicitar a la API su modificación.
     * 
     * @param Request $request Objeto de Laravel que contiene la información
     *  de la request.
     * @param int $id Identificador del envio a editar.
     * 
     * @return false|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */    
    public function update(Request $request, $id) {
        $return = null;

        $data = [
            'nif' => $request->input("nif"),
            'apellidos' => $request->input("apellidos"),
            'nombre' => $request->input("nombre"),
            'telefono' => $request->input("telefono"),
        ];

        $envio = $this->put(self::ENTITY . '/' . $id . '.json', ['body' => $data]);

        if ($envio === false) {
            $return = $this->redirectBackError(true);
        } else {

            $data = json_decode($envio->getBody());
            $return = redirect(self::ENTITY . '/view/' . $id)->with('success', 'Transportista modificado correctamente');
        }

        return $return;
    }

    /**
     * 
     * Mostrar la ficha de información de envio
     * 
     * @param Request $request Objeto de Laravel que contiene la información
     *  de la request.
     * @param int $id Identificador del envio a mostrar.
     * @param string $entity Nombre de la entidad sobre la cual se quiere 
     *  consultar un elemento
     * 
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */     
    public function view(Request $request, $id, $entity = self::ENTITY) {
        return parent::view($request, $id, $entity);
    }

}
