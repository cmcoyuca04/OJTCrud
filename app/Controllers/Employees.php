<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Employees extends BaseController
{
    private ?EmployeeModel $employeeModel = null;

    public function __construct()
    {
        helper(['url', 'form']);
    }

    private function model(): EmployeeModel
    {
        return $this->employeeModel ??= new EmployeeModel();
    }

    // READ: list employees with search (by name or role) and pagination
    public function index()
    {
        $model  = $this->model();
        $search = trim((string) $this->request->getGet('q'));

        if ($search !== '') {
            $model->groupStart()
                ->like('name', $search)
                ->orLike('role', $search)
                ->groupEnd();
        }

        $rows = $model->orderBy('id', 'DESC')->paginate(10);

        return view('employees/index', [
            'title'  => 'Employees',
            'rows'   => $rows,
            'pager'  => $model->pager,
            'search' => $search,
        ]);
    }

    // CREATE: show the empty form
    public function create()
    {
        return view('employees/form', [
            'title'  => 'Add Employee',
            'action' => site_url('employees/store'),
            'row'    => null,
        ]);
    }

    // CREATE: save the new employee
    public function store()
    {
        if (! $this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model()->insert($this->postedData());

        return redirect()->to('employees')->with('success', 'Employee added.');
    }

    // UPDATE: show the form filled with the existing employee
    public function edit(int $id)
    {
        $row = $this->findOr404($id);

        return view('employees/form', [
            'title'  => 'Edit Employee #' . $id,
            'action' => site_url('employees/update/' . $id),
            'row'    => $row,
        ]);
    }

    // UPDATE: save the changes
    public function update(int $id)
    {
        $this->findOr404($id);

        if (! $this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model()->update($id, $this->postedData());

        return redirect()->to('employees')->with('success', 'Employee #' . $id . ' updated.');
    }

    // DELETE: remove an employee (POST only, so a link can't delete by accident)
    public function delete(int $id)
    {
        $row = $this->findOr404($id);

        $this->model()->delete($id);

        return redirect()->to('employees')->with('success', 'Employee "' . $row['name'] . '" deleted.');
    }

    private function rules(): array
    {
        return [
            'name' => ['label' => 'Name', 'rules' => 'required|max_length[255]'],
            'role' => ['label' => 'Role', 'rules' => 'required|max_length[100]'],
        ];
    }

    private function postedData(): array
    {
        return [
            'name' => trim((string) $this->request->getPost('name')),
            'role' => trim((string) $this->request->getPost('role')),
        ];
    }

    private function findOr404(int $id): array
    {
        $row = $this->model()->find($id);

        if (! $row) {
            throw PageNotFoundException::forPageNotFound('Employee not found.');
        }

        return $row;
    }
}
