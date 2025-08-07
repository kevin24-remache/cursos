<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CertificadosModel;

class CertificadosController extends BaseController
{
    // Listar certificados
    public function index()
    {
        $model = new CertificadosModel();
        $certificados = $model->listarCertificados();

        return view('admin/certificados/index', [
            'certificados' => $certificados
        ]);
    }

    // Formulario de subida
    public function nuevo()
    {
        return view('admin/certificados/nuevo');
    }

    // Guardar el certificado subido
    public function guardar()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nombre_certificado'   => 'required|string|max_length[255]',
            'archivo_certificado'  => 'uploaded[archivo_certificado]|max_size[archivo_certificado,4096]|ext_in[archivo_certificado,pdf,jpg,jpeg,png]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $file = $this->request->getFile('archivo_certificado');
        $nombreCert = $this->request->getPost('nombre_certificado');
        $userId = session('user_id') ?? 1; // ¡Ajusta esto según tu lógica de sesión!

        if ($file->isValid() && !$file->hasMoved()) {
            $newName = uniqid() . '_' . $file->getClientName();
            $file->move(ROOTPATH . 'public/uploads/certificados/', $newName);

            $model = new CertificadosModel();
            $model->insertarCertificado($nombreCert, $newName, $userId);

            return redirect()->to(base_url('admin/certificados'))->with('flashMessages', [['Certificado subido correctamente.', 'success']]);
        }

        return redirect()->back()->with('flashMessages', [['Error al subir el archivo.', 'error']]);
    }
}
