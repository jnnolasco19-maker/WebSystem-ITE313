<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        $search = $this->request->getGet('search');

        if ($search) {
            $model->like('name', $search)
                  ->orLike('email', $search)
                  ->orLike('role', $search)
                  ->orLike('status', $search);
        }

        $data = [
            'users'     => $model->findAll(),
            'search'    => $search ?? '',
            'editUser'  => null
        ];

        return view('admin/userManagement', $data);
    }

    public function edit($id)
    {
        $model = new UserModel();

        $data = [
            'users'     => $model->findAll(),
            'search'    => '',
            'editUser'  => $model->find($id)
        ];

        return view('admin/userManagement', $data);
    }

    public function update()
    {
        $model = new UserModel();

        $id = $this->request->getPost('id');
        $password = $this->request->getPost('password');

        $updateData = [
            'name'   => $this->request->getPost('name'),
            'role'   => $this->request->getPost('role'),
            'status' => $this->request->getPost('status'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Only update password if a new one is provided
        if (!empty($password)) {
            $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $model->update($id, $updateData);

        return redirect()->to('/users');
    }

    public function create()
{
    $model = new UserModel();

    $model->insert([
        'name'   => $this->request->getPost('name'),
        'email'  => $this->request->getPost('email'),
        'role'   => $this->request->getPost('role'),
        'password' => password_hash('default123', PASSWORD_DEFAULT),
        'status' => $this->request->getPost('status'),
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ]);

    return redirect()->to('/users');
}

}
