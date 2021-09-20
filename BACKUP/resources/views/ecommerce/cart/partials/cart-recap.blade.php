<div class="box cart-recap">

	<h4>
		<span class="total-products">{{ $totalProducts }}</span> prodotti
	</h4>

	<table>

		<tr>
			<td>
				<h4>Totale parziale</h4>
			</td>
			<td class="tar">
				<span class="total-partial">{{ '€ ' . number_format( $totalPartial, 2, ',', '.' ) }}</span>
			</td>
		</tr>

		<tr>
			<td>
				<h4>Totale tasse</h4>
			</td>
			<td class="tar">
				<span class="total-taxes">{{ '€ ' . number_format( $totalTaxes, 2, ',', '.' ) }}</span>
			</td>
		</tr>

        <tr>
            <td>
                <h4>Spedizione</h4>
            </td>
            <td class="tar">
                <span class="total-shipping">
                    @if( $totalShipping )
						{!! $totalShipping !!}
                    @else
                        -
                    @endif
                </span>
            </td>
        </tr>

		<tr>
			<td>
				<h4>Totale (tasse incluse)</h4>
			</td>
			<td class="tar">
				<strong class="total">{{ '€ ' . number_format( $total, 2, ',', '.' ) }}</strong>
			</td>
		</tr>

	</table>

	@if ( !isset($hideCta) )
		<div class="cta-container tar">
			<a href="{{ url('/checkout') }}" class="cta">PROCEDI ALL'ORDINE</a>
		</div>
	@endif

</div>