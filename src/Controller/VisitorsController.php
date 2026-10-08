<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Visitors Controller
 *
 * @property \App\Model\Table\StaffTable $Staff
 * @method \App\Model\Entity\Staff[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class VisitorsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $session = $this->request->getSession(); // get the created session
        $userId = $session->read('Auth.id'); // the logged in user id
        $this->Staff = $this->fetchTable('Staff');

        if ($userId === null) { // if staff has not signed in, send to login
            return $this->redirect([
                'controller' => 'Login',
                'action' => 'index',
            ]);
        } else {
            // GET User
            $user = $this->Staff->get($userId);

            // GET which org staff belongs to
            $orgName = $this->fetchTable('Organisations')
                ->get($user->get('organisation_id'))->get('name');

            $orgDetails = $this->fetchTable('Organisations')
                ->get($user->get('organisation_id'))->get('organisation_details');

            $serverTime = new \DateTime();

            $this->set(compact('user', 'orgName', 'orgDetails', 'serverTime'));
        }

        if ($this->request->is('post')) {
            // double check user is staff
            if ($user === null) {
                return $this->redirect([
                    'controller' => 'Login',
                    'action' => 'index',
                ]);
            }

            //Read what button was clicked
            $action = $this->request->getData('action');

            switch ($action) {
                case 'check-in-btn': // Check In visitor
                    $this->checkIn();
                    break;

                case 'check-out-btn': // check out visitor
                    $this->checkOut();
                    break;

                default:
                    $this->Flash->error(__('Button not implemented :D'));
            }
        }
    }

    /**
     * Takes user to the check in page
     *
     * @return \Cake\Http\Response|null
     */
    public function checkIn()
    {
        // dont destroy the session because it is still connected to the staff account
        return $this->redirect(['controller' => 'CheckIn', 'action' => 'index']);
    }

    /**
     * Takes the user to the check out page
     *
     * @return \Cake\Http\Response|null
     */
    public function checkOut()
    {
        // dont destroy the session because it is still connected to the staff account
        return $this->redirect(['controller' => 'CheckOut', 'action' => 'index']);
    }

    /**
     * Redirects user to the staff page
     *
     * @return \Cake\Http\Response|null
     */
    public function staffPage()
    {
        return $this->redirect(['controller' => 'Staff', 'action' => 'index']);
    }

    /**
     * Displays info message that if visitor is having trouble signing in, they must ask reception for help.
     *
     * @return \Cake\Http\Response|null
     */
    public function needHelp()
    {
        $this->Flash->info('Having trouble checking in? A staff member at reception can help.');

        return $this->redirect($this->request->referer());
    }
}
