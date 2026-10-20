<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\Files\UploadedFile;

class Users extends BaseController
{
    /** Avatars are saved as square thumbnails of this size (pixels). */
    private const AVATAR_SIZE = 200;

    /**
     * User Accounts page ("/users")
     * Records are retrieved from the `users` table through UserModel.
     */
    public function index()
    {
        $userModel = new UserModel();
        // The password hash is not needed on this page, so it is not even loaded.
        $users     = $userModel->select('id, username, full_name, avatar, created_at')
            ->orderBy('id', 'ASC')
            ->findAll();

        // Work out which image to show for each user (their avatar, or the placeholder).
        foreach ($users as &$user) {
            $user['avatar_url'] = $this->avatarUrl($user['avatar'] ?? null);
        }
        unset($user);

        $data = [
            'title' => 'User Accounts',
            'users' => $users,
        ];

        return view('templates/header', $data)
            . view('users/index', $data)
            . view('templates/footer');
    }

    /**
     * Empty "New User" form ("/users/new")
     */
    public function new()
    {
        return $this->renderForm(
            'New User',
            site_url('users/create'),
            'Save User',
            ['username' => '', 'full_name' => '', 'avatar' => null],
            [],
            false
        );
    }

    /**
     * Handles the New User form (POST "/users/create").
     * UserModel checks that username is required and unique and full name is required.
     */
    public function create()
    {
        $userModel = new UserModel();
        $data      = $this->formData();

        // A new account must start with a password (the Edit form keeps it optional).
        $userModel->setValidationRule('password', 'required|min_length[8]|max_length[72]');

        if (! $userModel->insert($data)) {
            return $this->renderForm(
                'New User',
                site_url('users/create'),
                'Save User',
                array_diff_key($data, ['password' => 1]) + ['avatar' => null],
                $userModel->errors(),
                false
            );
        }

        return redirect()->to('users')
            ->with('success', 'User "' . $data['username'] . '" was added.');
    }

    /**
     * Edit form, pre-filled with the existing record ("/users/edit/{id}")
     */
    public function edit(int $id)
    {
        $user = $this->findOr404($id);

        return $this->renderForm(
            'Edit User',
            site_url('users/update/' . $id),
            'Update User',
            $user,
            [],
            true
        );
    }

    /**
     * Handles the Edit User form (POST "/users/update/{id}"), including the optional avatar upload.
     */
    public function update(int $id)
    {
        $user      = $this->findOr404($id);
        $userModel = new UserModel();
        $data      = $this->formData();
        $errors    = [];

        // 1. Validate the text fields. 'id' is included so is_unique ignores this very record.
        if (! $userModel->validate($data + ['id' => $id])) {
            $errors = $userModel->errors();
        }

        // 2. Validate the avatar, but only when a file was actually chosen.
        $file    = $this->request->getFile('avatar');
        $hasFile = $file !== null && $file->getError() !== UPLOAD_ERR_NO_FILE;

        if ($hasFile) {
            $avatarError = $this->validateAvatar($file);
            if ($avatarError !== null) {
                $errors['avatar'] = $avatarError;
            }
        }

        if ($errors !== []) {
            // Show the form again: typed values on top of the stored record (keeps the current avatar).
            return $this->renderForm(
                'Edit User',
                site_url('users/update/' . $id),
                'Update User',
                array_merge($user, array_diff_key($data, ['password' => 1])),
                $errors,
                true
            );
        }

        // 3. Prepare the thumbnail and remember only its file name.
        $newAvatar = null;
        if ($hasFile) {
            try {
                $newAvatar      = $this->saveAvatar($file, $id);
                $data['avatar'] = $newAvatar;
            } catch (\Throwable $e) {
                log_message('error', 'Avatar processing failed: ' . $e->getMessage());

                return $this->renderForm(
                    'Edit User',
                    site_url('users/update/' . $id),
                    'Update User',
                    array_merge($user, array_diff_key($data, ['password' => 1])),
                    ['avatar' => 'The picture could not be processed. Please try a different JPG or PNG file.'],
                    true
                );
            }
        }

        // 4. Save to the database.
        if (! $userModel->update($id, $data + ['id' => $id])) {
            if ($newAvatar !== null) {
                $this->deleteAvatarFile($newAvatar); // do not leave an orphaned image behind
            }

            return $this->renderForm(
                'Edit User',
                site_url('users/update/' . $id),
                'Update User',
                array_merge($user, array_diff_key($data, ['password' => 1])),
                $userModel->errors(),
                true
            );
        }

        // 5. The old picture is no longer used, so remove it.
        if ($newAvatar !== null && ! empty($user['avatar'])) {
            $this->deleteAvatarFile($user['avatar']);
        }

        return redirect()->to('users')
            ->with('success', 'User "' . $data['username'] . '" was updated.');
    }

    // ------------------------------------------------------------------
    // Avatar helpers
    // ------------------------------------------------------------------

