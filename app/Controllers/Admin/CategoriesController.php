<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use ModulosAdmin;

class CategoriesController extends BaseController
{
    private function redirectView($validation=null, $flashMessages=null, $last_data=null)
    {
        return redirect()->to('admin/category/new')->
        with('flashValidation', isset($validation) ? $validation->getErrors() : null)->
        with('flashMessages', $flashMessages)->
        with('last_data', $last_data);
    }

    public function index()
    {
        // get flash data
        $flashValidation = session()->getFlashdata('flashValidation');
        $flashMessages = session()->getFlashdata('flashMessages');
        $last_data = session()->getFlashdata('last_data');
        $last_action = session()->getFlashdata('last_action');

        $categoryModel = new CategoryModel();
        $all_category = $categoryModel->findAll();


        $modulo = ModulosAdmin::CATEGORY_LIST;
        $data = [
            'categories' => $all_category,
            'last_action' => $last_action,
            'last_data' => $last_data,
            'validation' => $flashValidation,
            'flashMessages' => $flashMessages,
            'modulo' => $modulo,
        ];
        return view('admin/category',$data);
    }
    public function add()
    {
        $category_name = $this->request->getPost('category_name');
        $short_description = $this->request->getPost('short_description');

        $data = [
            'category_name' => trim($category_name),
            'short_description' => trim($short_description),
        ];

        try {
            $validation = \Config\Services::validation();
            $validation->setRules(
                [
                    'category_name' => [
                        'label' => 'Nombre de la categoría',
                        'rules' => 'required|min_length[3]|is_unique[categories.category_name]',
                    ],
                    'short_description' => [
                        'label' => 'Descripción corta',
                        'rules' => 'min_length[5]|permit_empty',
                    ]
                ]
            );

            if ($validation->run($data)) {
                $flashMessages = [];

                // Guardar los datos en la DB
                $categoryModel = new CategoryModel();
                $new_category = $categoryModel->insert($data);

                if (!$new_category) {
                    return $this->redirectView(null, [['No fue posible guardar la categoría', 'warning']], $data);
                } else {
                    $flashMessages[] = ['Categoría agregada exitosamente'];

                    return redirect()->to('admin/category/new')->with('flashMessages', $flashMessages);
                }
            } else {
                return $this->redirectView($validation, [['Error en los datos enviados', 'warning']], $data);
            }
        } catch (\Exception $e) {
            return $this->redirectView(null, [['No se pudo registrar la categoría', 'danger']]);
        }
    }

    public function new_category()
    {
        // get flash data
        $flashValidation = session()->getFlashdata('flashValidation');
        $flashMessages = session()->getFlashdata('flashMessages');
        $last_data = session()->getFlashdata('last_data');
        $last_action = session()->getFlashdata('last_action');


        $modulo = ModulosAdmin::CATEGORY_ADD;
        $data = [
            'last_action' => $last_action,
            'last_data' => $last_data,
            'validation' => $flashValidation,
            'flashMessages' => $flashMessages,
            'modulo' => $modulo,
        ];
        return view('admin/nueva_categoria',$data);
    }
}
