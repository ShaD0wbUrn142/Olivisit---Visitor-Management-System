<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Visitor[]|\Cake\Collection\CollectionInterface $visitors
 */
?>
<!--CSS STYLING-->
<?= $this->Html->css('visitor') ?>

<nav class="navbar">
    <div class="logo">
    <!--Logo-->
    <?= $this->Html->image('login_logo.png', ['alt' => 'Company Logo','width' => '66px', 'height' => '66px']) ?>
    </div>
    <!-- Navigation Links -->
    <ul class="nav-menu">
        <?php echo $this->Html->link(
            'Staff Page',
            ['controller' => 'Visitors', 'action' => 'staff-page'],
            ['class' => 'nav-link', 'style' => 'background-color: #ffc10700; border: none;']
        ); ?>
        <?php echo $this->Html->link(
            'Need Help?',
            ['controller' => 'Visitors', 'action' => 'needHelp'],
            ['class' => 'nav-link', 'style' => 'background-color: #ffc10700; border: none;']
        ); ?>
    </ul>
</nav>

<!--Header-->
<?php
$orgName = $orgName ?? [];
?>
<header class="page-header">
    <h1><?= h($orgName) ?? 'Organisation Name' ?>, welcomes you!</h1>
        <?php
        $serverTime = $serverTime ?? null;
        ?>
        <div id="live-clock" style=" font-weight: bold;">
            <!-- Initial server-side render fallback -->
            <?= $serverTime instanceof \DateTimeInterface ? h($serverTime->format('F j, g:i A')) : '' ?>
        </div>
    <b><?= $this->Flash->render() ?></b>
</header>

<body>
    <div class="content-container" name="content-container">
        <h2>Who are we?</h2>
        <div class="org-details" name="org-details">
            <?php $orgDetails = $orgDetails ?? []; ?>
            <?= nl2br(h($orgDetails)) ?>
        </div>

        <div class="buttons-container" name="buttons-container">
            <?php echo $this->Html->link(
                'Check In',
                ['controller' => 'Visitors', 'action' => 'check-in'],
                ['class' => 'check-in-btn']
            ); ?>
            <?php echo $this->Html->link(
                'Check Out',
                ['controller' => 'Visitors', 'action' => 'check-out'],
                ['class' => 'check-out-btn']
            ); ?>
        </div>
    </div>

    <div class="org-images" name="org-images">
        <?= $this->Html->image('cat.jpg', ['alt' => 'Placeholder Image 1']) ?>
        <?= $this->Html->image('sunset.jpg', ['alt' => 'Placeholder Image 2']) ?>
        <?= $this->Html->image('puppy.jpg', ['alt' => 'Placeholder Image 3']) ?>
    </div>
</body>

<!--Footer-->
<footer>
    <a href="#top" class="back-to-top">Back to Top</a>
</footer>

<script>
// Update the clock every 1 second
setInterval(function() {
    const now = new Date();
    // Format date and time nicely
    const options = { 
        month: 'long', 
        day: 'numeric', 
        hour: '2-digit', 
        minute: '2-digit'
    };
    document.getElementById('live-clock').innerText = now.toLocaleDateString(undefined, options);
}, 1000);
</script>