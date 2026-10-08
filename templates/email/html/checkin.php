<table width="600" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; color: #333333; line-height: 1.6;">

    <tr>
        <td style="padding: 20px;">

            <h2 style="margin-top: 0; color: #2e75b6;">
                Welcome to <?= h($orgName ?? 'our organisation') ?>
            </h2>

            <p>Hello <?= h($visitorName ?? 'Visitor') ?>,</p>

            <p>
                Welcome to <?= h($orgName ?? 'Error contact staff') ?>.
            </p>

            <p>
                Your visit is scheduled to begin at
                <strong><?= h($formattedStartTime ?? 'Error contact staff') ?></strong>.
            </p>

            <p>
                Please keep your visitor ID
                <strong><?= h($visitorId ?? 'Error contact staff') ?></strong>
                handy, as you will need it when checking out.
            </p>

            <table
                width="100%"
                cellpadding="12"
                cellspacing="0"
                border="0"
                style="background:#f4f7fb; border-left:4px solid #2e75b6; margin:20px 0;">

                <tr>
                    <td width="140">
                        <strong>Organisation</strong>
                    </td>
                    <td>
                        <?= h($orgName ?? 'our organisation') ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <strong>Visit Start</strong>
                    </td>
                    <td>
                        <?= h($formattedStartTime ?? 'Error contact staff') ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <strong>Visitor ID</strong>
                    </td>
                    <td>
                        <?= h($visitorId ?? 'Error contact staff') ?>
                    </td>
                </tr>

            </table>

            <p>
                The Wi-Fi password will be available upon arrival.
                Please ask reception if you require assistance connecting.
            </p>

            <p>
                We look forward to seeing you.
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
                        You are receiving this email because a visit has been
                        scheduled for you with
                        <?= h($orgName ?? 'Error contact staff') ?>.
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