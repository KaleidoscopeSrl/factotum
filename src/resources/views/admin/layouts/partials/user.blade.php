<div class="user">

	<div class="user_avatar">
		<?php if ( auth()->user()->avatar ) { ?>
			<img src="{{ auth()->user()->avatar }}" alt="<?php echo auth()->user()->profile->first_name . ' ' . auth()->user()->profile->last_name; ?>">
		<?php } else { ?>
		<div class="placeholder-char">
			<?php
				$firstname = auth()->user()->profile->first_name;
				$lastname = auth()->user()->profile->last_name;
				echo str_limit($firstname, 1, '').str_limit($lastname, 1, '');
			?>
		</div>
		<?php } ?>
	</div>

	<div class="user_info">
		<h2><a href="/admin/user/edit/{{ auth()->user()->id }}">{{ auth()->user()->profile->first_name }} {{ auth()->user()->profile->last_name }}</a></h2>
		<h3>{{ auth()->user()->email }}</h3>
	</div>

</div>