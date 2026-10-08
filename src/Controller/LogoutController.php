<?php
declare(strict_types=1);

namespace App\Controller;

class LogoutController extends AppController
{
    /**
     * When called, destroys the current session and sends them back to login page
     *
     * @return \Cake\Http\Response|null
     */
    public function logout()
    {
        $this->request->getSession()->destroy();

        return $this->redirect(['controller' => 'Login', 'action' => 'index']);
    }
}
