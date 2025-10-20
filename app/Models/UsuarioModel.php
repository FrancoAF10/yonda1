<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table      = 'usuarios';
    protected $primaryKey = 'idusuario';
    protected $allowedFields = ['nombreusuario', 'claveacceso', 'idcontrato'];

    /**
     * Obtiene los datos de contacto (email y teléfono)
     * a partir del nombre de usuario.
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
