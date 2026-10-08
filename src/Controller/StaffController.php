<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Log\Log;
use Cake\Mailer\Mailer;
use DateTimeImmutable;

/**
 * Staff Controller
 *
 * @property \App\Model\Table\StaffTable $Staff
 * @method \App\Model\Entity\Staff[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StaffController extends AppController
{
    /**
     * Index method for staff page
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $session = $this->request->getSession(); // get the created session
        $userId = $session->read('Auth.id'); // the logged in user id

        if ($userId === null) { // if staff has not signed in, send to login
            return $this->redirect([
                'controller' => 'Login',
                'action' => 'index',
            ]);
        } else {
            // GET User
            $user = $this->Staff->get($userId);

            // GET which org staff belongs to
            $organisation = $this->fetchTable('Organisations')
                ->get($user->organisation_id);
            $orgName = $organisation->get('name');

            //Check org is not deactivated
            if ($organisation->get('is_disabled') === true) {
                return $this->redirect([
                    'controller' => 'Login',
                    'action' => 'index',
                ]);
            }

            // GET Visitors
            $visitorTable = $this->fetchTable('Visitors')
                ->find()
                ->select(['id', 'first_name', 'last_name'])
                ->where([
                    'organisation_id' => $user->organisation_id,
                ])
                ->toArray();

            // GET rules
            $rulesTable = $this->fetchTable('Houserules')
                ->find()
                ->select(['id', 'name'])
                ->where([
                    'organisation_id' => $user->organisation_id,
                ])
                ->toArray();

            $orgId = $this->getUserOrg();
            $count = $this->fetchTable('Visitors')
                ->find()
                ->where([
                    'organisation_id' => $orgId, 'start_time >=' => new \DateTime('00:00:00'),
                ])
                ->count();

            $this->Flash->info('Current Visitor Count Today: ' . $count ?? 'N/A');

            $this->set(compact('user', 'orgName', 'visitorTable', 'rulesTable', 'count'));

            // this should only be sent if a rule is out of date
            $this->ruleDateWarning();
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

            // better handling of filter with help from AI
            $filter = $this->request->getData('filter');
            $this->filter();

            switch ($action) {
                case 'submit-edit-org-btn': // get org details
                    $this->editOrgDetails();
                    break;

                // Filter List My old code that I just wanna keep...
                /*
                case "filter-visitors-by-visiting":
                    $this->filterVisiting();
                    break;

                case "filter-visitors-by-today":
                    $this->filterToday();
                    break;

                case "filter-visitors-by-week":
                    $this->filterWeek();
                    break;

                case "filter-visitors-by-month":
                    $this->filterMonth();
                    break;

                case "filter-visitors-by-6month":
                    $this->filter6Month();
                    break;

                case "filter-visitors-by-year":
                    $this->filterYear();
                    break;

                case "filter-visitors-by-6year":
                    $this->filter6Year();
                    break;*/

                //default:
                    //$this->Flash->error(__('Button not implemented :D'));
            }
        }
    }

    /**
     * Sends user to visitor page
     * Does not destroy the session since visitors don't login themself
     *
     * @return \Cake\Http\Response|null
     */
    public function visitorPage()
    {
        // dont destroy the session because it is still connected to the staff account
        return $this->redirect(['controller' => 'Visitors', 'action' => 'index']);
    }

    /**
     * Check the session to see if there is a staff Impersonater
     *
     * @return \Cake\Http\Response
     */
    public function checkImpersonate()
    {
        $session = $this->request->getSession();
        $Impersonator = $session->check('Impersonator.id');

        return $this->response
        ->withType('application/json')
        ->withStringBody(json_encode(['Impersonator' => $Impersonator]));
    }

    /**
     * Gets the organisation id of who is currently logged into this session
     *
     * @return mixed|null
     */
    public function getUserOrg()
    {
        $session = $this->request->getSession();
        $orgId = $session->read('Auth.organisation_id');

        return $orgId;
    }

    /**
     * Updates the selected organisation with new information in the database
     *
     * @return \Cake\Http\Response|null
     */
    public function editOrgDetails()
    {
        $orgId = $this->getUserOrg();
        $organisationTable = $this->fetchTable('Organisations'); // get table
        $organisation = $organisationTable->get($orgId); // get the existing row
        $newOrgData = $this->getOrgEdited(); // get the edited information

        // update the row
        $organisation = $organisationTable->patchEntity($organisation, $newOrgData);

        // Check for validation errors before saving
        try {
            $organisationTable->saveOrFail($organisation);
            $this->Flash->success(__('The organisation data has been updated.'));

            return $this->redirect(['action' => 'index']);
        } catch (\Exception $e) {
            Log::debug($e->getMessage(), ['exception' => $e]);
            $this->Flash->error(__('Unable to update the organisation. Please fix validation errors.'));
        }
    }

    /**
     * Gets the information from the staff page about which organisation they want to edit
     *
     * @return array{modified: \DateTimeImmutable, name: mixed, organisation_details: mixed}
     */
    public function getOrgEdited()
    {
 // Get the new edited org details
        $orgData = [
            'name' => $this->request->getData('new-name'),
            'organisation_details' => $this->request->getData('new-org-details'),
            'modified' => new DateTimeImmutable(),
        ];

        return $orgData;
    }

    /**
     * Displays all currently visiting
     *
     * @return void
     */
    public function filterVisiting()
    {
        $orgId = $this->getUserOrg();
        $filterVisitorTable = $this->fetchTable('Visitors')
            ->find()
            ->select(['id', 'first_name', 'last_name', 'start_time', 'end_time', 'phone_number', 'email'])
            ->where([
                'organisation_id' => $orgId,
                'end_time IS' => null,
            ])
            ->orderDesc('start_time')
            ->toArray();

        $this->set(compact('filterVisitorTable'));
    }

    /**
     * Filters all visitors by a day
     *
     * @return void
     */
    /*
    public function filterToday() {
        $orgId = $this->getUserOrg();
        $filterVisitorTable = $this->fetchTable('Visitors')
            ->find()
            ->select(['id', 'first_name', 'last_name', 'start_time', 'end_time', 'phone_number', 'email'])
            ->where([
                'organisation_id' => $orgId, 'start_time >=' => new \DateTime('00:00:00')
            ])
            ->orderDesc('start_time')
            ->toArray();

        $this->set(compact('filterVisitorTable'));
    }*/

    /**
     * Filters all visitors by a week
     *
     * @return void
     */
    /*
    public function filterWeek() {
        $orgId = $this->getUserOrg();
        $filterVisitorTable = $this->fetchTable('Visitors')
            ->find()
            ->select(['id', 'first_name', 'last_name', 'start_time', 'end_time', 'phone_number', 'email'])
            ->where([
                'organisation_id' => $orgId, 'start_time >=' => new \DateTime('-1 week')
            ])
            ->orderDesc('start_time')
            ->toArray();

        $this->set(compact('filterVisitorTable'));
    }*/

    /**
     * Filters all visitors by a month
     *
     * @return void
     */
    /*
    public function filterMonth() {
        $orgId = $this->getUserOrg();
        $filterVisitorTable = $this->fetchTable('Visitors')
            ->find()
            ->select(['id', 'first_name', 'last_name', 'start_time', 'end_time', 'phone_number', 'email'])
            ->where([
                'organisation_id' => $orgId, 'start_time >=' => new \DateTime('-1 month')
            ])
            ->orderDesc('start_time')
            ->toArray();

        $this->set(compact('filterVisitorTable'));
    }*/

    /**
     * Filters all visitors by 6 months
     *
     * @return void
     */
    /*
    public function filter6Month() {
        $orgId = $this->getUserOrg();
        $filterVisitorTable = $this->fetchTable('Visitors')
            ->find()
            ->select(['id', 'first_name', 'last_name', 'start_time', 'end_time', 'phone_number', 'email'])
            ->where([
                'organisation_id' => $orgId, 'start_time >=' => new \DateTime('-6 month')
            ])
            ->orderDesc('start_time')
            ->toArray();

        $this->set(compact('filterVisitorTable'));
    }*/

    /**
     * Filters all visitors by a year
     *
     * @return void
     */
    /*
    public function filterYear() {
        $orgId = $this->getUserOrg();
        $filterVisitorTable = $this->fetchTable('Visitors')
            ->find()
            ->select(['id', 'first_name', 'last_name', 'start_time', 'end_time', 'phone_number', 'email'])
            ->where([
                'organisation_id' => $orgId, 'start_time >=' => new \DateTime('-1 year')
            ])
            ->orderDesc('start_time')
            ->toArray();

        $this->set(compact('filterVisitorTable'));
    }*/

    /**
     * Filters all visitors by 6 years
     *
     * @return void
     */
    /*
    public function filter6Year() {
        $orgId = $this->getUserOrg();
        $filterVisitorTable = $this->fetchTable('Visitors')
            ->find()
            ->select(['id', 'first_name', 'last_name', 'start_time', 'end_time', 'phone_number', 'email'])
            ->where([
                'organisation_id' => $orgId, 'start_time >=' => new \DateTime('-6 year')
            ])
            ->orderDesc('start_time')
            ->toArray();

        $this->set(compact('filterVisitorTable'));
    } */

    /**
     * Filter visitors, this is a more cleaner approach than the above.
     *
     * @return void
     */
    public function filter()
    {
        $filter = $this->request->getData('filter', 'today');
        $orgId = $this->getUserOrg();

        $query = $this->fetchTable('Visitors')
            ->find()
            ->select([
                'id',
                'first_name',
                'last_name',
                'start_time',
                'end_time',
                'phone_number',
                'email',
            ])
            ->where([
                'organisation_id' => $orgId,
            ]);

        if ($filter === 'visiting') {
            $query->where([
                'end_time IS' => null,
            ]);
        } else {
            $dateFilters = [
                'today' => (new \DateTime())->setTime(0, 0, 0),
                'week' => new \DateTime('-1 week'),
                'month' => new \DateTime('-1 month'),
                '6month' => new \DateTime('-6 months'),
                'year' => new \DateTime('-1 year'),
                '6year' => new \DateTime('-6 years'),
            ];

            if (!isset($dateFilters[$filter])) {
                throw new \InvalidArgumentException('Invalid filter');
            }

            $query->where([
                'start_time >=' => $dateFilters[$filter],
            ]);
        }

        $filterVisitorTable = $query
            ->orderDesc('start_time')
            ->toArray();

        $this->set(compact('filterVisitorTable'));
    }

    /**
     * Gets every rule that will expiry in under a week.
     *
     * @return array
     */
    public function getExpiryDate()
    {
        $session = $this->request->getSession();
        $userId = $session->read('Auth.id');
        $user = $this->Staff->get($userId);

        $expiredRule = $this->fetchTable('Houserules')
            ->find()
            ->select(['id', 'name'])
            ->where([
                'organisation_id' => $user->organisation_id,
                'expiry_date >=' => new \DateTime(),
                'expiry_date <=' => new \DateTime('+1 week'),
            ])
            ->toArray();

        return $expiredRule;
    }

    /**
     * If a rule is coming close to expiring in under a week, send an email warning to staff in the org
     *
     * @return void
     */
    public function ruleDateWarning()
    {
        $session = $this->request->getSession();
        $expiredRules = $this->getExpiryDate();

        if ($expiredRules != null) { // check if there are any rules close to expiring before sending email
            // Pretend we get the staffs actual email
            //$staffEmail = $session->read('Auth.email');
            $staffName = $session->read('Auth.name');
            $staffEmail = 'secret';

            $mailer = new Mailer('default');

            $mailer->setFrom(['secret' => 'Olivisit'])
                ->setTo($staffEmail)
                ->setReplyTo('support@example.com', 'Help Desk')
                ->setSubject('Rule Expiry Date Ending Soon!')
                ->setEmailFormat('both')
                ->setViewVars([
                    'expiredRules' => $expiredRules,
                    'staffName' => $staffName,
                ])
                ->viewBuilder()
                ->setTemplate('ruleExpiryWarn');

            $mailer->deliver();
        }
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
}
