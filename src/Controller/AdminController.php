<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Cache\Cache;
use Cake\Http\Exception\NotFoundException;
use Cake\Log\Log;

/**
 * Admin Controller
 *
 * @property \App\Model\Table\AdminTable $Admin
 * @method \App\Model\Entity\Admin[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AdminController extends AppController
{
    /**
     * Index method for admin page
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $session = $this->request->getSession(); // get the created session
        $userId = $session->read('Auth.id'); // the logged in user id

        if ($userId === null) { // if admin has not signed in, send to login
            return $this->redirect([
                'controller' => 'Login',
                'action' => 'index',
            ]);
        } else {
            $user = $this->Admin->get($userId);
            $this->set(compact('user'));
        }

        if ($this->request->is('post')) {
            // double check user is admin
            if ($user === null) {
                return $this->redirect([
                    'controller' => 'Login',
                    'action' => 'index',
                ]);
            }

            //Read what button was clicked
            $action = $this->request->getData('action');

            switch ($action) {
                case 'submit-new-org-btn': // create org
                    $this->createOrg();
                    break;
                case 'submit-new-rule-btn': //create rule
                    $this->createRule();
                    break;
                case 'submit-create-staff-btn': //create staff
                    $this->createStaff();
                    break;
                case 'view-organisations-btn': // view org rules, staff, visitors
                    $this->viewOrgs();
                    break;
                case 'Impersonate':
                    $this->impersonateUser();
                    break;
                default:
                    $this->Flash->error(__('Button functionality not implemented'));
            }
        }

        $this->formSelectionFill();
    }

    /**
     * Gets the organisation information from the admin page creation form
     *
     * @return array{code: string, name: mixed, organisation_details: mixed}
     */
    public function getOrg()
    {
        return [
            'name' => $this->request->getData('name'),
            'code' => $this->request->getData('name') . '_' . $this->request->getData('location-code'),
            'organisation_details' => $this->request->getData('org-details'),
        ];
    }

    /**
     * Creates a new organisation and inserts it into the database
     *
     * @return void
     */
    public function createOrg()
    {
        $organisationTable = $this->fetchTable('Organisations');
        $orgData = $this->getOrg();
        $newOrg = $organisationTable->newEntity($orgData);

        // persist entity to save the row into the database
        try {
            $organisationTable->saveOrFail($newOrg);
            // Success: The row was created
            $newRowId = $newOrg->id;
            $this->Flash->success(__('The organisation has been created.'));
        } catch (\Exception $e) {
            // Error: Validation or database constraints failed
            Log::debug($e->getMessage(), ['exception' => $e]);
            $this->Flash->error(__('Unable to create the organisation. Please fix validation errors.'));
        }
    }

    /**
     * Gets the rule information from the admin page creation form
     *
     * @return array{expiry_date: mixed, name: mixed, organisation_id: mixed, rule_description: mixed}
     */
    public function getRule()
    {
        return [
            'name' => $this->request->getData('rule-name'),
            'rule_description' => $this->request->getData('org-rules'),
            'organisation_id' => $this->request->getData('organisation_id'),
            'expiry_date' => $this->request->getData('expiry-date'),
        ];
    }

    /**
     * Creates a new rule and inserts it into the database
     *
     * @return void
     */
    public function createRule()
    {
        $ruleTable = $this->fetchTable('Houserules');
        $ruleData = $this->getRule();
        $newRule = $ruleTable->newEntity($ruleData);

        // persist entity to save the row into the database
        try {
            $ruleTable->saveOrFail($newRule);
            // Success: The row was created
            $newRowId = $newRule->id;
            $this->Flash->success(__('The rule has been created.'));
        } catch (\Exception $e) {
            // Error: Validation or database constraints failed
            Log::debug($e->getMessage(), ['exception' => $e]);
            $this->Flash->error(__('Unable to create the rule. Please fix validation errors.'));
        }
    }

    /**
     * Gets the staff information from the admin page creation form
     *
     * @return array{email: mixed, first_name: mixed, last_name: mixed, organisation_id: mixed, password: bool|string, phone_number: mixed, role_id: mixed}
     */
    public function getStaff()
    {
        $password = $this->request->getData('password');
        $hasher = new DefaultPasswordHasher();
        $hashedPassword = $hasher->hash($password);
        // if ($hasher->check($submittedPassword, $storedHashValue)) // Returns true or false
        return [
            'organisation_id' => $this->request->getData('organisation'),
            'role_id' => $this->request->getData('role'),
            'first_name' => $this->request->getData('firstname'),
            'last_name' => $this->request->getData('lastname'),
            'phone_number' => $this->request->getData('phone'),
            'email' => $this->request->getData('email'),
            'password' => $hashedPassword,
        ];
    }

    /**
     * Creates a new staff member and inserts it into the database
     *
     * @return void
     */
    public function createStaff()
    {
        $staffTable = $this->fetchTable('Staff');
        $staffData = $this->getStaff();
        $newStaff = $staffTable->newEntity($staffData);

        try {
            $staffTable->saveOrFail($newStaff);
            $newRowId = $newStaff->id;
            $this->Flash->success(__('The staff has been created.'));
        } catch (\Exception $e) {
            // Error: Validation or database constraints failed
            Log::debug($e->getMessage(), ['exception' => $e]);

            if (empty($newStaff->getError('email')) || empty($newStaff->getError('phone_number'))) {
                $this->Flash->error(__('Email and phone number cannot be empty. 
                                Please provide a unique email and phone number'));
            } elseif ($newStaff->getError('email') || $newStaff->getError('phone_number')) {
                // if a staff already exists with that email or phone number
                $this->Flash->error(__('A staff with that email or phone number already exists. 
                                                                Unable to create a new staff'));
            } else {
                $this->Flash->error(__('Unable to create the staff. Please fix validation errors.'));
            }
        }
    }

    /**
     * This function allows the admin to impersonate a user of the VMS, pretending to be them.
     * https://book.cakephp.org/authentication/4/impersonation.html#enabling-impersonation
     *
     * @param string|null $type The user type to impersonate (e.g. 'staff').
     * @throws \Cake\Http\Exception\NotFoundException
     * @return \Cake\Http\Response|null
     */
    public function impersonateUser($type = null)
    {
        // You should always check that the current user is allowed
        // to impersonate other users first.
        $session = $this->getRequest()->getSession();
        $isAdmin = $session->read('Auth.role');
        if ($isAdmin !== 'admin') {
            throw new NotFoundException();
        }

        // check if we are impersonating a staff
        if ($type == 'staff') {
            // Fetch the user we want to impersonate.
            $targetUser = $this->fetchTable('Staff')
                ->findById($this->request->getData('id'))
                ->firstOrFail();
        }

        // Enable impersonation.
        // $this->Authentication->impersonate($targetUser); I'm using session Auth so I can't use this one
        if (!$session->check('Impersonator')) { // store who is impersonating them
            $session->write('Impersonator', [
                'id' => $session->read('Auth.id'),
                'name' => $session->read('Auth.name'),
                'email' => $session->read('Auth.email'),
                'role' => $session->read('Auth.role'),
            ]);
        }

        // write to session
        $session->write('Auth.organisation_id', $targetUser->organisation_id);

        if ($type == 'staff') {
            $session->write('Auth.id', $targetUser->id); // write staff specific variables to session
            $session->write('Auth.email', $targetUser->email);
            $session->write('Auth.role', $targetUser->role_id);
            $session->write('Auth.name', $targetUser->first_name . ' ' . $targetUser->last_name);

            return $this->redirect(['controller' => 'Staff', 'action' => 'index']); // send admin to staff page
        }
    }

    /**
     * When admin is finishes their impersonation, session will be reverted back to admin and some session variables will be deleted.
     *
     * @throws \Cake\Http\Exception\NotFoundException
     * @return \Cake\Http\Response|null
     */
    public function revertIdentity()
    {
        $session = $this->request->getSession();
        // Make sure we are still impersonating a user.
        if (!$session->check('Impersonator')) {
            throw new NotFoundException();
        }

        // delete some session variables and revert back
        $session->write('Auth', [
            'id' => $session->read('Impersonator.id'),
            'name' => $session->read('Impersonator.name'),
            'email' => $session->read('Impersonator.email'),
            'role' => $session->read('Impersonator.role'),
        ]);
        $session->delete('Visitor');
        $session->delete('Impersonator');

        return $this->redirect(['controller' => 'admin', 'action' => 'index']); // take admin back to their page
    }

    /**
     * Gets all houserules, staff and visitors from an organisation and displays them on the page
     *
     * @return void
     */
    public function viewOrgs()
    {
        $org_id = $this->request->getData('display-organisation');

        // find rules
        $rulesTable = $this->fetchTable('Houserules')
            ->find()
            ->select(['id', 'rule_description'])
            ->where([
                'organisation_id' => $org_id,
            ])
            ->all();

        //find staff
        $staffTable = $this->fetchTable('Staff')
            ->find()
            ->select(['id', 'first_name', 'last_name'])
            ->where([
                'organisation_id' => $org_id,
            ])
            ->all();

        // find visitors
        $visitorTable = $this->fetchTable('Visitors')
            ->find()
            ->select(['id', 'first_name', 'last_name'])
            ->where([
                'organisation_id' => $org_id, 'created >=' => new \DateTime('-30 days'),
            ])
            ->orderAsc('last_name')
            ->toArray();

        $this->set(compact('rulesTable', 'staffTable', 'visitorTable'));

        //find staff count
        $staffCount = $this->fetchTable('Staff')
            ->find()
            ->select(['id', 'first_name', 'last_name'])
            ->where([
                'organisation_id' => $org_id,
            ])
            ->count();

        // find visitors count
        $visitorCount = $this->fetchTable('Visitors')
            ->find()
            ->select(['id', 'first_name', 'last_name'])
            ->where([
                'organisation_id' => $org_id, 'created >=' => new \DateTime('-30 days'),
            ])
            ->count();

        $this->set(compact('staffCount', 'visitorCount'));
    }

    /**
     * Returns the cached country codes configuration
     *
     * @return string[]
     */
    public function getCachedConfig()
    {
        $countryCodes = Cache::read('country_codes');

        if ($countryCodes === null || $countryCodes === false) {
            $countryCodes = require CONFIG . 'countryCodes.php';

            Cache::write('country_codes', $countryCodes);
        }

        return $countryCodes;
    }

    /**
     * Sets the theme of the page to either dark or light depending on the users saved choice.
     *
     * @return \Cake\Http\Response
     */
    public function setTheme()
    {
        // Only accept POST requests
        $this->request->allowMethod(['post']);

        // Read JSON payload from the request body
        $rawBody = (string)$this->request->getBody();
        $jsonData = json_decode($rawBody, true);
        $theme = $jsonData['theme'] ?? 'light';

        // Write the value to the user's session
        $session = $this->request->getSession();
        $session->write('Config.theme', $theme);

        // Send a successful JSON response back to JavaScript
        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode(['success' => true, 'theme' => $theme]));
    }

    /**
     * Gets all country codes, organisations, staff, roles and house rules for them to be filled in the selectors on admin page
     *
     * @return void
     */
    public function formSelectionFill()
    {
        // Atuo fill form selections:

        // get country codes that were cached
        $this->set('countries', $this->getCachedConfig());

        // Organisation
        $organisationsTable = $this->fetchTable('Organisations');
        $organisations = $organisationsTable
            ->find('list', [
                'keyField' => 'id',
                'valueField' => 'code',
            ])
            ->where(['is_disabled' => false])
            ->toArray();

        // staff
        $staffTable = $this->fetchTable('Staff');
        $staff = $staffTable
            ->find()
            ->select(['id', 'first_name', 'last_name'])
            ->toArray();

        // role
        $roleTable = $this->fetchTable('Roles');
        $roles = $roleTable->find('list', [
                'keyField' => 'id',
                'valueField' => 'name',
            ])
            ->toArray();

        //rules
        $ruleTable = $this->fetchTable('Houserules');
        $rules = $ruleTable->find('list', [
                'keyField' => 'id',
                'valueField' => 'name',
            ])
            ->toArray();

        $this->set(compact('organisations', 'staff', 'roles', 'rules'));
    }
}
