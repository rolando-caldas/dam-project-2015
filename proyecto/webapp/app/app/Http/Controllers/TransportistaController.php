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
 * TransportistaController es el controlador encargado de gestionar todo el contenido
 * de la sección "Transportista" de la webApp.
 * 
 * @author Rolando Caldas Sánchez <rolando.caldas@gmail.com>
 */
class TransportistaController extends ApiController {

    /**
     * Constante para utilizar en el controlador que define el nombre
     * de la entidad principal que gestiona.
     */
    const ENTITY = 'transportista';

    /**
     * 
     * Mostrar la sección de agregar transportista
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
     * Listar todos los transportistas
     * 
     * @param string $entity
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */    
    public function all($entity = self::ENTITY) {
        return parent::all($entity);
    }

    /**
     * Método que se encarga de recibir los datos el formulario de creación
     * de nuevo transportista y solicitar a la API su creación.
     * 
     * @param Request $request Objeto de Laravel que contiene la información
     *  de la request.
     * @return false|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */    
    public function create(Request $request) {
        
        $data = [
            'nif' => $request->input("nif"),
            'apellidos' => $request->input("apellidos"),
            'nombre' => $request->input("nombre"),
            'telefono' => $request->input("telefono"),
        ];

        return $this->itemCreate($data, self::ENTITY . '.json', self::ENTITY . '/view/{id}', 'Transportista creado correctamente');
    }

    /**
     * Método para mostrar el formulario de edición de un transportista
     * 
     * @param Request $request Objeto de Laravel que contiene la información
     *  de la request.
     * @param int $id Identificador del transportista
     * @param string $entity Nombre de la entidad
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */     
    public function edit(Request $request, $id, $entity = self::ENTITY) {
        return parent::edit($request, $id, $entity);
    }
    
    /**
     * Método que lista los envíos asociados a un transportista
     * 
     * @param int $id Identificador del transportista
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */    
    public function envio($id) {
        
        $return = null;

        $envios = $this->get(self::$entities['envio'] . '/'. self::$entities['transportista'] . '/' . $id . '.json');
        $transportista = $this->get(self::ENTITY . '/' . $id . '.json');
        
        if ($envios && $transportista) {
            
            $data = [
                'envios' => json_decode($envios->getBody()),
                'transportista' => json_decode($transportista->getBody()),
            ];

            $return = view(self::ENTITY . '.envio', $data);
            
        } else {
            
            $return = view('500', [], 500);
            
        }
        
        return $return;
        
    }
    
    /**
     * Método que obtiene la información de un envío asociado a un transportista.
     * 
     * @param int $transportista Identificador del transportista
     * @param int $envio Identificador del envío
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function envioInfo($transportista, $envio) {
        
        $return = null;
        $envioData = $this->get(self::$entities['envio'] . '/' . $envio . '.json');
        $transportistaData = $this->get(self::ENTITY . '/' . $transportista . '.json');
        
        if ($envioData && $transportistaData) {
            
            $entregas = $this->get(self::$entities['entrega'] . '/' . self::$entities['envio'] . '/' . $envio . '.json');
            $data = [
                'envio' => json_decode($envioData->getBody()),
                'transportista' => json_decode($transportistaData->getBody()),
                'entregas' => json_decode($entregas->getBody()),
            ];
            
            $return = view(self::ENTITY . '.info', $data);
            
        } else {
            $return = view('500', [], 500);
        }
        
        return $return;
        
    }        
    
    /**
     * Método que se encarga de recibir los datos el formulario de edición
     * de un transportista existente y solicitar a la API su modificación.
     * 
     * @param Request $request Objeto de Laravel que contiene la información
     *  de la request.
     * @param int $id Identificador del transportista a editar.
     * 
     * @return false|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */    
    public function update(Request $request, $id) {

        $data = [
            'nif' => $request->input("nif"),
            'apellidos' => $request->input("apellidos"),
            'nombre' => $request->input("nombre"),
            'telefono' => $request->input("telefono"),
        ];

        return $this->itemUpdate($data, self::ENTITY . '/' . $id . '.json', self::ENTITY . '/view/' . $id, 'Transportista modificado correctamente');
    }

    /**
     * 
     * Mostrar la ficha de información de transportista
     * 
     * @param Request $request Objeto de Laravel que contiene la información
     *  de la request.
     * @param int $id Identificador del transportista a mostrar.
     * @param string $entity Nombre de la entidad sobre la cual se quiere 
     *  consultar un elemento
     * 
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */     
    public function view(Request $request, $id, $entity = self::ENTITY) {
        return parent::view($request, $id, $entity);
    }

}
