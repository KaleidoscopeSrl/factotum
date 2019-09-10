@component('factotum::email.template.html.message', ['demTitle' => $demTitle ])

<!-- Email Body -->
<tr>
    <td class="body" width="100%" cellpadding="0" cellspacing="0">

        <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0">
            <!-- Body content -->
            <tr>
                <td class="content-cell">
                    <p>
                        Gentile <?php echo $user->profile->first_name; ?> <?php echo $user->profile->last_name; ?>,
                        la tua nuova password è <strong class="anchor"><?php echo $password; ?></strong>
                    </p>
                </td>
            </tr>
        </table>
    </td>
</tr>

@endcomponent
