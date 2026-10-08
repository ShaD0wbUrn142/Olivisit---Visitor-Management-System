<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Admin[]|\Cake\Collection\CollectionInterface $admin
 */
// Read the session theme value, default to 'light'
$currentTheme = $this->request->getSession()->read('Config.theme') ?? 'light';
?>
<!--CSS STYLING-->
<?= $this->Html->css('admin') ?>
<nav class="navbar">
    <div class="logo">
        <!--Logo-->
        <?= $this->Html->image('login_logo.png', ['alt' => 'Company Logo', 'width' => '66px', 'height' => '66px']) ?>
    </div>
    <!-- Navigation Links -->
    <ul class="nav-menu">
        <li class="nav-item"><a href="#" class="nav-link">Home</a></li>
        <?php echo $this->Html->link(
            'Log Out',
            ['controller' => 'Logout', 'action' => 'logout'],
            ['class' => 'nav-link', 'style' => 'background-color: #ffc10700; border: none;']
        ); ?>
        <li class="nav-item">
            <label class="theme-switch">
                <input type="checkbox" id="themeToggle" onchange="lightDarkMode()" 
                                <?= $currentTheme === 'dark' ? 'checked' : '' ?>>
                <span class="slider"></span>
            </label>
        </li>
    </ul>
</nav>
<!--Header-->
<header class="page-header">
    <?= $this->Html->meta('csrfToken', $this->request->getAttribute('csrfToken')); ?>
    <h1>Admin Dashboard</h1>
    <p>Welcome <?= $user->first_name ?? 'Administrator' ?>!</p>
    <b><?= $this->Flash->render() ?></b>
</header>

<!--Body-->

