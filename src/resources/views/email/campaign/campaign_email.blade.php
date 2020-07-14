@component('email.template.html.message', [ 'demTitle' => ( isset($demTitle) ? $demTitle : '' ), 'demLogo' => $demLogo, 'hideDemLogo' => $hideDemLogo ])

<!-- Email Body -->
<tr>
    <td class="body" width="100%" cellpadding="0" cellspacing="0">

<table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0">

@if ( $demImage )
<tr>
    <td>
        <img src="{{ $demImage }}?<?php echo time(); ?>" alt="{{ config('app.name') }}">
    </td>
</tr>
@endif

<tr>
<td class="content-cell">
    {!! $demContent !!}

    @isset($actionText)
        @component('mail::button', ['url' => $actionUrl, 'color' => 'red'])
            {{ $actionText }}
        @endcomponent
    @endisset

    {{-- Subcopy --}}
    @isset($actionText)
        @component('mail::subcopy')
            Se hai problemi nel cliccare il bottone "{{ $actionText }}", copia e incolla l'indirizzo
            seguente nel browser: [{{ $actionUrl }}]({{ $actionUrl }})
        @endcomponent
    @endisset

</td>
</tr>
</table>

</td>
</tr>

@endcomponent
