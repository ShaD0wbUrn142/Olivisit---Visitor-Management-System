<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Auto fills the forms in the Admin and staff page,
 * when an id is selected and that id already exists in the database
 */
class AutoFillController extends AppController
{
    //AUTO FILL FUNCTIONS FOR AUTO FILLING FORMS LIKE ORG, RULES, VISITORS AND STAFF in ADMIN AND STAFF PAGE

    /**
     * With the supplied organisation id, auto fills the form with the existing information
     *
     * @param mixed $id The organisation ID
     * @return \Cake\Http\Response
     */
    public function getOrgFill($id = null)
    {
                      ////// ORG FILL
        $this->autoRender = false;

        $session = $this->request->getSession();
        $role = $session->read('Auth.role');

        $org = $this->fetchTable('Organisations')->get($id);

        if ($role !== 'admin') { // staff requesting org details
            $response = json_encode([
                'name' => $org->get('name'),
                'organisation_details' => $org->get('organisation_details'),
                'is_disabled' => $org->get('is_disabled'),
            ]);
        } else { // admin
            $response = json_encode([
                'id' => $org->id,
                'name' => $org->get('name'),
                'code' => $org->get('code'),
                'organisation_details' => $org->get('organisation_details'),
                'is_disabled' => $org->get('is_disabled'),
            ]);
        }

        return $this->response
            ->withType('application/json')
            ->withStringBody($response);
    }

    /**
     * With the supplied rule id, auto fills the form with the existing information
     *
     * @param mixed $id The house rule ID
     * @return \Cake\Http\Response
     */
    public function getRuleFill($id = null)
    {
                      ////// Rule FILL
        $this->autoRender = false;

        $session = $this->request->getSession();
        $role = $session->read('Auth.role');
        $organisationId = $session->read('Auth.organisation_id');

        $conditions = ['id' => $id];

        if ($role !== 'admin') { // If admin, they can have access to anything, if not, should only have access to organisation they belong to
            $conditions['organisation_id'] = $organisationId;
        }
        $rule = $this->fetchTable('Houserules')
            ->find()
            ->where($conditions)
            ->first();

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode([
                'id' => $rule->id,
                'name' => $rule->get('name'),
                'organisation_id' => $rule->get('organisation_id'),
                'rule_description' => $rule->get('rule_description'),
                'expiry_date' => $rule->get('expiry_date'),
            ]));
    }

    /**
     * With the supplied staff id, auto fills the form with the existing information
     *
     * @param mixed $id The staff ID
     * @return \Cake\Http\Response
     */
    public function getStaffFill($id = null)
    {
                      ////// Staff FILL
        $this->autoRender = false;

        $session = $this->request->getSession();
        $role = $session->read('Auth.role');
        $organisationId = $session->read('Auth.organisation_id');

        $conditions = ['id' => $id];

        if ($role !== 'admin') {
            $conditions['organisation_id'] = $organisationId;
        }
        $staff = $this->fetchTable('Staff')
            ->find()
            ->where($conditions)
            ->first();

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode([
                'id' => $staff->id,
                'first_name' => $staff->get('first_name'),
                'last_name' => $staff->get('last_name'),
                'email' => $staff->get('email'),
                'phone_number' => $staff->get('phone_number'),
                'organisation_id' => $staff->get('organisation_id'),
                'role_id' => $staff->get('role_id'),
            ]));
    }

    /**
     * With the supplied visitor id, auto fills the form with the existing information
     *
     * @param mixed $id The visitor ID
     * @param mixed $checkOut If the visitor has already checked out or not
     * @return \Cake\Http\Response
     */
    public function getVisitor($id = null, $checkOut = null)
    {
                      ////// Visitor FILL
        $this->autoRender = false;

        $session = $this->request->getSession();
        $role = $session->read('Auth.role');
        $organisationId = $session->read('Auth.organisation_id');

        $conditions = ['id' => $id];

        if ($role !== 'admin') {
            $conditions['organisation_id'] = $organisationId;
            if ($checkOut === 'true') {
                $conditions['end_time IS'] = null;
            }
        }

        $visitor = $this->fetchTable('Visitors')
            ->find()
            ->where($conditions)
            ->first();

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode([
                'id' => $visitor->get('id'),
                'first_name' => $visitor->get('first_name'),
                'last_name' => $visitor->get('last_name'),
                'email' => $visitor->get('email'),
                'phone_number' => $visitor->get('phone_number'),
                'start_time' => $visitor->get('start_time'),
                'end_time' => $visitor->get('end_time'),
            ]));
    }
}