<body id="top" class="<?= $currentTheme === 'dark' ? 'dark-mode-body' : '' ?>">

    <!--Admin Panel for 4 cards-->
    <section class="admin-panel">

        <!--Create Organisations-->
        <div class="create-organisation">
            <h2>Create a new Organisation</h2>
            <?= $this->Form->create(null, ['class' => 'ajax-form']) ?>
            <!--Organisation Name-->
            <div class="neworg-form-group">
                <label for="name">Please enter Organisation Name</label>
                <input type="text" id="name" name="name" autocomplete="name" required placeholder="Woolworths">
            </div>

            <!--Organisation Code-->
            <div class="neworg-form-group">
                <?php
                $countries = $countries ?? [];
                ?>
                <label for="location-code">Please enter Location Code</label>
                <select id="location-code" name="location-code" required>
                    <option value="">Select country code</option>
                    <?php foreach ($countries as $code => $country) : ?>
                        <option value="<?= h($code) ?>">
                            <?= h($country) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!--Organisation Details-->
            <div class="neworg-form-group">
                <label for="org-details">Organisation Details:</label>
                <textarea id="org-details" name="org-details" rows="4" cols="50" placeholder="Type here..."></textarea>
            </div>
            <?= $this->Form->button(
                'Create Org',
                ['id' => 'loadbutton',
                'name' => 'action', 'value' => 'submit-new-org-btn',
                'class' => 'submit-new-org-btn',
                'type' => 'submit']
            ) ?>
            <div class="loader" id="loader"></div>
            <?= $this->Form->end() ?>
        </div>
        </div>

        <!--Edit Organisations-->
        <div class="edit-organisation">
            <?php
            $organisations = $organisations ?? [];
            ?>
            <h2>Edit an existing Organisation</h2>
            <?= $this->Form->create(null) ?>
            <div class="editorg-form-group">
                <!--Organisation Code-->
                <div class="editorg-form-group">
                    <label for="organisation-code">Please enter Organisation Id</label>
                    <input type="text" name="organisation-code" placeholder="Search Id..." 
                                        id="organisation-id-choice" list="organisation-code">
                    <datalist id="organisation-code" name="organisation-code" required>
                        <option value="">Select organisation Id</option>
                        <?php foreach ($organisations as $orgId => $orgCode) : ?>
                            <option value="<?= $orgId ?>">
                                <?= h($orgCode) ?>
                            </option>
                        <?php endforeach; ?>
                    </datalist>
                </div>

                <label for="new-name">Please enter Organisation Name</label>
                <input
                    type="name"
                    id="new-name"
                    name="new-name"
                    autocomplete="new-name"
                    placeholder="Woolworths"
                    required>
            </div>

            <!--Organisation Code-->
            <div class="editorg-form-group">
                <?php
                $countries = $countries ?? [];
                ?>
                <label for="new-location-code">Please enter Location Code</label>
                <select id="new-location-code" name="new-location-code" required>
                    <option value="">Select country code</option>
                    <?php foreach ($countries as $code => $country) : ?>
                        <option value="<?= h($code) ?>">
                            <?= h($country) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!--Organisation Details-->
            <div class="editorg-form-group">
                <label for="new-org-details">Organisation Details:</label>
                <textarea id="new-org-details" name="new-org-details" rows="4" cols="50" 
                                                    placeholder="Type here..."></textarea>
            </div>

            <?= $this->Form->button('Edit Org', [
                'type' => 'submit',
                'class' => 'submit-edit-org-btn',
                'formaction' => $this->Url->build([
                    'controller' => 'UpdateTable',
                    'action' => 'updateOrg',
                ]),
            ]) ?>

            <?= $this->Form->button('Disable Org', [
                'type' => 'submit',
                'id' => 'disable-org-btn',
                'class' => 'disable-edit-org-btn',
                'formaction' => $this->Url->build([
                    'controller' => 'UpdateTable',
                    'action' => 'disableOrg',
                ]),
            ]) ?>

            <?= $this->Form->button('Enable Org', [
                'type' => 'submit',
                'id' => 'enable-org-btn',
                'class' => 'enable-edit-org-btn',
                'style' => 'display:none;',
                'formaction' => $this->Url->build([
                    'controller' => 'UpdateTable',
                    'action' => 'enableOrg',
                ]),
            ]) ?>

            <?= $this->Form->button('Delete Org', [
                'type' => 'submit',
                'class' => 'delete-edit-org-btn',
                'formaction' => $this->Url->build([
                    'controller' => 'UpdateTable',
                    'action' => 'deleteOrg',
                ]),
            ]) ?>
            <div class="loader"></div>
        </div>
        <?= $this->Form->end() ?>
        </div>



        <!--CREATE rules-->
        <div class="createorg-rules">
            <h2>Add organisation rules</h2>
            <div class="rules-form-group">
                <?= $this->Form->create(null, ['class' => 'ajax-form']) ?>
                <!--Organisation Rule Name-->
                <div class="newrule-form-group">
                    <label for="rule-name">Please enter rule Name</label>
                    <input
                        type="name"
                        id="rule-name"
                        name="rule-name"
                        autocomplete="rule-name"
                        required
                        placeholder="Woolworths Rules">
                </div>

                <div class="newrule-form-group">
                    <label for="new-rule-code">Please select Organisation</label>
                    <select id="new-rule-code" name="organisation_id" required>
                        <option value="">Select organisation</option>
                        <?php foreach ($organisations as $orgId => $orgCode) : ?>
                            <option value="<?= $orgId ?>">
                                <?= h($orgCode) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!--Organisation Rules-->
                <div class="newrule-form-group">
                    <label for="org-rules">Organisation Rules:</label>
                    <textarea id="org-rules" name="org-rules" rows="4" cols="50" 
                                            placeholder="Type here..."></textarea>
                </div>

                <!--Expiry date-->
                <div class="newrule-form-group">
                    <label for="expiry-date">Choose expiry date:</label>
                    <input type="datetime-local" name="expiry-date" id="expiry-date">
                </div>

                <?= $this->Form->button(
                    'Create Rule',
                    ['name' => 'action',
                    'class' => 'submit-new-rule-btn', 'value' => 'submit-new-rule-btn',
                    'type' => 'submit']
                ) ?>
                <div class="loader"></div>
                <?= $this->Form->end() ?>
            </div>
        </div>

        <!--EDIT RULES-->
        <div class="editorg-rules">
            <?php
            $rules = $rules ?? [];
            ?>
            <h2>Edit organisation rules</h2>
            <div class="rules-form-group">
                <?= $this->Form->create(null) ?>
                <!--Rule Id-->
                <div class="newrule-form-group">
                    <label for="newrule-id">Please enter rule Id</label>
                    <input type="text" name="newrule-id" placeholder="Search Id..." 
                                    id="rule-id-choice" list="newrule-id" required>
                    <datalist id="newrule-id" name="newrule-id" required>
                        <option value="">Select Rule Id</option>
                        <?php foreach ($rules as $id => $name) : ?>
                            <option value="<?= $id ?>">
                                <?= h($id) ?> - <?= h($name) ?>
                            </option>
                        <?php endforeach; ?>
                    </datalist>
                </div>

                <!--Organisation Rule Name-->
                <div class="newrule-form-group">
                    <label for="newrule-name">Please enter rule Name</label>
                    <input
                        type="name"
                        id="newrule-name"
                        name="newrule-name"
                        autocomplete="newrule-name"
                        placeholder="Woolworths Rules">
                </div>

                <div class="newrule-form-group">
                    <label for="edit-rule-code">Please select Organisation</label>
                    <select id="edit-rule-code" name="edit-rule-code">
                        <option value="">Select organisation</option>
                        <?php foreach ($organisations as $orgId => $orgCode) : ?>
                            <option value="<?= $orgId ?>">
                                <?= h($orgCode) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!--Organisation Rules-->
                <div class="newrule-form-group">
                    <label for="editorg-rules">Organisation Rules:</label>
                    <textarea id="editorg-rules" name="editorg-rules" rows="4" cols="50" 
                                                    placeholder="Type here..."></textarea>
                </div>

                <!--Expirery date-->
                <div class="newrule-form-group">
                    <label for="editexpiry-date">Choose expiry date:</label>
                    <input type="datetime-local" name="editexpiry-date" id="editexpiry-date">
                </div>

                <?= $this->Form->button('Edit Rule', [
                    'type' => 'submit',
                    'class' => 'edit-new-rule-btn',
                    'formaction' => $this->Url->build([
                        'controller' => 'UpdateTable',
                        'action' => 'updateRule',
                    ]),
                ]) ?>

                <?= $this->Form->button('Delete Rule', [
                    'type' => 'submit',
                    'class' => 'delete-new-rule-btn',
                    'formaction' => $this->Url->build([
                        'controller' => 'UpdateTable',
                        'action' => 'deleteRule',
                    ]),
                ]) ?>
                <div class="loader"></div>
                <?= $this->Form->end() ?>
            </div>
        </div>

        <!--Create staff acc Organisations-->
        <div class="staff">
            <h2>Create a staff account</h2>
            <div class="newstaff-form-group">
                <?= $this->Form->create(null, ['class' => 'ajax-form']) ?>
                <div class="form-row">
                    <div class="newstaff-form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" id="firstName" name="firstname" placeholder="Enter first name" required>
                    </div>

                    <div class="newstaff-form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" id="lastName" name="lastname" placeholder="Enter last name" required>
                    </div>
                </div>

                <div class="newstaff-form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter email address" required>
                </div>

                <div class="newstaff-form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" placeholder="Enter phone number">
                </div>

                <div class="newstaff-form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Create a password" required>
                </div>

                <div class="form-row">
                    <div class="newstaff-form-group">
                        <label for="organisation">Organisation</label>
                        <select id="organisation" name="organisation" required>
                            <option value="">Select organisation</option>
                            <<?php foreach ($organisations as $orgId => $orgCode) : ?>
                                <option value="<?= $orgId ?>">
                                <?= h($orgCode) ?>
                                </option>
                             <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="newstaff-form-group">
                        <?php
                        $roles = $roles ?? [];
                        ?>
                        <label for="role">Role</label>
                        <select id="role" name="role" required>
                            <option value="">Select Role</option>
                            <?php foreach ($roles as $roleId => $roleName) : ?>
                                <option value="<?= $roleId ?>">
                                    <?= h($roleName) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <?= $this->Form->button(
                    'Create Account',
                    ['name' => 'action',
                    'class' => 'submit-btn', 'value' => 'submit-create-staff-btn',
                    'type' => 'submit']
                ) ?>
                <div class="loader"></div>
            </div>
            <?= $this->Form->end() ?>
        </div>


        <!--Edit staff acc Organisations-->
        <div class="edit-staff">
            <h2>Edit a staff account</h2>
            <div class="editstaff-form-group">
                <?= $this->Form->create(null) ?>

                <div class="editstaff-form-group">
                    <?php
                    $staff = $staff ?? [];
                    ?>
                    <label for="staff-id">Staff ID</label>
                    <input type="text" name="staff-id" placeholder="Search Id..." id="staff-id-choice" list="staff-id">
                    <datalist id="staff-id" name="staff-id" required>
                        <option value="">Select ID</option>
                        <?php foreach ($staff as $staffs) : ?>
                            <option value="<?= $staffs->id ?>">
                                <?= h($staffs->id . ' - ' . $staffs->first_name . ' ' . $staffs->last_name) ?>
                            </option>
                        <?php endforeach; ?>
                    </datalist>
                </div>

                <div class="form-row">
                    <?php
                    $organisations = $organisations ?? [];
                    $roles = $roles ?? [];
                    ?>
                    <div class="editstaff-form-group">
                        <label for="new-firstName">First Name</label>
                        <input type="text" id="new-firstName" name="new-firstName" 
                                            placeholder="Enter first name" required>
                    </div>

                    <div class="editstaff-form-group">
                        <label for="new-lastName">Last Name</label>
                        <input type="text" id="new-lastName" name="new-lastName" 
                                            placeholder="Enter last name" required>
                    </div>
                </div>

                <div class="editstaff-form-group">
                    <label for="new-email">Email Address</label>
                    <input type="email" id="new-email" name="new-email" 
                                        placeholder="Enter email address" required>
                </div>

                <div class="editstaff-form-group">
                    <label for="new-phone">Phone Number</label>
                    <input type="tel" id="new-phone" name="new-phone" 
                                    pattern="[0-9]{10}" placeholder="Enter phone number">
                </div>

                <div class="editstaff-form-group">
                    <label for="new-password">Password</label>
                    <input type="password" id="new-password" name="new-password" 
                            placeholder="Create a new password or leave blank to use previous password">
                </div>

                <div class="form-row">
                    <div class="editstaff-form-group">
                        <label for="new-organisation">Organisation</label>
                        <select id="new-organisation" name="new-organisation" required>
                            <option value="">Select organisation</option>
                            <?php foreach ($organisations as $orgId => $orgCode) : ?>
                                <option value="<?= $orgId ?>">
                                    <?= h($orgCode) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="editstaff-form-group">
                        <label for="new-role">Role</label>
                        <select id="new-role" name="new-role" required>
                            <option value="">Select Role</option>
                            <?php foreach ($roles as $roleId => $roleName) : ?>
                                <option value="<?= $roleId ?>">
                                    <?= h($roleName) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <?= $this->Form->button('Edit Account', [
                    'type' => 'submit',
                    'class' => 'submit-btn',
                    'formaction' => $this->Url->build([
                        'controller' => 'UpdateTable',
                        'action' => 'updateStaff',
                    ]),
                ]) ?>
                <?= $this->Form->button('Delete Account', [
                    'type' => 'submit',
                    'class' => 'delete-btn',
                    'formaction' => $this->Url->build([
                        'controller' => 'UpdateTable',
                        'action' => 'deleteStaff',
                    ]),
                ]) ?>
                <div class="loader"></div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </section>

    <!--View PANEL -->
    <section class="view-panel">
        <?= $this->Form->create(null, ['class' => 'ajax-form']) ?>
        <div class="organisation-view">
            <div class="card-header">
                <label for="display-organisation">
                    🏢 Select Organisation
                </label>
                <?= $this->Form->button(
                    '✔',
                    ['name' => 'action',
                    'class' => 'view-organisations-btn', 'value' => 'view-organisations-btn',
                    'type' => 'submit']
                ) ?>
            </div>
            <div class="loader"></div>
            <select id="display-organisation"
                name="display-organisation"
                size="10">
                <?php foreach ($organisations as $orgId => $orgCode) : ?>
                    <option value="<?= $orgId ?>">
                        <?= h($orgCode) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <?= $this->Form->end() ?>
        </div>

        <div class="table-card">
            <h3 class="table-card-h3">📋 Rules</h3>

            <table class="data-table">
                <?php
                $rulesTable = $rulesTable ?? [];
                ?>
                <thead>
                    <tr>
                        <th style="position: sticky; top: 7; background-color: #009879; z-index: 100;">Id</th>
                        <th style="position: sticky; top: 7; background-color: #009879; z-index: 100;">House Rule</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rulesTable as $housrules) : ?>
                        <tr>
                            <td><b><?= h($housrules->id) ?></b></td>
                            <td><?= h($housrules->rule_description) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="table-card">
            <?php
            $staffTable = $staffTable ?? [];
            $staffCount = $staffCount ?? null;
            ?>
            <h3 class="table-card-h3">👥 Staff</h3><b>Count: </b><?= $staffCount ?>
            <table class="data-table">

                <thead>
                    <tr>
                        <th style="position: sticky; top: 7; background-color: #009879; z-index: 100;">Id</th>
                        <th style="position: sticky; top: 7; background-color: #009879; z-index: 100;">Staff Name</th>
                        <th style="position: sticky; top: 7; background-color: #009879; z-index: 100;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($staffTable as $staff) : ?>
                        <tr>
                            <td><b><?= h($staff->id) ?></b></td>
                            <td><?= h($staff->first_name) ?> <?= h($staff->last_name) ?></td>
                            <td>
                                <?= $this->Form->postButton(
                                    'Impersonate',
                                    ['controller' => 'Admin', 'action' => 'impersonateUser', 'staff'],
                                    ['class' => 'submit-btn', 'style' => 'padding: 8px;', 'data' =>
                                    ['id' => $staff->id]]
                                ) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="table-card">
            <?php
            $visitorTable = $visitorTable ?? [];
            $visitorCount = $visitorCount ?? null;
            ?>
            <h3 class="table-card-h3">👤 Visitors</h3> <b>Count: </b><?= $visitorCount ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="position: sticky; top: 7; background-color: #009879; z-index: 100;">Id</th>
                        <th style="position: sticky; top: 7; background-color: #009879; z-index: 100;">Visitor Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($visitorTable as $visitor) : ?>
                        <tr>
                            <td><b><?= h($visitor->id) ?></b></td>
                            <td><?= h($visitor->first_name) ?> <?= h($visitor->last_name) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</body>
