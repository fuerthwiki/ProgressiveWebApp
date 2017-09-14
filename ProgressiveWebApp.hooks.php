<?php


/**
	 * BeforePageDisplay hook handler
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/BeforePageDisplay
	 *
	 * @param OutputPage $out
	 * @param Skin $sk
	 * @return bool
	 */
	public static function onBeforePageDisplay( &$out, &$sk ) {
		if ( $this->getConfig()->get( 'MFEnableCustomManifest' ) ) {
			$out->addLink(
				[
					'rel' => 'manifest',
					'href' => wfExpandUrl(
						wfAppendQuery(
							wfScript( 'api' ),
							[ 'action' => 'webapp-manifest' ]
						),
						PROTO_RELATIVE
					)
				]
			);
		}
	}
