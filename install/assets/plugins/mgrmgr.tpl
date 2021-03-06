//<?php
/**
 * ManagerManager
 *
 * 投稿画面を自由自在にカスタマイズ。
 *
 * @category 	plugin
 * @version 	0.3.12.1
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal	@properties &config_chunk=Configuration Chunk;text;mm_rules; &remove_deprecated_tv_types_pref=Remove deprecated TV types;list;yes,no;yes;
 * @internal	@events OnDocFormRender,OnDocFormPrerender,OnBeforeDocFormSave,OnPluginFormRender,OnManagerMainFrameHeaderHTMLBlock
 * @internal	@modx_category Manager and Admin
 * @internal    @legacy_names Image TV Preview, Show Image TVs
 * @internal    @installset base
 */

// You can put your ManagerManager rules EITHER in a chunk OR in an external file - whichever suits your development style the best

// To use an external file, put your rules in /assets/plugins/managermanager/mm_rules.inc.php
// (you can rename default.mm_rules.inc.php and use it as an example)
// The chunk SHOULD have php opening tags at the beginning and end

// If you want to put your rules in a chunk (so you can edit them through the Manager),
// create the chunk, and enter its name in the configuration tab.
// The chunk should NOT have php tags at the beginning or end

// The URL to the jQuery library. Choose from the configuration tab whether you want to use
// a local copy (which defaults to the jQuery library distributed with ModX 1.0.1)
// a remote copy (which defaults to the Google Code hosted version)
// or specify a URL to a custom location.
// Here we set some default values, because this is a convenient place to change them if we need to,
// but you should configure your preference via the Configuration tab.

// You don't need to change anything else from here onwards
//-------------------------------------------------------

// Run the main code
$mm_path = $modx->config['base_path'] . 'assets/plugins/managermanager/mm.inc.php';
include_once($mm_path);
$mm = new MANAGERMANAGER();
$mm->run();
