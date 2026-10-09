<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Customers extends BaseController
{
    /**
     * Customer Accounts page ("/customers")
     * Records are retrieved from the `customers` table through CustomerModel.
     */
    public function index()
    {
        $customerModel = new CustomerModel();

        $data = [
            'title'     => 'Customer Accounts',
            'customers' => $customerModel->orderBy('id', 'ASC')->findAll(),
        ];

        return view('templates/header', $data)
            . view('customers/index', $data)
            . view('templates/footer');
    }

    /**
     * Empty "New Customer" form ("/customers/new")
     */
    public function new()
    {
        return $this->renderForm(
            'New Customer',
            site_url('customers/create'),
            'Save Customer',
            ['full_name' => '', 'email' => '', 'phone' => ''],
            []
        );
    }

    /**
     * Handles the New Customer form (POST "/customers/create").
     * CustomerModel validates the data; the record is inserted only if it passes.
     */
    public function create()
    {
        $customerModel = new CustomerModel();
        $data          = $this->formData();

        if (! $customerModel->insert($data)) {
            // Validation failed: show the form again with the typed values and the error messages.
            return $this->renderForm(
                'New Customer',
                site_url('customers/create'),
                'Save Customer',
                $data,
                $customerModel->errors()
            );
        }

        return redirect()->to('customers')
            ->with('success', 'Customer "' . $data['full_name'] . '" was added.');
    }

    /**
     * Edit form, pre-filled with the existing record ("/customers/edit/{id}")
     */
    public function edit(int $id)
    {
        $customer = $this->findOr404($id);

        return $this->renderForm(
            'Edit Customer',
            site_url('customers/update/' . $id),
            'Update Customer',
            $customer,
            []
        );
    }

    /**
     * Handles the Edit Customer form (POST "/customers/update/{id}").
     */
    public function update(int $id)
    {
        $this->findOr404($id);

        $customerModel = new CustomerModel();
        $data          = $this->formData();

        if (! $customerModel->update($id, $data)) {
            return $this->renderForm(
                'Edit Customer',
                site_url('customers/update/' . $id),
                'Update Customer',
                $data,
                $customerModel->errors()
            );
        }

        return redirect()->to('customers')
            ->with('success', 'Customer "' . $data['full_name'] . '" was updated.');
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------

    /** Reads and cleans the submitted form fields. An empty phone is stored as NULL. */
    private function formData(): array
    {
        $phone = trim((string) $this->request->getPost('phone'));

        return [
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'email'     => trim((string) $this->request->getPost('email')),
            'phone'     => $phone === '' ? null : $phone,
        ];
    }

    /** Returns the customer row or shows a 404 page when the id does not exist. */
    private function findOr404(int $id): array
    {
        $customer = (new CustomerModel())->find($id);

        if ($customer === null) {
            throw PageNotFoundException::forPageNotFound('Customer not found.');
        }

        return $customer;
    }

    /** Renders the shared form view (used by both "new" and "edit"). */
    private function renderForm(string $heading, string $action, string $submitLabel, array $customer, array $errors)
    {
        $data = [
            'title'       => $heading,
            'heading'     => $heading,
            'action'      => $action,
            'submitLabel' => $submitLabel,
            'customer'    => $customer,
            'errors'      => $errors,
        ];

        return view('templates/header', $data)
            . view('customers/form', $data)
            . view('templates/footer');
    }
}
