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
 * ClientController es el controlador encargado de gestionar todo el contenido
 * de la sección "Cliente" de la webApp.
 * 
 * @author Rolando Caldas Sánchez <rolando.caldas@gmail.com>
 */
class ClienteController extends ApiController {

    /**
     * Constante para utilizar en el controlador que define el nombre
     * de la entidad principal que gestiona.
     */
    const ENTITY = 'cliente';

    /**
     * 
     * Mostrar la sección de agregar cliente
     * 
     * @param Request $request Objeto de Laravel que contiene la información
     *  de la request.
     * @param string $entity Nombre de la entidad sobre la cual se quiere crear
     *  un nuevo elemento
     * 
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function add(Request $request, $entity = self::ENTITY) {
        return parent::add($request, $entity);
    }
    
    /**
     * Listar todos los clientes
     * 
     * @param string $entity
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function all($entity = self::ENTITY) {
        return parent::all($entity);
    }
    
    /**
     * Método que se encarga de recibir los datos el formulario de creación
     * de nuevo cliente y solicitar a la API su creación.
     * 
     * @param Request $request Objeto de Laravel que contiene la información
     *  de la request.
     * @return false|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function create(Request $request) {
        
        $data = [
            'cif' => $request->input("cif"),
            'denominacion_social' => $request->input("denominacion_social"),
            'direccion' => $request->input("direccion"),
            'telefono' => $request->input("telefono"),
        ];
        
        return $this->itemCreate($data, self::ENTITY . '.json', self::ENTITY . '/view/{id}', 'Cliente creado correctamente');
    }
    
    /**
     * Método para mostrar el formulario de edición de un cliente
     * 
     * @param Request $request Objeto de Laravel que contiene la información
     *  de la request.
     * @param int $id Identificador del cliente
     * @param string $entity Nombre de la entidad
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */    
    public function edit(Request $request, $id, $entity = self::ENTITY) {
        return parent::edit($request, $id, $entity);
    }

    /**
     * Método que lista los envíos asociados a un cliente
     * 
     * @param int $id Identificador del cliente
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function envio($id) {
        
        $return = null;
        $envios = $this->get(self::$entities['envio'] . '/' . self::ENTITY . '/' . $id . '.json');
        $cliente = $this->get(self::ENTITY . '/' . $id . '.json');
        
        if ($envios && $cliente) {
            
            $data = [
                'cliente' => json_decode($cliente->getBody()),
                'envios' => json_decode($envios->getBody()),
            ];
            
            $return = view(self::ENTITY . '.envio', $data);
            
        } else {
            
            $return = view('500', [], 500);
            
        }
        
        return $return;
        
    }
    
    /**
     * Método que se encarga de mostrar el formulario para agregar un envío
     * asociado al cliente indicado.
     * 
     * @param int $id Identificador del cliente
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function envioAdd($id) {
        $cliente = $this->get(self::ENTITY . '/' . $id . '.json');
        $transportista = $this->get(self::$entities['transportista'] . '.json');
        
        if ($cliente && $transportista) {
            
            $data = [
                'cliente' => json_decode($cliente->getBody()),
                'transportistas' => json_decode($transportista->getBody()),
            ];
            
            $return = view(self::ENTITY . '.envioAdd', $data);
            
        } else {
            $return = view('500', [], 500);
        }
        
        return $return;
        
    }
    
    /**
     * Método que se encarga de recibir los datos el formulario de creación
     * de un nuevo envío asociado al cliente y solicitar a la API su creación.
     * 
     * @param Request $request Objeto de Laravel que contiene la información
     *  de la request.
     * @param int $id Identificador del cliente.
     * 
     * @return false|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */    
    public function envioCreate(Request $request, $id) {

        $trans = explode(':', $request->input("transportista"));
        
        $data = [
            'direccion' => $request->input("direccion"),
            'destinatario' => $request->input("destinatario"),
            'cliente' => $id,
            'transportista' => array_shift($trans),
        ];        
        
        $return = $this->itemCreate($data, self::$entities['envio'] . '.json', self::ENTITY . '/envio/' . $id . '/info/{id}', 'Envío creado correctamente');
        
        return $return;                
    }
    
    /**
     * Método que obtiene la información de un envío asociado a un cliente.
     * 
     * @param int $cliente Identificador del cliente
     * @param int $envio Identificador del envío
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function envioInfo($cliente, $envio) {
        
        $return = null;
        $envioData = $this->get(self::$entities['envio'] . '/' . $envio . '.json');
        $clienteData = $this->get(self::ENTITY . '/' . $cliente . '.json');

        if ($envioData && $clienteData) {
            
            $entregas = $this->get(self::$entities['entrega'] . '/' . self::$entities['envio'] . '/' . $envio . '.json');
            $data = [
                'envio' => json_decode($envioData->getBody()),
                'cliente' => json_decode($clienteData->getBody()),
                'entregas' => json_decode($entregas->getBody()),
                'qrInfo' => json_encode([
                    'id' => $envio,
                    'url' => 'http://homestead.app/envio/view/' . $envio,
                ]), 
            ];
             
            $return = view(self::ENTITY . '.info', $data);
            
        } else {
            $return = view('500', [], 500);
        }
        
        return $return;
        
    }
    
    /**
     * Método que se encarga de recibir los datos el formulario de edición
     * de un cliente existente y solicitar a la API su modificación.
     * 
     * @param Request $request Objeto de Laravel que contiene la información
     *  de la request.
     * @param int $id Identificador del cliente a editar.
     * 
     * @return false|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id) {

        $data = [
            'cif' => $request->input("cif"),
            'denominacion_social' => $request->input("denominacion_social"),
            'direccion' => $request->input("direccion"),
            'telefono' => $request->input("telefono"),
        ];
        
        return $this->itemUpdate($data, self::ENTITY . '/' . $id . '.json', self::ENTITY . '/view/' . $id, 'Cliente modificado correctamente');
    }    
    
    /**
     * 
     * Mostrar la ficha de información de cliente
     * 
     * @param Request $request Objeto de Laravel que contiene la información
     *  de la request.
     * @param int $id Identificador del cliente a mostrar.
     * @param string $entity Nombre de la entidad sobre la cual se quiere 
     *  consultar un elemento
     * 
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */    
    public function view(Request $request, $id, $entity = self::ENTITY) {
        return parent::view($request, $id, $entity);
    }
    
}
