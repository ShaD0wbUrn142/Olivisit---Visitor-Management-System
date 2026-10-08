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
    <?= $this->Html->image('login_logo.png', ['alt' => 'Company Logo','width' => '66px', 'height' => '66px']) ?>
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
    <h1><?= h($orgName) ?? 'Organisation Name' ?> Check-In</h1>
    <b><?= $this->Flash->render() ?></b>
</header>

<body class="top">
    <div class="sign-in-container" name="sign-in-container">

        <div class="heading">
            <h2>Please Enter you Details</h2>
        </div>
        
        <div class="sign-in-form" name="sign-in-form">
            <?=$this->Form->create(null, ['class' => 'ajax-form']) ?>

            <div class="form-row">
                <div class="form-group">
                    <label for="first-name">First Name</label>
                    <input type="text" id="first-name" name="first-name" 
                            placeholder="Enter first name or leave blank" required>
                </div>

                <div class="form-group">
                    <label for="last-name">Last Name</label>
                    <input type="text" id="last-name" name="last-name" placeholder="Enter last name" required>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter email address" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" placeholder="Enter phone number" required>
            </div>
            
            <div class="form-group">
                <label for="start-time">Start Time</label>
                <input type="datetime-local" name="start-time" id="start-time" required>
            </div>

            <div class="form-group">
                <video id="video" autoplay></video>
                <button id="snap" type="button">Capture Photo</button>
                <canvas id="canvas" width="640" height="480" style="display:none;"></canvas>
                <br>
                <img id="photo" alt="Captured photo will appear here">
                <?= $this->Form->hidden('photo', ['id' => 'photo-data']) ?>
            </div>

            <div class="button-row">
                <?= $this->Form->button(
                    'Cancel',
                    ['name' => 'action',
                    'class' => 'cancel-sign-in', 'value' => 'cancel-sign-in',
                    'type' => 'submit']
                ) ?>
                <?= $this->Form->button(
                    'Submit',
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

        document.getElementById('start-time').value = localDateTime;
    });
</script>

<script>
const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const snap = document.getElementById('snap');
const photo = document.getElementById('photo');
const photoDataInput = document.getElementById('photo-data');


// Start the webcam feed
navigator.mediaDevices.getUserMedia({ video: true, audio: false })
    .then(stream => {
        video.srcObject = stream;
    })
    .catch(err => {
        console.error("Camera error: " + err);
    });

// Take the picture
snap.addEventListener('click', () => {
    const context = canvas.getContext('2d');
    context.drawImage(video, 0, 0, 640, 480);
    
    const dataUrl = canvas.toDataURL('image/png');
    
    // 1. Show the preview to the user
    photo.setAttribute('src', dataUrl);
    
    // 2. Insert into hidden field so it submits with the rest of the form
    photoDataInput.value = dataUrl; 
});
</script>