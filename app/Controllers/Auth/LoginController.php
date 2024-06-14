<?php
namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\LoginModel;
use RolesOptions;

class LoginController extends BaseController
{
    public function index()
    {
        $accessGranted = grantAccess();
        if ($accessGranted) return $accessGranted;
        return view('auth/login');
    }
    public function login()
    {
        $email = $this->request->getPost('login-email');
        $password = $this->request->getPost('login-password');
        $loginModel = new LoginModel();
        $data = [];

        // Buscar al usuario por su correo electrónico
        $user = $loginModel->where('email', $email)->first();
        if ($user) {
            // Verificar la contraseña
            if (password_verify($password, $user['password'])) {
                // Iniciar sesión exitosa
                $session = session();
                $session->set('id', $user['id']);
                $session->set('user_email', $user['email']);
                $session->set('rol', $user['rol_id']); // Establecer el rol del usuario

                // Redirigir al usuario según su rol
                switch ($user['rol_id']) {
                    case RolesOptions::AdminPrincipal:
                        return redirect('admin/dashboard');
                    case RolesOptions::AdministradorDePagos:
                        return redirect('punto/pago');
                    case RolesOptions::AdministradorDeEventos:
                        return redirect('eventos/dashboard'); // Ruta de ejemplo para el Administrador de Eventos
                    case RolesOptions::UsuarioPublico:
                        return redirect('public/dashboard'); // Ruta de ejemplo para el Usuario Público
                    default:
                        return redirect('login');
                }
            } else {
                // Contraseña incorrecta
                $data['error'] = 'Contraseña incorrecta';
                return view('auth/login', $data);
            }
        } else {
            // Usuario no encontrado
            $data['error'] = 'Correo electrónico no registrado';
            return view('auth/login', $data);
        }
    }
    public function forgotPassword()
    {
        $accessGranted = grantAccess();
        if ($accessGranted) return $accessGranted;
        return view('auth/forgot');
    }
    public function register()
    {
        $accessGranted = grantAccess();
        if ($accessGranted) return $accessGranted;
        return view('auth/register');
    }
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
