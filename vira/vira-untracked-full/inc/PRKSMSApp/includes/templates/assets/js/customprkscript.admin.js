// Useful for triggering deps when clicking on field label.
jQuery( document ).on( 'click', '#prk_woocot .toggler-wrapper input', function ( e ) {
    
    if ( jQuery( this ).is( ':checked' ) ) {
        jQuery( this ).closest('#prk_woocot').find('.prk_woocot_wrapper').fadeIn();
    } else {
        jQuery( this ).removeAttr( 'checked', 'checked' );

        jQuery( this ).closest('#prk_woocot').find('.prk_woocot_wrapper').fadeOut();

    }
} );