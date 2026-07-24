<?php

namespace MediaWiki\Extension\ConfirmLogout;

use MediaWiki\Output\OutputPage;
use MediaWiki\Skin\Skin;

class Hooks {

    /**
     * Asks for confirmation before logging out.
     */
    public static function onBeforePageDisplay( OutputPage $out, Skin $skin ): void {
        $out->addInlineScript( <<<JS
document.addEventListener( 'click', function ( e ) {
    var link = e.target.closest( '#pt-logout a' );
    if ( !link ) {
        return;
    }
    e.preventDefault();
    e.stopPropagation();
    mw.loader.using( 'oojs-ui-windows' ).done( function () {
        OO.ui.confirm( "Are you sure you'd like to log out?" ).done( function ( confirmed ) {
            if ( confirmed ) {
                mw.hook( 'skin.logout' ).fire( link.href );
            }
        } );
    } );
}, true );
JS
        );
    }

}
