@component('factotum::email.template.html.layout')

	{{-- Header --}}
	@slot('header')
		@component('factotum::email.template.html.header', ['url' => config('app.url')])
			<td width="80">
				<img src="{{ asset('/assets/media/factotum/img/logo-dem.jpg')  }}" alt="{{ config('app.name') }}">
			</td>
			<td class="link" align="left">
				<span>{{ $demTitle }}</span>
			</td>
		@endcomponent
	@endslot

	{{-- Body --}}
	{{ $slot }}

	{{-- Subcopy --}}
	@isset($subcopy)
		@slot('subcopy')
			@component('factotum::email.template.html.subcopy')
				{{ $subcopy }}
			@endcomponent
		@endslot
	@endisset

	{{-- Footer --}}
	@slot('footer')
		@component('factotum::email.template.html.footer')
		&copy; Kaleidoscope S.R.L. - C.F. 04360650230 - P.IVA 04360650230 <br>
		<a href="https://factotum.kaleidoscope.it/#!/app/cookies" target="_blank">COOKIE POLICY</a> -
		<a href="https://factotum.kaleidoscope.it/#!/app/privacy" target="_blank">PRIVACY POLICY</a>
		<br><br>
		<small>
			Ai sensi del Regolamento UE 679/2016 si precisa che le informazioni contenute in questo messaggio sono
			riservate ed a uso esclusivo del destinatario. Qualora il messaggio in parola Le fosse pervenuto per
			errore, La invitiamo ad eliminarlo senza copiarlo e a non inoltrarlo a terzi, dandocene gentilmente comunicazione. Grazie.
		</small>
		@endcomponent
	@endslot

@endcomponent