<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Log\Log;
use Cake\Mailer\Mailer;
use DateTimeImmutable;

/**
 * Controller to check in a new visitor with their details
 */
class CheckInController extends AppController
{
    /**
     * Get the current session and User Id and org. Reads which buttons are clicked
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
                    $this->createVisitor();
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
     * Gets the visitor details the user filled in from the form
     *
     * @return array{created: \DateTimeImmutable, email: mixed, first_name: mixed, last_name: mixed, modified: \DateTimeImmutable, organisation_id: mixed, phone_number: mixed, start_time: mixed}
     */
    public function getVisitor()
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
            'created' => $date,
        ];

        return $visitorData;
    }

    /**
     * Using getVisitor(), creates a new visitor into the database
     *
     * @return \Cake\Http\Response|null
     */
    public function createVisitor()
    {
        $visitorTable = $this->fetchTable('Visitors');
        $visitorData = $this->getVisitor();
        $newVisitor = $visitorTable->newEntity($visitorData);

        // persist entity to save the row into the database
        try {
            $visitorTable->saveOrFail($newVisitor);
            // Success: The row was created
            $newRowId = $newVisitor->id;

            $session = $this->request->getSession();
            $session->write('Visitor.id', $newVisitor->get('id'));
            $session->write('Visitor.name', $newVisitor->get('first_name') . ' ' . $newVisitor->get('last_name'));

            $this->emailVisitor(); // email the visitor after they checked in

            $this->idBadge(); // create their badge

            return $this->redirect(['controller' => 'CheckIn', 'action' => 'houserules']);
        } catch (\Exception $e) {
            Log::debug($e->getMessage(), ['exception' => $e]);

            $this->Flash->error(__('Unable to check-in visitor. Please contact reception or admin.'));
        }
    }

    /**
     * Using the visitor details and photo, it creates an id badge with the email template and emails it to staff member.
     *
     * @return null
     */
    public function idBadge()
    {
        $this->request->allowMethod(['post']);

        // Get details like staff and orgnaisation
        $session = $this->request->getSession();
        $userId = $session->read('Auth.id');
        $user = $this->Staff->get($userId);

        $organisation = $this->fetchTable('Organisations')
            ->get($user->get('organisation_id'));
        $orgName = $organisation->get('name');

        // get details from visitor and convert times
        $visitorData = $this->getVisitor(); // get to information we want on the id badge
        $photo = $this->request->getData('photo'); // add the photo to it
        $email = $this->request->getData('email');

        if ($this->request->getData('photo') == null) {
            return null; // visitor system does not support camera, so id badge is useless
        }

        $startTime = $visitorData['start_time'] ?? 'Error';
        $formattedStartTime = date('d M Y \a\t g:i A', strtotime($startTime));

        $visitorId = $session->read('Visitor.id'); // session visitor name and id
        $visitorName = $session->read('Visitor.name');

        // barcode
        $barcodeValue = '*' . $visitorId . '-V' . '*'; // v for visitorrrr
        $barcodeImage = $this->generateBarcode($barcodeValue);

        $staffEmail = 'secret'; // fake email for testing

        // send badge to staff
        $mailer = new Mailer('default');

        $mailer->setFrom(['secret' => 'Olivisit'])
            ->setTo($staffEmail)
            ->setReplyTo('no-reply@example.com', 'No Reply Team')
            ->setSubject('Badge for: ' . $visitorName)
            ->setEmailFormat('html') // sends HTML + text
            ->setViewVars([
                'orgName' => $orgName,
                'visitorName' => $visitorName,
                'formattedStartTime' => $formattedStartTime,
                'visitorId' => $visitorId,
                'barcodeImage' => $barcodeImage,
                'photo' => $photo,
                'email' => $email,
            ])
            ->viewBuilder()
            ->setTemplate('badge');

        $mailer->deliver();
    }

    /**
     * Generates a barcode image from the visitor id, then displays barcode image on badge
     *
     * @param string $barcodeID Visitors ID from Database
     * @return string
     */
    public function generateBarcode(string $barcodeID): string
    {
        $fontSize = 48;
        $angle = 0;
        $fontPath = ROOT . DS . 'webroot' . DS . 'font' . DS . 'FREE3OF9.ttf';

        $bbox = imagettfbbox($fontSize, $angle, $fontPath, $barcodeID);

        // Determine exact text dimensions
        $textWidth = $bbox[2] - $bbox[0];
        $textHeight = $bbox[1] - $bbox[7];

        // ensure enough space for scanning whole image
        $gap = 9;
        $img = imagecreatetruecolor($textWidth + ($gap * 2), $textHeight + ($gap * 2));

        $white = imagecolorallocate($img, 255, 255, 255);
        $black = imagecolorallocate($img, 0, 0, 0);
        imagefill($img, 0, 0, $white);

        // Calculate precise X and Y coordinates to align to the edges
        $x = -$bbox[0] + $gap;
        $y = -$bbox[7] + $gap;

        imagettftext($img, $fontSize, $angle, $x, $y, $black, $fontPath, $barcodeID);

        ob_start();
        imagepng($img);
        $imageData = ob_get_clean();

        return 'data:image/png;base64,' . base64_encode($imageData);
    }

    /**
     * Gets the house rules
     *
     * @return \Cake\Http\Response|null
     */
    public function houserules()
    {
        $session = $this->request->getSession();
        $organisationId = $session->read('Auth.organisation_id');
        $visitorId = $session->read('Visitor.id');
        $visitorName = $session->read('Visitor.name');
        if ($visitorId === null) { // if visitor has not checked in, send to visitor welcome/index page
            return $this->redirect([
                'controller' => 'Visitors',
                'action' => 'index',
            ]);
        }

        // GET rules
        $rulesTable = $this->fetchTable('Houserules')
            ->find()
            ->select(['id', 'name', 'rule_description'])
            ->where([
                'organisation_id' => $organisationId,
            ])
            ->andWhere(function ($exp) {
                // Where the rule has expired
                return $exp->or([
                'expiry_date >' => new \DateTime(),
                'expiry_date IS' => null,
                ]);
            })
            ->orderAsc('id')
            ->toArray();

        $this->set(compact('visitorId', 'visitorName', 'rulesTable'));
    }

    /**
     * Once visitor is finished, removes their id and name from session, giving way to next visitor.
     *
     * @return \Cake\Http\Response|null
     */
    public function resetVisitor()
    {
        $session = $this->request->getSession();

        $session->delete('Visitor.id');
        $session->delete('Visitor.name');

        return $this->redirect([
            'controller' => 'Visitors',
            'action' => 'index',
        ]);
    }

    /**
     * When a new visitor is added to the database, they are sent a welcoming email.
     *
     * @return void
     */
    public function emailVisitor()
    {
        // get the org
        $session = $this->request->getSession();
        $userId = $session->read('Auth.id');
        $user = $this->Staff->get($userId);
        $organisation = $this->fetchTable('Organisations')
            ->get($user->get('organisation_id'));
        $orgName = $organisation->get('name');

        // Get the visitors email and other data
        $visitorData = $this->getVisitor();
        $startTime = $visitorData['start_time'] ?? 'Error';
        $formattedStartTime = date('l, d F Y \a\t g:i A', strtotime($startTime));

        $visitorId = $session->read('Visitor.id');
        $visitorName = $session->read('Visitor.name');

        $visitorEmail = 'secret'; // fake email for testing

        $mailer = new Mailer('default');

        $mailer->setFrom(['secret' => 'Olivisit'])
            ->setTo($visitorEmail)
            ->setReplyTo('no-reply@example.com', 'No Reply Team')
            ->setSubject('Welcome to ' . $orgName)
            ->setEmailFormat('both') // sends HTML + text
            ->setViewVars([
                'orgName' => $orgName,
                'visitorName' => $visitorName,
                'formattedStartTime' => $formattedStartTime,
                'visitorId' => $visitorId,
            ])
            ->viewBuilder()
            ->setTemplate('checkin');

        $mailer->deliver();
    }
}
