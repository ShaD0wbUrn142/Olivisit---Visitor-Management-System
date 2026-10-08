Hello <?= $staffName ?? 'Staff' ?>,

The following visitor house rules are due to expire within the next 7 days:

<?php $expiredRules = $expiredRules ?? []; ?>
<?php foreach ($expiredRules as $rule) : ?>
- #<?= $rule['id'] ?> (<?= $rule['name'] ?>)
<?php endforeach; ?>

Once expired, these rules will no longer be visible to visitors.

Please review them and either update their expiry dates or remove them if they are no longer required.

Please ensure these are handled before the end of the week.