    /**
     * Checks the uploaded file. Returns an error message, or null when the file is acceptable.
     *   - must be a real JPG or PNG image (checked on the file's content, not just its name)
     *   - must be 2 MB or smaller
     */
    private function validateAvatar(UploadedFile $file): ?string
    {
        // PHP rejects files over upload_max_filesize before CodeIgniter's rules can run.
        if (in_array($file->getError(), [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE], true)) {
            return 'The picture must be 2 MB or smaller.';
        }

        if (! $file->isValid()) {
            return 'The picture could not be uploaded. Please try again.';
        }

        $rules = [
            'avatar' => [
                'label'  => 'Profile picture',
                'rules'  => 'uploaded[avatar]'
                    . '|is_image[avatar]'
                    . '|mime_in[avatar,image/jpg,image/jpeg,image/png]'
                    . '|ext_in[avatar,jpg,jpeg,png]'
                    . '|max_size[avatar,2048]'     // 2048 KB = 2 MB
                    . '|max_dims[avatar,4096,4096]', // protects server memory when resizing
                'errors' => [
                    'is_image' => 'The picture must be a real JPG or PNG image, and its file name must end in .jpg, .jpeg or .png.',
                    'mime_in'  => 'The picture must be a real JPG or PNG image, and its file name must end in .jpg, .jpeg or .png.',
                    'ext_in'   => 'The picture must be a real JPG or PNG image, and its file name must end in .jpg, .jpeg or .png.',
                    'max_size' => 'The picture must be 2 MB or smaller.',
                    'max_dims' => 'The picture cannot be larger than 4096 x 4096 pixels.',
                ],
            ],
        ];

        if ($this->validate($rules)) {
            return null;
        }

        return $this->validator->getError('avatar');
    }

    /**
     * Prepares the display-ready image and stores it in public/uploads/avatars/.
     * The upload is turned into a 200 x 200 square thumbnail (centered crop), so every avatar
     * has the same size no matter what the original looked like. Returns the file name only.
     */
    private function saveAvatar(UploadedFile $file, int $userId): string
    {
        $dir = FCPATH . 'uploads/avatars/';
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        // A server-made name: never use the visitor's file name.
        $extension = $file->guessExtension() ?? 'jpg';
        $filename  = 'user_' . $userId . '_' . bin2hex(random_bytes(6)) . '.' . $extension;

        $path  = $dir . $filename;
        $image = \Config\Services::image()->withFile($file->getTempName());

        // Phone photos record "which way is up" in EXIF data instead of rotating the pixels.
        // If the photo needs turning, save an upright copy first and work from that copy,
        // because the resize step has to see the picture's real (rotated) dimensions.
        $orientation = $image->getEXIF('Orientation', true); // false/null when there is no EXIF data
        if ($orientation && (int) $orientation !== 1) {
            $image->reorient(true)->save($path, 90);
            $image = \Config\Services::image()->withFile($path);
        }

        // Crop to a centered square and shrink it to 200 x 200: the display-ready thumbnail.
        $image->fit(self::AVATAR_SIZE, self::AVATAR_SIZE, 'center')
            ->save($path, 90);

        return $filename;
    }

    /** Deletes an avatar file from the uploads folder. basename() blocks path tricks. */
    private function deleteAvatarFile(string $filename): void
    {
        $path = FCPATH . 'uploads/avatars/' . basename($filename);

        if (is_file($path)) {
            @unlink($path);
        }
    }

    /** URL of the user's avatar, or of the placeholder when there is none (or the file is missing). */
    private function avatarUrl(?string $filename): string
    {
        if (! empty($filename) && is_file(FCPATH . 'uploads/avatars/' . basename($filename))) {
            return base_url('uploads/avatars/' . rawurlencode(basename($filename)));
        }

        return base_url('images/avatar-placeholder.svg');
    }

    // ------------------------------------------------------------------
    // Form helpers
    // ------------------------------------------------------------------

    /**
     * Reads and cleans the submitted text fields.
     * The password is taken exactly as typed (never trimmed) and only included when something was
     * typed, so leaving the box empty on the Edit form keeps the current password.
     */
    private function formData(): array
    {
        $data = [
            'username'  => trim((string) $this->request->getPost('username')),
            'full_name' => trim((string) $this->request->getPost('full_name')),
        ];

        $password = (string) $this->request->getPost('password');
        if ($password !== '') {
            $data['password'] = $password;
        }

        return $data;
    }

    /** Returns the user row or shows a 404 page when the id does not exist. */
    private function findOr404(int $id): array
    {
        $user = (new UserModel())->find($id);

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound('User not found.');
        }

        // The password hash is never needed by the forms, so it is not passed along.
        unset($user['password']);

        return $user;
    }

    /** Renders the shared form view (used by both "new" and "edit"). */
    private function renderForm(string $heading, string $action, string $submitLabel, array $user, array $errors, bool $showAvatar)
    {
        $data = [
            'title'       => $heading,
            'heading'     => $heading,
            'action'      => $action,
            'submitLabel' => $submitLabel,
            'user'        => $user,
            'errors'      => $errors,
            'showAvatar'  => $showAvatar,
            'avatarUrl'   => $this->avatarUrl($user['avatar'] ?? null),
        ];

        return view('templates/header', $data)
            . view('users/form', $data)
            . view('templates/footer');
    }
}
