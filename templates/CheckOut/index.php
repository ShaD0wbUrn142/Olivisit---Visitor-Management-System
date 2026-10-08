<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Visitor[]|\Cake\Collection\CollectionInterface $visitors
 */
?>
<!--CSS STYLING-->
<?= $this->Html->css('checkin') ?>

<nav class="navbar">
    <div class="logo">
        <!--Logo-->
        <?= $this->Html->image('login_logo.png', ['alt' => 'Company Logo', 'width' => '66px', 'height' => '66px']) ?>
    </div>
    <!-- Navigation Links -->
    <ul class="nav-menu">
        <?php echo $this->Html->link(
            'Back',
            ['controller' => 'Visitors', 'action' => 'index'],
            ['class' => 'nav-link', 'style' => 'background-color: #ffc10700; border: none;']
        ); ?>
    </ul>
</nav>

<!--Header-->
<?php
$orgName = $orgName ?? [];
?>
<header class="page-header">
    <h1><?= h($orgName) ?? 'Organisation Name' ?> Check-Out</h1>
    <b><?= $this->Flash->render() ?></b>
</header>

<body class="top">
    <div class="sign-in-container" name="sign-in-container">

        <div class="heading">
            <h2>Please Enter you Details</h2>
        </div>

        <div class="sign-in-form" name="sign-in-form">
            <?= $this->Form->create(null, ['class' => 'ajax-form']) ?>

            <div class="form-group">
                <label for="visitor-id">Please Enter Your Given Id</label>
                <input type="text" id="visitor-id" name="visitor-id" placeholder="Enter Id" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="first-name">First Name</label>
                    <input type="text" id="first-name" name="first-name" 
                            placeholder="Enter first name or leave blank" required>
                </div>

                <div class="form-group">
                    <label for="last-name">Last Name</label>
                    <input type="text" id="last-name" name="last-name" 
                            placeholder="Enter last name" required>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" 
                        placeholder="Enter email address" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" 
                        placeholder="Enter phone number" required>
            </div>

            <div class="form-group">
                <label for="start-time">Start Time</label>
                <input type="datetime-local" name="start-time" id="start-time" required>
            </div>

            <div class="form-group">
                <label for="end-time">End Time</label>
                <input type="datetime-local" name="end-time" id="end-time" required>
            </div>

            <div class="button-row">
                <?= $this->Form->button(
                    'Cancel',
                    ['name' => 'action',
                    'class' => 'cancel-sign-in', 'value' => 'cancel-sign-in',
                    'type' => 'submit']
                ) ?>
                <?= $this->Form->button(
                    'CheckOut',
                    ['name' => 'action',
                    'class' => 'submit-sign-in', 'value' => 'submit-sign-in',
                    'type' => 'submit']
                ) ?>
                <div class="loader"></div>
            </div>

            <?= $this->Form->end() ?>
        </div>
    </div>
</body>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const now = new Date();

        // Format as YYYY-MM-DDTHH:MM
        const localDateTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000)
            .toISOString()
            .slice(0, 16);

        document.getElementById('end-time').value = localDateTime;
    });

    document.getElementById('visitor-id').addEventListener('change', function() {
        const orgName = <?php echo json_encode($orgName ?? 'Error'); ?>;
        const visitorId = this.value;
        const checkOut = 'true';
        if (!visitorId) {

            document.getElementById('first-name').value = '';
            document.getElementById('last-name').value = '';
            document.getElementById('email').value = '';
            document.getElementById('phone').value = '';
            document.getElementById('start-time').value = '';

            return;
        }

        fetch(`/auto-fill/getVisitor/${visitorId}/${checkOut}`)
            .then(response => response.json())
            .then(visitor => {

                console.log(visitor);

                document.getElementById('first-name').value =
                    visitor.first_name || '';

                document.getElementById('last-name').value =
                    visitor.last_name || '';

                document.getElementById('email').value =
                    visitor.email || '';

                document.getElementById('phone').value =
                    visitor.phone_number || '';

                if (visitor.start_time) {
                    document.getElementById('start-time').value =
                        visitor.start_time.substring(0, 16);
                }
            })
            .catch(error => {
                console.error(error);
                alert('This visitor id does not belong to ' + orgName + '. Or this ID already has an end time.');
            });
    });
</script>