<table width="600" cellpadding="0" cellspacing="0" border="0" 
style="font-family: Arial, sans-serif; color: #333333; line-height: 1.6;">

    <tr>
        <td style="padding: 20px;">

        <h2>Certain house rules are about to expire</h2>

        <p>Hello <?= h($staffName ?? 'Staff') ?>,</p>

        <p>
            The following visitor house rules are due to expire within the next 7 days:
        </p>

        <ul>
            <?php $expiredRules = $expiredRules ?? []; ?>
            <?php foreach ($expiredRules as $rule) : ?>
                <li>
                    #<?= h($rule['id']) ?>
                    (<?= h($rule['name']) ?>)
                </li>
            <?php endforeach; ?>
        </ul>

        <p>
            Once expired, these rules will no longer be visible to visitors.
            Please review them and either update their expiry dates or remove
            them if they are no longer required.
        </p>

        <p>
            Please ensure these are handled before the end of the week.
        </p>

            <hr style="border:none; border-top:1px solid #e0e0e0; margin:30px 0;">

            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td align="center"
                        style="font-size:14px; color:#333333; font-weight:bold; padding-bottom:15px;">
                        <?= h($orgName ?? 'Error contact staff') ?>
                    </td>
                </tr>

                <tr>
                    <td align="center"
                        style="font-size:12px; color:#666666; padding-bottom:20px;">
                        You are receiving this email because one or more house rules are due to expire soon.
                    </td>
                </tr>

                <tr>
                    <td align="center"
                        style="font-size:12px; padding-bottom:20px;">
                        <a href="https://example.com"
                           target="_blank"
                           style="color:#0066cc;">
                            Manage Preferences
                        </a>

                        <span style="color:#cccccc; padding:0 10px;">|</span>

                        <a href="https://example.com"
                           target="_blank"
                           style="color:#0066cc;">
                            Privacy Policy
                        </a>
                    </td>
                </tr>

                <tr>
                    <td align="center"
                        style="font-size:11px; color:#999999;">
                        &copy; <?= date('Y') ?> Olivisit. All rights reserved.
                    </td>
                </tr>
            </table>

        </td>
    </tr>

</table>