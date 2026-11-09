<?php

namespace App\Controllers;

use App\Models\AnalyticsModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Analytics extends BaseController
{
    public function __construct()
    {
        helper('url');
    }

    private function model(): AnalyticsModel
    {
        return model(AnalyticsModel::class);
    }

    // READ: list with filters + pagination
    public function index()
    {
        $model    = $this->model();
        $type     = trim((string) $this->request->getGet('type'));
        $clientId = trim((string) $this->request->getGet('client_id'));

        if ($type !== '') {
            $model->where('type', $type);
        }
        if ($clientId !== '' && ctype_digit($clientId)) {
            $model->where('client_id', (int) $clientId);
        }

        $rows = $model->orderBy('id', 'DESC')->paginate(15);

        return view('analytics/index', [
            'title'    => 'Analytics Records',
            'rows'     => $rows,
            'pager'    => $model->pager,
            'types'    => $model->typeOptions(),
            'type'     => $type,
            'clientId' => $clientId,
        ]);
    }

    // CREATE: show form
    public function create()
    {
        return view('analytics/form', [
            'title'  => 'Add Analytics Record',
            'action' => site_url('analytics/store'),
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
            throw PageNotFoundException::forPageNotFound('Record not found.');
        }

        return view('analytics/form', [
            'title'  => 'Edit Record #' . $id,
            'action' => site_url('analytics/update/' . $id),
            'row'    => $row,
            'types'  => $this->model()->typeOptions(),
        ]);
    }

    // UPDATE: save
    public function update(int $id)
    {
        if (! $this->model()->find($id)) {
            throw PageNotFoundException::forPageNotFound('Record not found.');
        }

        return $this->persist($id);
    }

    // DELETE (POST only, permanent)
    public function delete(int $id)
    {
        $model = $this->model();

        if ($model->find($id)) {
            $model->delete($id);
            return redirect()->to('analytics')->with('success', 'Record #' . $id . ' deleted.');
        }

        return redirect()->to('analytics');
    }

    // Shared validation + insert/update
    private function persist(?int $id)
    {
        $model = $this->model();

        $rules = [
            'client_id'  => 'required|is_natural_no_zero',
            'type'       => 'required|in_list[' . implode(',', $model->typeOptions()) . ']',
            'ip_address' => 'permit_empty|max_length[45]|valid_ip',
            'session_id' => 'permit_empty|max_length[128]',
        ];

        $errors = [];
        if (! $this->validate($rules)) {
            $errors = $this->validator->getErrors();
        }

        $data = [
            'client_id'  => (int) $this->request->getPost('client_id'),
            'type'       => (string) $this->request->getPost('type'),
            'ip_address' => trim((string) $this->request->getPost('ip_address')),
            'session_id' => trim((string) $this->request->getPost('session_id')),
        ];

        $created = trim((string) $this->request->getPost('created_at'));
        if ($created !== '') {
            $ts = strtotime($created);
            if ($ts === false) {
                $errors['created_at'] = 'Created at is not a valid date and time.';
            } else {
                $data['created_at'] = date('Y-m-d H:i:s', $ts);
            }
        } elseif ($id === null) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }

        if ($errors) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        if ($id === null) {
            $model->insert($data);
            $message = 'Record added.';
        } else {
            $model->update($id, $data);
            $message = 'Record #' . $id . ' updated.';
        }

        return redirect()->to('analytics')->with('success', $message);
    }
}
