<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo para gestionar los usuarios del sistema
 * 
 * @package App\Models
 */
class UsuarioModel extends Model
{
    /**
     * Nombre de la tabla en la base de datos
     * @var string
     */
    protected $table      = 'usuarios';
    /**
     * Clave primaria de la tabla
     * @var string
     */
    protected $primaryKey = 'idusuario';
    /**
     * Campos permitidos para operaciones de inserción y actualización
     * @var array
     */
    protected $allowedFields = ['nombreusuario', 'claveacceso', 'idcontrato'];

    /**
     * Obtiene los datos de contacto del empleado asociado al usuario
     * 
     * Este método realiza una consulta con múltiples JOINs para recuperar la
     * información de contacto (email y teléfono) de un empleado a partir de su
     * nombre de usuario. Navega a través de las relaciones:
     * Usuario > Contrato > Persona
     */
    public function getDatosContacto($usuario)
    {
        return $this->db->table('usuarios u')
            ->select('p.email, p.telefono')
            ->join('contratos c', 'c.idcontrato = u.idcontrato')
            ->join('personas p', 'p.idpersona = c.idpersona')
            ->where('u.nombreusuario', $usuario)
            ->get()
            ->getRowArray();
    }



}
