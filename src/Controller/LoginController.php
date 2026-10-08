<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Auth\DefaultPasswordHasher;

/**
 * Login Controller
 */
class LoginController extends AppController
{
    /**
     * Gets email and password and checks if they are valid
     * Then sends them to the correct page
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $session = $this->request->getSession();
        $userId = $session->read('Auth.id');
        if ($userId != null) {
            $role = $session->read('Auth.role');

            if ($role === 'admin') {
                return $this->redirect([
                    'controller' => 'Admin',
                    'action' => 'index',
                ]);
            } else {
                return $this->redirect([
                    'controller' => 'Staff',
                    'action' => 'index',
                ]);
            }
        }

        if ($this->request->is('post')) {
            $email = $this->request->getData('email');
            $password = $this->request->getData('password');

            $admin = $this->fetchTable('Admin')
                ->find()
                ->where([
                    'email' => $email,
                ])
                ->first();

            $staff = $this->fetchTable('Staff')
                ->find()
                ->where([
                    'email' => $email,
                ])
                ->first();

            // If they are admin:
            if ($admin) {
                if ($password == $admin->password) {
                    $session = $this->request->getSession(); // create session

                    $session->write('Auth.id', $admin->id); // add logged in admin id and email to session
                    $session->write('Auth.name', $admin->first_name . ' ' . $admin->last_name);
                    $session->write('Auth.email', $admin->email);
                    $session->write('Auth.role', 'admin'); // their role is admin

                    // then take them to admin page
                    return $this->redirect([
                        'controller' => 'Admin',
                        'action' => 'index',
                    ]);
                } else {
                    $this->Flash->error('Invalid email or password.');
                }
            } elseif ($staff) { // If they are staff:
                $hasher = new DefaultPasswordHasher();
                if ($hasher->check($password, $staff->password)) {
                    $session = $this->request->getSession(); // create session

                    $session->write('Auth.id', $staff->id);
                    $session->write('Auth.name', $staff->first_name . ' ' . $staff->last_name);
                    $session->write('Auth.email', $staff->email);
                    $session->write('Auth.role', $staff->role_id);
                    $session->write('Auth.organisation_id', $staff->organisation_id);

                    return $this->redirect([
                        'controller' => 'Staff',
                        'action' => 'index',
                    ]);
                } else {
                    $this->Flash->error('Invalid email or password.');
                }
            }

            if (!$staff && !$admin) {
                $this->Flash->error('Invalid email or password.');
            }
        }
    }

    /**
     * Displays an info message explaining that they must have admin reset their password.
     *
     * @return \Cake\Http\Response|null
     */
    public function forgotPassword()
    {
        $this->Flash->info('Please contact your I.T department or admin for a password reset.');

        return $this->redirect($this->request->referer());
    }
}
