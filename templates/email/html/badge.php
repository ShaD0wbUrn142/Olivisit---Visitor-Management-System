<body style="margin:0;padding:20px;background-color:#f3f4f6;font-family:Segoe UI, Tahoma, Geneva, Verdana, sans-serif;">

  <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="486" align="center" style="
border:1px solid #e1e4e8;
border-radius:12px;
background:#ffffff;
overflow:hidden;
font-family:Segoe UI, Tahoma, Geneva, Verdana, sans-serif;
">

    <!-- Header -->
    <tr>
      <td style="
            background-color:#1a73e8;
            color:#ffffff;
            padding:16px 20px;
        ">

        <table role="presentation" width="100%">
          <tr>
            <td style="
                        font-size:18px;
                        font-weight:800;
                        letter-spacing:1px;
                        text-transform:uppercase;
                    ">
              <?= h($orgName ?? 'our organisation') ?>
            </td>

            <td align="right">
              <span style="
                            background:#4c8df0;
                            padding:6px 12px;
                            border-radius:20px;
                            font-size:12px;
                            font-weight:600;
                            text-transform:uppercase;
                            color:#ffffff;
                        ">
                Visitor
              </span>
            </td>
          </tr>
        </table>

      </td>
    </tr>

    <!-- Body -->
    <tr>
      <td style="padding:20px;">

        <table role="presentation" width="100%">
          <tr>

            <!-- Photo -->
            <td width="130" valign="top">

              <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td style="
                    width:110px;
                    height:135px;
                    border:3px solid #1a73e8;
                    border-radius:8px;
                    overflow:hidden;
                    background:#f7f9fa; ">

                    <img src="<?= h($photo ?? 'error') ?>" width="visitor Photo" alt="Visitor Photo"
                      width="110"
                      height="135"
                      style="
                        object-fit: cover; 
                        display:block;
                        border:0;
                        width:110px;
                        height:135px;">
                  </td>
                </tr>
              </table>

            </td>

            <!-- Details -->
            <td valign="top">

              <div style="font-size:11px;color:#70757a;font-weight:700;text-transform:uppercase;letter-spacing:.5px;">
                Full Name
              </div>

              <div style="
                            font-size:28px;
                            color:#1a73e8;
                            font-weight:700;
                            margin-bottom:15px;
                        ">
                <?= h($visitorName ?? 'Visitor') ?>
              </div>

              <div style="font-size:11px;color:#70757a;font-weight:700;text-transform:uppercase;letter-spacing:.5px;">
                Email
              </div>

              <div style="
                            font-size:14px;
                            color:#202124;
                            font-weight:600;
                            margin-bottom:15px;
                        ">
                <?= h($email ?? 'email@example.com') ?>
              </div>

              <table role="presentation" width="100%">
                <tr>

                  <td valign="top">

                    <div style="font-size:11px; color:#70757a; font-weight:700; text-transform:uppercase;">
                      Issued
                    </div>

                    <div style="
                                        font-size:14px;
                                        color:#202124;
                                        font-weight:600;
                                    ">
                      ><?= h($formattedStartTime ?? 'Error contact staff') ?>
                    </div>

                  </td>

                  <td valign="top">

                    <div style="font-size:11px;color:#70757a;font-weight:700;text-transform:uppercase;">
                      Badge ID
                    </div>

                    <div style="
                                        font-size:14px;
                                        color:#202124;
                                        font-weight:600;
                                    ">
                      ><?= h($visitorId ?? 'Error contact staff') ?>
                    </div>

                  </td>

                </tr>
              </table>

            </td>

          </tr>
        </table>

      </td>
    </tr>

    <!-- Footer -->
    <tr>
      <td style="
            background:#f8f9fa;
            border-top:1px solid #e8eaed;
            padding:10px 20px;
        ">

        <table role="presentation" width="100%">
          <tr>

            <td>
              <img src="<?= h($barcodeImage ?? 'error') ?>">
            </td>

            <td align="right" style="
                        font-size:11px;
                        color:#9aa0a6;
                        font-weight:500;
                        font-family:Segoe UI, Tahoma, Geneva, Verdana, sans-serif;
                    ">
              Property of <?= h($orgName ?? 'our organisation') ?>
            </td>

          </tr>
        </table>

      </td>
    </tr>

  </table>

</body>