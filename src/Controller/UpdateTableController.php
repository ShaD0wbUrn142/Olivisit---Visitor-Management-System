<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Log\Log;
use DateTimeImmutable;

/**
 * Used by Admin and Staff Page
 * Updates, edits and deletes data from the selected table
 */
class UpdateTableController extends AppController
{
    /**
     * Updates the selected organisation in the database
     *
     * @return \Cake\Http\Response|null
     */
    public function updateOrg()
    {
        $organisationTable = $this->fetchTable('Organisations'); // get table
        $org_id = $this->request->getData('organisation-code');

        // Check for validation errors before saving
        try {
            $organisation = $organisationTable->get($org_id); // get the existing row
            $newOrgData = $this->getOrgEdited(); // get the edited information

            // update the row
            $organisation = $organisationTable->patchEntity($organisation, $newOrgData);

            $organisationTable->saveOrFail($organisation);
            $this->Flash->success(__('The organisation data has been updated.'));

            return $this->redirect($this->request->referer());
        } catch (\Exception $e) {
            Log::debug($e->getMessage(), ['exception' => $e]);
            $this->Flash->error(__('Unable to update the organisation. Please fix validation errors.'));
        }

        return $this->redirect($this->request->referer());
    }

    /**
     * Disables the selected organisation in the database
     * Hides organisation from admin page, cannot be selected on any form
     *
     * @return \Cake\Http\Response|null
     */
    public function disableOrg()
    {
        $organisationTable = $this->fetchTable('Organisations'); // get table
        $org_id = $this->request->getData('organisation-code');

        // Check for validation errors before saving
        try {
            $organisation = $organisationTable->get($org_id); // get the existing row

            // update the row
            $organisation = $organisationTable->patchEntity($organisation, ['is_disabled' => true]);

            $organisationTable->saveOrFail($organisation);
            $this->Flash->success(__('The organisation has been disabled.'));

            return $this->redirect($this->request->referer());
        } catch (\Exception $e) {
            Log::debug($e->getMessage(), ['exception' => $e]);
            $this->Flash->error(__('Unable to disable the organisation. Please fix validation errors 
                                                                                or contact admin.'));

            return $this->redirect($this->request->referer());
        }
    }

    /**
     * Enables the selected organisation in the database
     *
     * @return \Cake\Http\Response|null
     */
    public function enableOrg()
    {
        $organisationTable = $this->fetchTable('Organisations'); // get table
        $org_id = $this->request->getData('organisation-code');

        // Check for validation errors before saving
        try {
            $organisation = $organisationTable->get($org_id); // get the existing row

            // update the row
            $organisation = $organisationTable->patchEntity($organisation, ['is_disabled' => false]);

            $organisationTable->saveOrFail($organisation);
            $this->Flash->success(__('The organisation has been enabled.'));

            return $this->redirect($this->request->referer());
        } catch (\Exception $e) {
            Log::debug($e->getMessage(), ['exception' => $e]);
            $this->Flash->error(__('Unable to enable the organisation. Please fix validation errors 
                                                                                or contact admin.'));

            return $this->redirect($this->request->referer());
        }
    }

    /**
     * Deletes organisation from database
     * Does not delete rules, staff or visitors connected
     * Better to use disableOrg
     *
     * @return \Cake\Http\Response|null
     */
    public function deleteOrg()
    {
        $organisationTable = $this->fetchTable('Organisations');
        $org_id = $this->request->getData('organisation-code');

        try {
            $organisation = $organisationTable->get($org_id);
            $organisationTable->deleteOrFail($organisation);
            $this->Flash->success(__('The organisation has been deleted.'));

            return $this->redirect($this->request->referer());
        } catch (\Exception $e) {
            $this->Flash->error(__('Unable to delete the organisation. Please fix validation errors 
                                                                                or contact admin.'));
            Log::debug($e->getMessage(), ['exception' => $e]);

            return $this->redirect($this->request->referer());
        }
    }

    /**
     * Gets the information user submitted about the organisation they want to edit
     *
     * @return array{code: string, modified: \DateTimeImmutable, name: mixed, organisation_details: mixed}
     */
    public function getOrgEdited()
    {
        $date = new DateTimeImmutable();
        $date->format('Y-m-d H:i:s.u');

        return [
            //'id'=> $this->request->getData('organisation-code'),
            'name' => $this->request->getData('new-name'),
            'code' => $this->request->getData('new-name') . '_' . $this->request->getData('new-location-code'),
            'organisation_details' => $this->request->getData('new-org-details'),
            'modified' => $date,
        ];
    }

    /**
     * Updates the selected rule the user wants to change in the database
     *
     * @return \Cake\Http\Response|null
     */
    public function updateRule()
    {
        $ruleTable = $this->fetchTable('Houserules'); // get table
        $rule_id = $this->request->getData('newrule-id');

        // Check for validation errors before saving
        try {
            $rule = $ruleTable->get($rule_id); // get the existing row
            $newRuleData = $this->getRuleEdited(); // get the edited information

            // update the row
            $rule = $ruleTable->patchEntity($rule, $newRuleData);

            $ruleTable->saveOrFail($rule);
            $this->Flash->success(__('The rule data has been updated.'));

            return $this->redirect($this->request->referer());
        } catch (\Exception $e) {
            $this->Flash->error(__('Unable to update the rule. Please fix validation errors.'));
            Log::debug($e->getMessage(), ['exception' => $e]);

            return $this->redirect($this->request->referer());
        }
    }

    /**
     * Deletes the selected rule from database
     *
     * @return \Cake\Http\Response|null
     */
    public function deleteRule()
    {
        $ruleTable = $this->fetchTable('Houserules');
        $rule_id = $this->request->getData('newrule-id');

        try {
            $rules = $ruleTable->get($rule_id);
            $ruleTable->deleteOrFail($rules);
            $this->Flash->success(__('The rule has been deleted.'));

            return $this->redirect($this->request->referer());
        } catch (\Cake\ORM\Exception\PersistenceFailedException $e) {
            $this->Flash->error(__('Unable to delete the rule. Please fix validation errors 
                                                                        or contact admin.'));
            Log::debug($e->getMessage(), ['exception' => $e]);

            return $this->redirect($this->request->referer());
        }
    }

    /**
     * Gets the information user submitted about the rule they want to edit
     *
     * @return array{expiry_date: mixed, modified: \DateTimeImmutable, name: mixed, rule_description: mixed}
     */
    public function getRuleEdited()
    {
        $ruleData = [
            'name' => $this->request->getData('newrule-name'),
            'rule_description' => $this->request->getData('editorg-rules'),
            'expiry_date' => $this->request->getData('editexpiry-date'),
            'modified' => new DateTimeImmutable(),
        ];

        // Admin page includes this field, Staff page doesn't
        if ($this->request->getData('edit-rule-code') !== null) {
            $ruleData['organisation_id'] = $this->request->getData('edit-rule-code');
        }

        return $ruleData;
    }

    // Edit and update entities in the STAFF table

    /**
     * Updates the selected staff the user wants to change in the database with new information
     *
     * @return \Cake\Http\Response|null
     */
    public function updateStaff()
    {
        $staffTable = $this->fetchTable('Staff'); // get table
        $staff_id = $this->request->getData('staff-id');
        $staff = null;

        // Check for validation errors before saving
        try {
            $staff = $staffTable->get($staff_id); // get the existing row
            $newStaffData = $this->getStaffEdited(); // get the edited information

            // update the row
            $staff = $staffTable->patchEntity($staff, $newStaffData);

            $staffTable->saveOrFail($staff);
            $this->Flash->success(__('The staff data has been updated.'));

            return $this->redirect($this->request->referer());
        } catch (\Exception $e) {
            Log::debug($e->getMessage(), ['exception' => $e]);
            if ($staff !== null && (empty($staff->getError('email')) || empty($staff->getError('phone_number')))) {
                $this->Flash->error(__('Email and phone number cannot be empty. Please provide a 
                                                                unique email and phone number'));

                return $this->redirect($this->request->referer());
            } elseif ($staff !== null && ($staff->getError('email') || $staff->getError('phone_number'))) {
                // if a staff already exists with that email or phone number
                $this->Flash->error(__('A staff with that email or phone number already exists. 
                                                                Unable to update the staff.'));

                return $this->redirect($this->request->referer());
            } else {
                $this->Flash->error(__('Unable to update the staff. Please fix validation errors.'));

                return $this->redirect($this->request->referer());
            }
        }
    }

    /**
     * Deletes the selected staff from database
     *
     * @return \Cake\Http\Response|null
     */
    public function deleteStaff()
    {
        $staffTable = $this->fetchTable('Staff');
        $staff_id = $this->request->getData('staff-id');

        try {
            $staff = $staffTable->get($staff_id);
            $staffTable->deleteOrFail($staff);
            $this->Flash->success(__('The staff account has been deleted.'));

            return $this->redirect($this->request->referer());
        } catch (\Cake\ORM\Exception\PersistenceFailedException $e) {
            $this->Flash->error(__('Unable to delete the staff. Please fix validation errors 
                                                                        or contact admin.'));
            Log::debug($e->getMessage(), ['exception' => $e]);

            return $this->redirect($this->request->referer());
        }
    }

    /**
     * Gets the information user submitted about the staff they want to edit
     * Checks if the password is being updated or staying the same
     *
     * @return array<bool|string>|array{email: mixed, "first_name": mixed, "last_name": mixed, modified: \DateTimeImmutable, "organisation_id": mixed, "phone_number": mixed, "role_id": mixed}
     */
    public function getStaffEdited()
    {
        $data = [
            'organisation_id' => $this->request->getData('new-organisation'),
            'role_id' => $this->request->getData('new-role'),
            'first_name' => $this->request->getData('new-firstName'),
            'last_name' => $this->request->getData('new-lastName'),
            'phone_number' => $this->request->getData('new-phone'),
            'email' => $this->request->getData('new-email'),
            'modified' => new DateTimeImmutable(),
        ];
        $password = $this->request->getData('new-password');

        // need to check if password is staying the same or is also being updated
        if (!empty($password)) {
            $hasher = new DefaultPasswordHasher();
            $data['password'] = $hasher->hash($password);
        }

        return $data;
    }

    // Edit and update entities in the VISITORS table

    /**
     * Updates the selected visitor the user wants to change in the database with new information
     *
     * @return \Cake\Http\Response|null
     */
    public function editVisitorDetails()
    {
        $visitorsTable = $this->fetchTable('Visitors'); // get table
        $visitor_id = $this->request->getData('visitor-id');

        // Check for validation errors before saving
        try {
            $visitor = $visitorsTable->get($visitor_id); // get the existing row
            $newVisitorData = $this->getVisitorEdited(); // get the edited information

            // update the row
            $visitorRow = $visitorsTable->patchEntity($visitor, $newVisitorData);

            $visitorsTable->saveOrFail($visitorRow);
            $this->Flash->success(__('The visitor data has been updated.'));

            return $this->redirect($this->request->referer());
        } catch (\Exception $e) {
            Log::debug($e->getMessage(), ['exception' => $e]);
            $this->Flash->error(__('Unable to update the visitor. Please fix validation errors.'));

            return $this->redirect($this->request->referer());
        }
    }

    /**
     * Gets the information user submitted about the visitor they want to edit
     *
     * @return array{email: mixed, "end_time": mixed, "first_name": mixed, "last_name": mixed, modified: \DateTimeImmutable, "phone_number": mixed, "start_time": mixed}
     */
    public function getVisitorEdited()
    {
        $visitorData = [
            //'id'=> $this->request->getData('visitor-id'),
            'first_name' => $this->request->getData('first-name'),
            'last_name' => $this->request->getData('last-name'),
            'email' => $this->request->getData('new-email'),
            'phone_number' => $this->request->getData('new-phone'),
            'start_time' => $this->request->getData('start-time'),
            'end_time' => $this->request->getData('end-time'),
            'modified' => new DateTimeImmutable(),
        ];

        return $visitorData;
    }
}
