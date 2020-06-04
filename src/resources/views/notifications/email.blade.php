@component('email.template.html.message', [ 'demTitle' => ( isset($subject) ? $subject : '' ) ])

<tr>
<td class="body" width="100%" cellpadding="0" cellspacing="0">

<table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0">
<tr>
<td class="content-cell">

<!-- Intro Lines -->
@foreach ($introLines as $line)
<p>{{ $line }}</p>
@endforeach

<!-- Action Button -->
@isset($actionText)
	<?php
	switch ($level) {
		case 'success':
		case 'error':
			$color = $level;
			break;
		default:
			$color = 'success';
	}
	?>
	@component('email.template.html.button', ['url' => $actionUrl, 'color' => $color])
		{{ $actionText }}
	@endcomponent
@endisset


<!-- Outro Lines -->
@foreach ($outroLines as $line)
<p>{{ $line }}</p>
@endforeach


{{-- Subcopy --}}
@isset($actionText)
@component('email.template.html.subcopy')
@lang(
	"If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
	'into your web browser:',
	[
		'actionText' => $actionText,
	]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@endcomponent
@endisset

</td>
</tr>
</table>

</td>
</tr>

@endcomponent
