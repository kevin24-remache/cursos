<?php
namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\LoginModel;

class LoginController extends BaseController
{
    public function index()
    {
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
                // Puedes almacenar datos del usuario en la sesión aquí
                $session = session();
                $session->set('user_id', $user['id']);
                $session->set('user_email', $user['email']);
                // Redirigir al usuario a la página de inicio
                return redirect('admin/dashboard');
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
        return view('auth/forgot');
    }
    public function register()
    {
        return view('auth/register');
    }
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
