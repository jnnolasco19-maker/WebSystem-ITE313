<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MaterialModel;
use App\Models\EnrollmentModel;
use App\Models\CourseModel;
use CodeIgniter\HTTP\Files\UploadedFile;

class Materials extends BaseController
{
    // Displays the file upload form and handles the file upload process
    public function upload($course_id)
    {
        helper(['form', 'url']);
        $model = new MaterialModel();
        $data = [];
        
        $method = $this->request->getMethod();
        
        if (strtolower($method) === 'post') {
            $validation =  \Config\Services::validation();
            $validation->setRules([
                'file' => 'uploaded[file]|max_size[file,10240]|ext_in[file,pdf,doc,docx,ppt,pptx,txt,jpg,jpeg,png,zip,rar]'
            ]);
            if ($validation->withRequest($this->request)->run()) {
                $file = $this->request->getFile('file');
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $uploadPath = 'uploads/materials/';
                    
                    // Create upload directory if it doesn't exist
                    if (!is_dir($uploadPath)) {
                        mkdir($uploadPath, 0755, true);
                    }
                    
                    if ($file->move($uploadPath, $newName)) {
                        $insertData = [
                            'course_id' => $course_id,
                            'file_name' => $file->getClientName(),
                            'file_path' => $uploadPath . $newName,
                            'created_at' => date('Y-m-d H:i:s'),
                        ];
                        
                        // Test if materials table exists
                        $db = \Config\Database::connect();
                        $tables = $db->listTables();
                        $tableExists = in_array('materials', $tables);
                        
                        if (!$tableExists) {
                            session()->setFlashdata('error', 'Materials table does not exist. Please run migrations first.');
                        } else {
                            $insertResult = $model->insertMaterial($insertData);
                            
                        if ($insertResult) {
                            session()->setFlashdata('success', 'File has been uploaded successfully!');
                        } else {
                            $errors = $model->errors();
                            $dbError = $model->db->error();
                            session()->setFlashdata('error', 'File uploaded but failed to save to database. Error: ' . json_encode($errors) . ' ' . json_encode($dbError));
                        }
                        }
                    } else {
                        session()->setFlashdata('error', 'Failed to move uploaded file to directory.');
                    }
                } else {
                    session()->setFlashdata('error', 'Invalid file or file already moved.');
                }
                return redirect()->to("/admin/course/$course_id/upload");
            } else {
                session()->setFlashdata('error', 'Validation failed: ' . implode(', ', $validation->getErrors()));
                $data['validation'] = $validation;
            }
        }
        return view('materials/upload', array_merge($data, ['course_id' => $course_id]));
    }

    // Handles the deletion of a material record and the associated file
    public function delete($material_id)
    {
        $model = new MaterialModel();
        $material = $model->find($material_id);
        if ($material) {
            // Delete the physical file
            if (is_file($material['file_path'])) {
                unlink($material['file_path']);
            }
            $model->delete($material_id);
            session()->setFlashdata('success', 'Material deleted successfully.');
        } else {
            session()->setFlashdata('error', 'Material not found.');
        }
        return redirect()->back();
    }

    // Handles the file download for enrolled students
    public function download($material_id)
    {
        $materialModel = new MaterialModel();
        $enrollModel = new EnrollmentModel();
        $material = $materialModel->find($material_id);
        
        if (!$material) {
            session()->setFlashdata('error', 'Material not found.');
            return redirect()->back();
        }
        
        if (!is_file($material['file_path'])) {
            session()->setFlashdata('error', 'File not found on server: ' . $material['file_path']);
            return redirect()->back();
        }
        
        // Check if user is enrolled
        $user_id = session('userID');
        if (!$user_id) {
            session()->setFlashdata('error', 'You must be logged in to download materials.');
            return redirect()->back();
        }
        
        $is_enrolled = $enrollModel->isAlreadyEnrolled($user_id, $material['course_id']);
        if (!$is_enrolled) {
            session()->setFlashdata('error', 'You are not enrolled in this course.');
            return redirect()->back();
        }
        
        return $this->response->download($material['file_path'], null)->setFileName($material['file_name']);
    }

    // Display downloadable materials for a course
    public function list($course_id)
    {
        $model = new \App\Models\MaterialModel();
        $materials = $model->getMaterialsByCourse($course_id);
        return view('materials/list', ['materials' => $materials]);
    }
}
