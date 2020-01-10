<?php
    $LANG           = $module->lang;
    $config         = isset($options["config"]) ? $options["config"] : [];
    $disk_limit     = isset($options["disk_limit"]) ? Filter::numbers($options["disk_limit"]) : false;
    $bandwidth_limit = isset($options["bandwidth_limit"]) ? Filter::numbers($options["bandwidth_limit"]) : false;
    $email_limit     = isset($options["email_limit"]) ? Filter::numbers($options["email_limit"]) : false;
    $database_limit  = isset($options["database_limit"]) ? Filter::numbers($options["database_limit"]) : false;
    $addons_limit    = isset($options["addons_limit"]) ? Filter::numbers($options["addons_limit"]) : false;
    $subdomain_limit = isset($options["subdomain_limit"]) ? Filter::numbers($options["subdomain_limit"]) : false;
    $ftp_limit       = isset($options["ftp_limit"]) ? Filter::numbers($options["ftp_limit"]) : false;
    $park_limit      = isset($options["park_limit"]) ? Filter::numbers($options["park_limit"]) : false;
    $max_email_per_hour = isset($options["max_email_per_hour"]) ? Filter::numbers($options["max_email_per_hour"]) : false;
    $cpu_limit = isset($options["cpu_limit"]) ? Filter::html_clear($options["cpu_limit"]) : false;
    $server_features = isset($options["server_features"]) ? $options["server_features"] : [];
    $dns             = isset($options["dns"]) ? $options["dns"] : [];
    $ftp_raw         = isset($options["ftp_raw"]) ? $options["ftp_raw"] : NULL;
    $ftp_info        = isset($options["ftp_info"]) && $options["ftp_info"] ? $options["ftp_info"] : [];
    $domain          = isset($options["domain"]) ? $options["domain"] : false;
?>
<table width="100%" border="0" cellpadding="3">
    <tr>
        <td width="30%" style="border-bottom: 1px solid #eeeeee; padding: 5px;font-family: Calibri,Arial,Helvetica,sans-serif;">
            Panel
        </td>
        <td width="70%" style="border-bottom: 1px solid #eeeeee; padding: 5px;font-family: Calibri,Arial,Helvetica,sans-serif;">
            <a href="http://<?php echo $domain; ?>:2082">http://<?php echo $domain; ?>:2082</a>
        </td>
    </tr>

    <tr>
        <td width="30%" style="border-bottom: 1px solid #eeeeee; padding: 5px;font-family: Calibri,Arial,Helvetica,sans-serif;">
            <?php echo $LANG["text2"]; ?>
        </td>
        <td width="70%" style="border-bottom: 1px solid #eeeeee; padding: 5px;font-family: Calibri,Arial,Helvetica,sans-serif;">
            <?php echo $config["user"]; ?>
        </td>
    </tr>

    <tr>
        <td width="30%" style="border-bottom: 1px solid #eeeeee; padding: 5px;font-family: Calibri,Arial,Helvetica,sans-serif;">
            <?php echo $LANG["text3"]; ?>
        </td>
        <td width="70%" style="border-bottom: 1px solid #eeeeee; padding: 5px;font-family: Calibri,Arial,Helvetica,sans-serif;">
            <?php echo isset($config["password"]) ? $config["password"] : ''; ?>
        </td>
    </tr>

    <tr>
        <td width="30%" style="border-bottom: 1px solid #eeeeee; padding: 5px;font-family: Calibri,Arial,Helvetica,sans-serif;">
        </td>
        <td width="70%" style="border-bottom: 1px solid #eeeeee; padding: 5px;font-family: Calibri,Arial,Helvetica,sans-serif;">
            <?php echo $LANG["text4"]; ?>
        </td>
    </tr>

    <tr>
        <td width="30%" style="border-bottom: 1px solid #eeeeee; padding: 5px;font-family: Calibri,Arial,Helvetica,sans-serif;">
            <?php echo $LANG["text5"]; ?>
        </td>
        <td width="70%" style="border-bottom: 1px solid #eeeeee; padding: 5px;font-family: Calibri,Arial,Helvetica,sans-serif;">

            <?php echo $LANG["text6"]; ?>: mail.<?php echo $domain; ?><br>
            <?php echo $LANG["text7"]; ?>: mail.<?php echo $domain; ?><br>
            <?php echo $LANG["text8"]; ?>: 587<br>
            <?php echo $LANG["text9"]; ?>: 110<br>
            (<?php echo Utility::text_replace($LANG["text10"]["content"],['{mail_panel_link}' => "http://".$domain."/webmail"]); ?>)

        </td>
    </tr>
</table>