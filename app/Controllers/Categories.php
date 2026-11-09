<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Categories extends BaseController
{
    private ?CategoryModel $categoryModel = null;

    public function __construct()
    {
        helper('url');
    }

    private function model(): CategoryModel
    {
        return $this->categoryModel ??= new CategoryModel();
    }

    // READ: list with filter, search and pagination
    public function index()
    {
        $model  = $this->model();
        $type   = trim((string) $this->request->getGet('type'));
        $search = trim((string) $this->request->getGet('q'));

        if ($type !== '') {
            $model->where('type', $type);
        }
        if ($search !== '') {
            $model->like('name', $search);
        }

        $rows = $model->orderBy('id', 'ASC')->paginate(15);

        return view('categories/index', [
            'title'  => 'Categories',
            'rows'   => $rows,
            'pager'  => $model->pager,
            'types'  => $model->typeOptions(),
            'type'   => $type,
            'search' => $search,
        ]);
    }

    // CREATE: show form
    public function create()
    {
        return view('categories/form', [
            'title'  => 'Add Category',
            'action' => site_url('categories/store'),
            'row'    => null,
            'types'  => $this->model()->typeOptions(),
        ]);
    }

    // CREATE: save
    public function store()
    {
        return $this->persist(null);
    }

    // UPDATE: show form
    public function edit(int $id)
    {
        $row = $this->model()->find($id);
        if (! $row) {
            throw PageNotFoundException::forPageNotFound('Category not found.');
        }

        return view('categories/form', [
            'title'  => 'Edit Category #' . $id,
            'action' => site_url('categories/update/' . $id),
            'row'    => $row,
            'types'  => $this->model()->typeOptions(),
        ]);
    }

    // UPDATE: save
    public function update(int $id)
    {
        if (! $this->model()->find($id)) {
            throw PageNotFoundException::forPageNotFound('Category not found.');
        }

        return $this->persist($id);
    }

    // DELETE (POST only)
    public function delete(int $id)
    {
        $model = $this->model();
        $row   = $model->find($id);

        if (! $row) {
            return redirect()->to('categories');
        }

        try {
            $model->delete($id);
        } catch (\Throwable $e) {
            // Usually a foreign key: the category is used by existing transactions.
            return redirect()->to('categories')->with(
                'error',
                'Could not delete "' . $row['name'] . '". It is probably used by existing transactions.'
            );
        }

        return redirect()->to('categories')->with('success', 'Category "' . $row['name'] . '" deleted.');
    }

    // Shared validation + insert/update
    private function persist(?int $id)
    {
        $model = $this->model();

        $rules = [
            'name' => 'required|max_length[100]',
            'type' => 'required|in_list[' . implode(',', $model->typeOptions()) . ']',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => trim((string) $this->request->getPost('name')),
            'type' => (string) $this->request->getPost('type'),
        ];

        if ($id === null) {
            $model->insert($data);
            $message = 'Category added.';
        } else {
            $model->update($id, $data);
            $message = 'Category #' . $id . ' updated.';
        }

        return redirect()->to('categories')->with('success', $message);
    }
}
