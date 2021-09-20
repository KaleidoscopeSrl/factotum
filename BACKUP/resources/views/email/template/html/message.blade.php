@component('email.template.html.layout')

	{{-- Header --}}
	@slot('header')
		@component('email.template.html.header', ['url' => config('app.url')])
			<td width="80">
				<img src="{{ asset('/admin/assets/img/logo.png')  }}" alt="{{ config('app.name') }}">
			</td>
			<td class="link" align="left">
				@if( isset($demTitle) )
					<span>{{ $demTitle }}</span>
				@endif
			</td>
		@endcomponent
	@endslot

	{{-- Body --}}
	{{ $slot }}

	{{-- Subcopy --}}
	@isset($subcopy)
		@slot('subcopy')
			@component('email.template.html.subcopy')
				{{ $subcopy }}
			@endcomponent
		@endslot
	@endisset

	{{-- Footer --}}
	@slot('footer')
		@component('email.template.html.footer')
		&copy; Kaleidoscope S.R.L. - P.IVA 04360650230 <br>
		<br><br>
		<small>
			Ai sensi del Regolamento UE 679/2016 si precisa che le informazioni contenute in questo messaggio sono
			riservate ed a uso esclusivo del destinatario. Qualora il messaggio in parola Le fosse pervenuto per
			errore, La invitiamo ad eliminarlo senza copiarlo e a non inoltrarlo a terzi, dandocene gentilmente comunicazione. Grazie.
		</small>
		@endcomponent
	@endslot

@endcomponent