<!--Footer-->
<footer>
    <a href="#top" class="back-to-top">Back to Top</a>
</footer>

<script>
    function lightDarkMode() {
        var body = document.body;
        // Toggle the class on the body element
        body.classList.toggle("dark-mode-body");

        // Determine the theme based on whether the class is now active
        const isDark = body.classList.contains("dark-mode-body");
        const themeValue = isDark ? 'dark' : 'light';

        // Fetch CSRF token safely (falls back to empty string if meta tag is missing)
        const csrfMeta = document.querySelector('meta[name="csrfToken"]');
        const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

        fetch('/admin/set-theme', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': csrfToken
                },
                body: JSON.stringify({
                    theme: themeValue
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Theme saved:', data);
            })
            .catch(error => console.error('Error saving theme:', error));
    }


    document.querySelectorAll('.ajax-form').forEach(form => {
        form.addEventListener('submit', function() {

            const button = form.querySelector('button[type="submit"]');
            const loader = form.querySelector('.loader');

            if (loader) {
                loader.style.display = 'inline-block';
            }

            setTimeout(() => {
                if (button) {
                    button.disabled = true;
                }
            }, 10);
        });
    });

    document.getElementById('organisation-id-choice').addEventListener('change', function() {

        const orgId = this.value;
        if (!orgId) {
            document.getElementById('new-name').value = '';
            document.getElementById('new-location-code').value = '';
            document.getElementById('new-org-details').value = '';

            // reset the disable/enable button when no org is selected
            document.getElementById('disable-org-btn').style.display = 'inline-block'; 
            document.getElementById('enable-org-btn').style.display = 'none';

            return;
        }

        fetch('/auto-fill/getOrgFill/' + orgId)
            .then(response => response.json())
            .then(data => {
                console.log(data);

                document.getElementById('new-name').value =
                    data.name || '';

                const code = data.code.split('_').pop();

                document.getElementById('new-location-code').value = code;

                document.getElementById('new-org-details').value =
                    data.organisation_details || '';

                const disableBtn = document.getElementById('disable-org-btn');
                const enableBtn = document.getElementById('enable-org-btn');

                if (data.is_disabled) { // If the org is disabled, show the enable button and hide the disabled button
                    disableBtn.style.display = 'none';
                    enableBtn.style.display = 'inline-block';
                } else {
                    disableBtn.style.display = 'inline-block';
                    enableBtn.style.display = 'none';
                }
            })
            .catch(error => {
                console.error(error);
                alert('Unable to load organisation details.');
            });
    });

    document.getElementById('rule-id-choice').addEventListener('change', function() {

        const ruleId = this.value;
        if (!ruleId) {
            document.getElementById('newrule-name').value = '';
            document.getElementById('edit-rule-code').value = '';
            document.getElementById('editorg-rules').value = '';
            document.getElementById('editexpiry-date').value = '';
            return;
        }

        fetch('/auto-fill/getRuleFill/' + ruleId)
            .then(response => response.json())
            .then(rule => {

                document.getElementById('newrule-name').value =
                    rule.name || '';

                document.getElementById('edit-rule-code').value = // broken, need to fix later
                    rule.organisation_id || '';

                document.getElementById('editorg-rules').value =
                    rule.rule_description || '';

                if (rule.expiry_date) {
                    document.getElementById('editexpiry-date').value =
                        rule.expiry_date.substring(0, 16);
                } else {
                    document.getElementById('editexpiry-date').value = '';
                }
            })
            .catch(error => {
                console.error(error);
            });
    });


    document.getElementById('staff-id-choice').addEventListener('change', function() {
        const staffId = this.value;

        if (!staffId) {

            document.getElementById('new-firstName').value = '';
            document.getElementById('new-lastName').value = '';
            document.getElementById('new-email').value = '';
            document.getElementById('new-phone').value = '';
            document.getElementById('new-organisation').value = '';
            document.getElementById('new-role').value = '';

            return;
        }

        fetch('/auto-fill/getStaffFill/' + staffId)
            .then(response => response.json())
            .then(staff => {

                console.log(staff);

                document.getElementById('new-firstName').value =
                    staff.first_name || '';

                document.getElementById('new-lastName').value =
                    staff.last_name || '';

                document.getElementById('new-email').value =
                    staff.email || '';

                document.getElementById('new-phone').value =
                    staff.phone_number || '';

                document.getElementById('new-organisation').value =
                    staff.organisation_id || '';

                document.getElementById('new-role').value =
                    staff.role_id || '';
            })
            .catch(error => {
                console.error(error);
                alert('Unable to load staff details.');
            });
    });
</script>