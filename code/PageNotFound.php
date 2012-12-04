<?php
/**
 * ErrorPage holds the content for the page of an error response.
 * Renders the page on each publish action into a static HTML file
 * within the assets directory, after the naming convention
 * /assets/error-<statuscode>.html.
 * This enables us to show errors even if PHP experiences a recoverable error.
 * ErrorPages
 *
 * @see Debug::friendlyError()
 *
 * @package cms
 */
class PageNotFound extends ErrorPage {

	static $icon = "mysite/images/treeIcons/PageNotFound";

	static $hide_ancestor = "ErrorPage";

	function doPublish() {
		parent::doPublish();
	}
}
/**
 * Controller for ErrorPages.
 * @package cms
 */
class PageNotFound_Controller extends ErrorPage_Controller {


	private static $old_to_new_array = array();

	public static function set_old_to_new_array(array $a) {self::$old_to_new_array = $a;}

	function init() {
		parent::init();
		$bt = defined('DB::USE_ANSI_SQL') ? "\"" : "`";
		$page = null;
		//NOTE: this function (Director::urlParam) is depreciated, but should actuall be kept
		$URLSegment = Director::urlParam("URLSegment");
		$Action = Director::urlParam("Action");
		foreach(self::$old_to_new_array as $oldURL => $newURL) {
			if($URLSegment == $oldURL) {
				$page = DataObject::get_one("SiteTree", "URLSegment = '$newURL'");
				Director::redirect($page->Link(), 301);
			}
			elseif($URLSegment."/".$Action == $oldURL) {
				$page = DataObject::get_one("SiteTree", "URLSegment = '$newURL'");
				Director::redirect($page->Link(), 301);
			}
		}
	}


}


