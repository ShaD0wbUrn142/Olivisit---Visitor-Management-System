<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Log\Log;
use DateTimeImmutable;

/**
 * Functionality for checking out the visitor and updating the table row
 */
class CheckOutController extends AppController
{
    /**
     * Index page for Visitor Check Out
     *
     * @return \Cake\Http\Response|null
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

            $this->set(compact('user', 'orgName'));
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
                case 'cancel-sign-in': // return to welcome page
                    $this->back();
                    break;

                case 'submit-sign-in': // creates visitor in database
                    $this->editVisitor();
                    break;

                default:
                    $this->Flash->error(__('Button not implemented :D'));
            }
        }
    }

    /**
     * Returns user back to Visitor page
     *
     * @return \Cake\Http\Response|null
     */
    public function back()
    {
        return $this->redirect(['controller' => 'Visitors', 'action' => 'index']);
    }

    /**
     * Gets the updated information about the visitor checking out (end time)
     *
     * @return array{email: mixed, end_time: mixed, first_name: mixed, last_name: mixed, modified: \DateTimeImmutable, organisation_id: mixed, phone_number: mixed, start_time: mixed}
     */
    public function getVisitorDetails()
    {
        $session = $this->request->getSession();
        $userId = $session->read('Auth.id');
        $user = $this->Staff->get($userId);

        $date = new DateTimeImmutable();
        $date->format('Y-m-d H:i:s.u');

        $visitorData = [
            'organisation_id' => $user->get('organisation_id'),
            'first_name' => $this->request->getData('first-name'),
            'last_name' => $this->request->getData('last-name'),
            'email' => $this->request->getData('email'),
            'phone_number' => $this->request->getData('phone'),
            'start_time' => $this->request->getData('start-time'),
            'end_time' => $this->request->getData('end-time'),
            'modified' => $date,
        ];

        return $visitorData;
    }

    /**
     * Updates the visitor with the end time in the database
     *
     * @return \Cake\Http\Response|null
     */
    public function editVisitor()
    {
        $visitorsTable = $this->fetchTable('Visitors'); // get table
        $visitor_id = $this->request->getData('visitor-id');

        // check if visitor belongs to correct org
        $session = $this->request->getSession();
        $orgId = $session->read('Auth.organisation_id'); // organisation we are currently in

        // look up visitor id in database t see if it matches org id
        $visitorOrg = $this->fetchTable('Visitors')
            ->find()
            ->where(['id' => $visitor_id])
            ->first();

        //check if visitor id being entered has the same organisation_id as $orgId
        if (!$visitorOrg || $visitorOrg->organisation_id != $orgId) {
            $this->Flash->error(__('Unable to checkout the visitor. Wrong Id.'));

            return $this->redirect(['controller' => 'CheckOut', 'action' => 'index']);
        }

        // Check for validation errors before saving
        try {
            $visitor = $visitorsTable->get($visitor_id); // get the existing row
            $newVisitorData = $this->getVisitorDetails(); // get the edited information

            // update the row
            $visitorRow = $visitorsTable->patchEntity($visitor, $newVisitorData);
            $visitorsTable->saveOrFail($visitorRow);

            $this->Flash->success(__('The visitor has been checkout.'));

            return $this->redirect(['controller' => 'Visitors', 'action' => 'index']);
        } catch (\Exception $e) {
            //debug($visitor->getErrors());
            Log::debug($e->getMessage(), ['exception' => $e]);
            $this->Flash->error(__('Unable to checkout the visitor. Please fix validation errors 
                                                                        or contact reception.'));
        }
    }
}
