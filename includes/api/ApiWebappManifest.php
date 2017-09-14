<?php
/**
 * ApiWebappManifest.php
 *
 * see https://gerrit.wikimedia.org/r/#/c/323654/
 */

/**
 * Return the webapp manifest for this wiki
 */
class ApiWebappManifest extends ApiBase {

	/**
	 * Execute the requested Api actions.
	 */
	public function execute() {
		$config = $this->getConfig();
		$resultObj = $this->getResult();
		$resultObj->addValue( null, 'name', $config->get( 'Sitename' ) );
		$resultObj->addValue( null, 'orientation', 'portrait' );
		$resultObj->addValue( null, 'dir', $config->get( 'ContLang' )->getDir() );
		$resultObj->addValue( null, 'lang', $config->get( 'LanguageCode' ) );
		$resultObj->addValue( null, 'display', 'browser' );
		$resultObj->addValue( null, 'theme_color', $config->get( 'MFManifestThemeColor' ) );
		$resultObj->addValue( null, 'background_color', $config->get( 'MFManifestBackgroundColor' ) );
		$resultObj->addValue( null, 'start_url', Title::newMainPage()->getFullUrl() );

		$icons = [];

		$appleTouchIcon = $config->get( 'AppleTouchIcon' );
		if ( $appleTouchIcon !== false ) {
			$appleTouchIconUrl = wfExpandUrl( $appleTouchIcon, PROTO_RELATIVE );
			$appleTouchIconSize = getimagesize( $appleTouchIconUrl );
			$icon = [
				'src' => $appleTouchIconUrl
			];
			if ( $appleTouchIconSize !== false ) {
				$icon['sizes'] = $appleTouchIconSize[0].'x'.$appleTouchIconSize[1];
				$icon['type'] = $appleTouchIconSize['mime'];
			}
			$icons[] = $icon;
		}

		$resultObj->addValue( null, 'icons', $icons );

		$main = $this->getMain();
		$main->setCacheControl( [ 's-maxage'=>86400, 'max-age'=>86400 ] );
		$main->setCacheMode( 'public' );
	}

	public function getCustomPrinter() {
		return new ApiFormatJson( $this->getMain(), 'json' );
	}

}
