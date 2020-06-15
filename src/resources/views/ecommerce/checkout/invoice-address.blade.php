<div class="box @if( $step == 'invoice-address' ) box-open @else box-close @endif @if ( $invoiceAddress ) box-valid @endif box-choose-invoice-address">

    <div class="box-header container-fluid col-no-pl col-no-pr">
        <div class="row clearfix">
            <div class="col col-xs-8">
                <h4 class="cta-aligned">2. Indirizzo di fatturazione</h4>
            </div>
            <div class="col col-xs-4 tar">
                <a href="{{ '/user/customer-addresses/edit/invoice?back-to-checkout=1' }}" class="cta cta-blue box-on-open">Nuovo Indirizzo</a>
                <i class="fi flaticon-confirmation green box-on-valid"></i>
            </div>
        </div>
    </div>

    <div class="box-expand">

        <div class="box-expand container-fluid col-no-pl col-no-pr">

            @if ( isset($invoiceAddresses) && $invoiceAddresses->count() > 0 )

                <div class="row clearfix">
                    @foreach ( $invoiceAddresses as $i )
                        <div class="col col-xs-12 col-sm-6">
                            <label for="invoice-address-{{ $i->id }}" class="box box-address box-choose">
                                <input type="radio" name="invoice-address"
                                       @if ($invoiceAddress && $invoiceAddress->id == $i->id ) checked @endif
                                       value="{{ $i->id }}" id="invoice-address-{{ $i->id }}">

                                @if ( $i->address != '' )
                                    <span>{{ $i->address }}</span><br>
                                @endif

                                @if ( $i->zip != '' && $i->city != '' )
                                    <span>{{ $i->zip }} - {{ $i->city }}</span><br>
                                @endif

                                @if ( $i->province != '' )
                                    <span>{{ $i->province }}</span><br>
                                @endif

                                @if ( $i->country != '' )
                                    <span>{{ $i->country }}</span><br>
                                @endif

                            </label>
                        </div>
                    @endforeach
                </div>

            @endif

            <div class="cta-container tar">
                <button class="cta" @if( !$invoiceAddress ) disabled @endif>CONTINUA</button>
            </div>

        </div>
    </div>

</div>