<?php

$final = [];

if ( isset($breadcrumbs) && count($breadcrumbs) > 0 ) {

	$i = 0;
	foreach ( $breadcrumbs as $brLink => $brLabel ) {
		if ( $i == count($breadcrumbs) - 1 ) {
			$final[] = '<span>' . $brLabel . '</span>';
		} else {
			$final[] = '<a href="' . $brLink . '">' . $brLabel . '</a>';
		}
		$i++;
	}
?>

<div class="breadcrumbs">

<?php

	$i = 0;

	foreach ( $final as $item ) {

		echo $item;

		if ( $i < count($breadcrumbs) - 1 ) {
			echo ' <i class="fi flaticon-next"></i> ';
		}

		$i++;
	}

?>

</div>

<?php

}

?>
