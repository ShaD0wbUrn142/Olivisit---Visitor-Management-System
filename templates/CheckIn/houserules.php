<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Visitor[]|\Cake\Collection\CollectionInterface $visitors
 */
?>
<!--CSS STYLING-->
<?= $this->Html->css('checkin') ?>
<?php $returnToPage = $this->Url->build(['controller' => 'Visitors', 'action' => 'index']); ?>

<nav class="navbar">
    <div class="logo">
    <!--Logo-->
    <?= $this->Html->image('login_logo.png', ['alt' => 'Company Logo','width' => '66px', 'height' => '66px']) ?>
    </div>
    <ul class="nav-menu">

    </ul>
</nav>

<!--Header-->
<?php
$visitorName = $visitorName ?? [];
?>
<header class="page-header">
    <h1>Welcome <?= h($visitorName) ?? 'Visitor Name' ?>!</h1>
    <b><?= $this->Flash->render() ?></b>
</header>

<body class="top">
    <div class="welcome-page" name="welcome-page">
        <?php
        $visitorId = $visitorId ?? [];
        ?>
        <div class="visitor-id" name="visitor-id"> 
            <h2>Your ID (Please remember for check out)</h2>
            <div class="visitor-id-box">
                <?= h($visitorId ?? 'NULL') ?>
            </div>
        </div>

        <?php
        $rulesTable = $rulesTable ?? [];
        ?>
        <div class="org-rules" name="org-rules">

            <h2>House Rules</h2>
            <div class="rules-grid">
                <?php foreach ($rulesTable as $rule) : ?>
                    <div class="rule">
                        <h3><?= h($rule->name) ?></h3>
                        <p><?= h($rule->rule_description) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</body>

<script>
    setTimeout(function() {
        window.location.href = "<?= $this->Url->build([
            'controller' => 'CheckIn',
            'action' => 'resetVisitor',
        ]) ?>";
    }, 30000);
</script>