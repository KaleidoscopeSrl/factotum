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


@component('factotum::email.template.html.order_table', [ 'order' => $order, 'orderProducts' => $orderProducts ])
<h1>Ordine n. {{ $order->id }}</h1>
@endcomponent

<br>
<hr>
<br>

<!-- Outro Lines -->
@foreach ($outroLines as $line)
<p>{{ $line }}</p>
@endforeach


</td>
</tr>
</table>

</td>
</tr>

@endcomponent
