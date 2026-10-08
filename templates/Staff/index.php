<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staff
 */
// Read the session theme value, default to 'light'
$currentTheme = $this->request->getSession()->read('Config.theme') ?? 'light';
?>
<!--CSS STYLING-->
<?= $this->Html->css('staff') ?>
<nav class="navbar">
    <div class="logo">
        <!--Logo-->
        <?= $this->Html->image('login_logo.png', ['alt' => 'Company Logo', 'width' => '66px', 'height' => '66px']) ?>
    </div>
    <!-- Navigation Links -->
    <ul class="nav-menu">
        <?php echo $this->Html->link(
            'Visitor Page',
            ['controller' => 'Staff', 'action' => 'visitor-page'],
            ['class' => 'nav-link', 'style' => 'background-color: #ffc10700; border: none;']
        ); ?>
        <?php echo $this->Html->link(
            'Log Out',
            ['controller' => 'Logout', 'action' => 'logout'],
            ['class' => 'nav-link', 'style' => 'background-color: #ffc10700; border: none;']
        ); ?>
        <?= $this->Html->link(
            'Stop Impersonation',
            ['controller' => 'admin', 'action' => 'revertIdentity'],
            ['id' => 'stop-impersonate', 'class' => 'nav-link', 'style' =>
            'background-color: #ffc10700; border: none; display: none;']
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
<?php
$orgName = $orgName ?? [];
$user = $user ?? null;
?>
<header class="page-header">
    <?= $this->Html->meta('csrfToken', $this->request->getAttribute('csrfToken')); ?>
    <h1><?= h($orgName) ?? 'Organisation Name' ?> Staff Dashboard</h1>
    <p>Welcome <?= h($user->first_name ?? 'Staff') ?>!</p>
    <b><?= $this->Flash->render() ?></b>
</header>

<!--Body-->

<body id="top" class="<?= $currentTheme === 'dark' ? 'dark-mode-body' : '' ?>">
    <!--Organisation Details Section-->
    <section class="org-details">
        <!--Editing Organisation Details-->
        <div class="edit-org-details">
            <h2>Edit Organisation Details</h2>
            <?= $this->Form->create(null, ['class' => 'ajax-form']) ?>
            <div class="editorg-form-group">
                <label for="new-name">Please enter Organisation Name</label>
                <input
                    type="name"
                    id="new-name"
                    name="new-name"
                    autocomplete="new-name"
                    placeholder="Woolworths"
                    required>
            </div>

            <!--Organisation Details-->
            <div class="editorg-form-group">
                <label for="new-org-details">Organisation Details:</label>
                <textarea id="new-org-details" name="new-org-details" 
                        rows="4" cols="50" 
                        placeholder="Type here..." required></textarea>
            </div>
            <?= $this->Form->button(
                'Edit Org',
                ['name' => 'action',
                'class' => 'submit-edit-org-btn', 'value' => 'submit-edit-org-btn',
                'type' => 'submit']
            ) ?>
            <div class="loader"></div>
        </div>
        <?= $this->Form->end() ?>
        </div>

        <!--Editing Organisation Rules-->
        <div class="edit-rules">
            <h2>Edit Organisation Rules</h2>
            <?php
            $rulesTable = $rulesTable ?? [];
            ?>
            <div class="rules-form-group">
                <?= $this->Form->create(
                    null,
                    ['url' =>
                    ['controller' => 'UpdateTable', 'action' => 'updateRule'],
                    'class' => 'ajax-form']
                ) ?>
                <!--Rule Id-->
                <div class="newrule-form-group">
                    <label for="newrule-id">Please enter rule Id</label>
                    <input type="text" name="newrule-id" placeholder="Search Id..."     
                                            id="rule-id-choice" list="newrule-id">

                    <datalist id="newrule-id" name="newrule-id" required>
                        <option value="">Select Rule Id</option>
                        <?php foreach ($rulesTable as $rule) : ?>
                            <option value="<?= $rule->id ?>">
                                <?= h($rule->id . ' - ' . $rule->name) ?>
                            </option>
                        <?php endforeach; ?>
                    </datalist>
                </div>

                <!--Organisation Rule Name-->
                <div class="newrule-form-group">
                    <label for="newrule-name">Please enter rule Name</label>
                    <input
                        type="text"
                        id="newrule-name"
                        name="newrule-name"
                        autocomplete="newrule-name"
                        placeholder="Woolworths Rules">
                </div>

                <!--Organisation Rules-->
                <div class="newrule-form-group">
                    <label for="editorg-rules">Organisation Rules:</label>
                    <textarea id="editorg-rules" name="editorg-rules" rows="4" cols="50" 
                                                    placeholder="Type here..."></textarea>
                </div>

                <!--Expiry date-->
                <div class="newrule-form-group">
                    <label for="editexpiry-date">Choose expiry date:</label>
                    <input type="datetime-local" name="editexpiry-date" id="editexpiry-date">
                </div>

                <?= $this->Form->button('Edit Rule', ['class' => 'edit-new-rule-btn']) ?>
                <div class="loader"></div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </section>

    <!--Visitors Section-->
    <section class="visitor-details">
        <!--Viewing Visitors-->
        <div class="view-visitors">
            <h2 class="view-visitors-header">View Visitors <?php echo $this->Form->button(
                'Filter',
                ['onclick' => 'dropDown()',
                    'type' => 'button', 'class' => 'dropbtn',
                    'value' => 'dropbtn']
            ); ?>
            </h2>
            <?= $this->Form->create() ?>
            <div id="myDropdown" class="dropdown-content">
                <!-- My original Code
                <//?php echo $this->Form->button(
                    'Currently Visiting', ['type' => 'submit', 
                    'class' => 'filter-visitors-by-visiting', 
                    'value' => 'filter-visitors-by-visiting', 'name' => 'action']); ?>

                <//?php echo $this->Form->button(
                    'Filter today', ['type' => 'submit', 
                    'class' => 'filter-visitors-by-today', 'value' => 'filter-visitors-by-today', 
                    'name' => 'action']); ?>

                <//?php echo $this->Form->button(
                    'Filter last week', ['type' => 'submit', 
                    'class' => 'filter-visitors-by-week', 'value' => 'filter-visitors-by-week', 
                    'name' => 'action']); ?>

                <//?php echo $this->Form->button(
                    'Filter last month', ['type' => 'submit', 
                    'class' => 'filter-visitors-by-month', 'value' => 'filter-visitors-by-month', 
                    'name' => 'action']); ?>

                <//?php echo $this->Form->button(
                    'Filter last 6 months', ['type' => 'submit', 
                    'class' => 'filter-visitors-by-6month', 'value' => 'filter-visitors-by-6month', 
                    'name' => 'action']); ?>

                <//?php echo $this->Form->button(
                    'Filter last year', ['type' => 'submit', 
                    'class' => 'filter-visitors-by-year', 'value' => 'filter-visitors-by-year', 
                    'name' => 'action']); ?>

                <//?php echo $this->Form->button(
                    'Filter last 6 years', ['type' => 'submit', 
                    'class' => 'filter-visitors-by-6year', 'value' => 'filter-visitors-by-6year', 
                    'name' => 'action']); ?>
            -->
                <!-- A cleaner approach then the above by AI -->
                <?= $this->Form->button('Currently Visiting', [
                    'type' => 'submit',
                    'name' => 'filter',
                    'value' => 'visiting',
                    'class' => 'filter-visitors',
                ]) ?>

                <?= $this->Form->button('Filter today', [
                    'type' => 'submit',
                    'name' => 'filter',
                    'value' => 'today',
                    'class' => 'filter-visitors',
                ]) ?>

                <?= $this->Form->button('Filter last week', [
                    'type' => 'submit',
                    'name' => 'filter',
                    'value' => 'week',
                    'class' => 'filter-visitors',
                ]) ?>

                <?= $this->Form->button('Filter last month', [
                    'type' => 'submit',
                    'name' => 'filter',
                    'value' => 'month',
                    'class' => 'filter-visitors',
                ]) ?>

                <?= $this->Form->button('Filter last 6 months', [
                    'type' => 'submit',
                    'name' => 'filter',
                    'value' => '6month',
                    'class' => 'filter-visitors',
                ]) ?>

                <?= $this->Form->button('Filter last year', [
                    'type' => 'submit',
                    'name' => 'filter',
                    'value' => 'year',
                    'class' => 'filter-visitors',
                ]) ?>

                <?= $this->Form->button('Filter last 6 years', [
                    'type' => 'submit',
                    'name' => 'filter',
                    'value' => '6year',
                    'class' => 'filter-visitors',
                ]) ?>
            </div>
            <?= $this->Form->end() ?>

            <?php
            $filterVisitorTable = $filterVisitorTable ?? [];
            ?>
            <table class="visitor-table">
                <thead><!--Columns-->
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Phone Num</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody><!--Rows-->
                    <?php foreach ($filterVisitorTable as $visitor) : ?>
                        <tr>
                            <td><?= h($visitor->id) ?></td>
                            <td><?= h($visitor->first_name) ?> <?= h($visitor->last_name) ?></td>
                            <td><?= $visitor->start_time ? h($visitor->start_time->
                                        format('d/m/Y H:i')) : '<b>ERROR</b>' ?></td>
                            <td><?= $visitor->end_time ? h($visitor->end_time->
                                        format('d/m/Y H:i')) : '<b>Currently Visiting</b>' ?></td>
                            <td><?= h($visitor->phone_number) ?></td>
                            <td><?= h($visitor->email) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!--Editing Visitor Information-->
        <div class="edit-visitor">
            <h2>Edit Visitor Information</h2>
            <div class="edit-visitor-form-group">
                <?= $this->Form->create(
                    null,
                    ['url' =>
                    ['controller' => 'UpdateTable', 'action' => 'editVisitorDetails'],
                    'class' => 'ajax-form']
                ) ?>
                <div class="edit-visitor-form-group">
                    <?php
                    $visitorTable = $visitorTable ?? [];
                    ?>
                    <label for="visitor-id">Visitor Id</label>
                    <input type="text" name="visitor-id" placeholder="Search Id..." 
                                                    id="id-choice" list="visitor-id">

                    <datalist id="visitor-id" name="visitor-id" required>
                        <option value="">Select ID</option>
                        <?php foreach ($visitorTable as $visitor) : ?>
                            <option value="<?= $visitor->id ?>">
                                <?= h($visitor->id . ' - ' . $visitor->first_name . ' ' . $visitor->last_name) ?>
                            </option>
                        <?php endforeach; ?>
                    </datalist>
                </div>

                <div class="form-row">
                    <div class="edit-visitor-form-group">
                        <label for="first-name">First Name</label>
                        <input type="text" id="first-name" name="first-name" 
                                    placeholder="Enter first name or leave blank">
                    </div>

                    <div class="edit-visitor-form-group">
                        <label for="last-name">Last Name</label>
                        <input type="text" id="last-name" name="last-name" 
                                    placeholder="Enter last name">
                    </div>
                </div>

                <div class="edit-visitor-form-group">
                    <label for="new-email">Email Address</label>
                    <input type="email" id="new-email" name="new-email" 
                                    placeholder="Enter email address">
                </div>

                <div class="edit-visitor-form-group">
                    <label for="new-phone">Phone Number</label>
                    <input type="tel" id="new-phone" name="new-phone" 
                                    placeholder="Enter phone number">
                </div>

                <div class="form-row">
                    <div class="edit-visitor-form-group">
                        <label for="start-time">Start Time</label>
                        <input type="datetime-local" name="start-time" id="start-time">
                    </div>

                    <div class="edit-visitor-form-group">
                        <label for="end-time">End Time</label>
                        <input type="datetime-local" name="end-time" id="end-time">
                    </div>
                </div>
                <?= $this->Form->button(
                    'Edit Visitor',
                    ['class' => 'edit-visitor-btn', 'type' => 'submit']
                ) ?>
                <div class="loader"></div>
                <?= $this->Form->end() ?>
            </div>
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

        fetch('/staff/set-theme', {
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

    /* When the user clicks on the button,
    toggle between hiding and showing the dropdown content 
    https://www.w3schools.com/howto/howto_js_filter_dropdown.asp*/
    function dropDown() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Auto fill org details
    const orgId = <?php echo (int)($user->organisation_id ?? 0); ?>;

    fetch('/auto-fill/getOrgFill/' + orgId)
        .then(response => response.json())
        .then(data => {
            console.log(data);

            document.getElementById('new-name').value =
                data.name || '';

            document.getElementById('new-org-details').value =
                data.organisation_details || '';
        })
        .catch(error => {
            console.error(error);
            alert('Unable to load organisation details.');
        });

    document.getElementById('rule-id-choice').addEventListener('change', function() {

        const ruleId = this.value;
        if (!ruleId) {
            document.getElementById('newrule-name').value = '';
            document.getElementById('editorg-rules').value = '';
            document.getElementById('editexpiry-date').value = '';
            return;
        }

        fetch('/auto-fill/getRuleFill/' + ruleId)
            .then(response => response.json())
            .then(rule => {

                document.getElementById('newrule-name').value =
                    rule.name || '';

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

    document.getElementById('id-choice').addEventListener('change', function() {
        const orgName = <?php echo json_encode($orgName ?? 'Error'); ?>;

        const visitorId = this.value;
        if (!visitorId) {

            document.getElementById('first-name').value = '';
            document.getElementById('last-name').value = '';
            document.getElementById('new-email').value = '';
            document.getElementById('new-phone').value = '';
            document.getElementById('start-time').value = '';
            document.getElementById('end-time').value = '';

            return;
        }

        fetch('/auto-fill/getVisitor/' + visitorId)
            .then(response => response.json())
            .then(visitor => {

                console.log(visitor);

                document.getElementById('first-name').value =
                    visitor.first_name || '';

                document.getElementById('last-name').value =
                    visitor.last_name || '';

                document.getElementById('new-email').value =
                    visitor.email || '';

                document.getElementById('new-phone').value =
                    visitor.phone_number || '';

                if (visitor.start_time) {
                    document.getElementById('start-time').value =
                        visitor.start_time.substring(0, 16);
                }

                if (visitor.end_time) {
                    document.getElementById('end-time').value =
                        visitor.end_time.substring(0, 16);
                }
            })
            .catch(error => {
                console.error(error);
                alert('This visitor id does not belong to ' + orgName);
            });
    });
    // check the session to see if there is an Impersonater, if so, show them the way back
    const stopImpersonateBtn = document.getElementById('stop-impersonate');
    fetch('/staff/check-impersonate')
        .then(response => response.json())
        .then(data => {
            if (data.Impersonator) {
                stopImpersonateBtn.style.display = 'inline-block';
            } else {
                stopImpersonateBtn.style.display = 'none';
            }
        })
        .catch(error => console.error('Error checking session:', error));
</script>