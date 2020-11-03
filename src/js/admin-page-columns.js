import ListScreenInitializeController from "./admin/columns/listscreen-initialize";
/**
 * AC variables. Defined in DOM.
 * @param AdminColumns {Object}
 * @param AC {Object}
 * @param AC.list_screen {String}
 * @param AC.layout {String}
 * @param AC.i81n {String}
 */
import Form from "./admin/columns/form";
import Modals from "./modules/modals";
import Initiator from "./admin/columns/initiator";
import Modal from "./modules/modal";
import Menu from "./admin/columns/menu";
import Feedback from "./admin/columns/feedback";
import Tooltip from "./modules/tooltips";
/** Events */
import EventToggle from './admin/columns/events/toggle';
import EventRemove from './admin/columns/events/remove';
import EventClone from './admin/columns/events/clone';
import EventRefresh from './admin/columns/events/refresh';
import EventTypeSelector from './admin/columns/events/type-selector';
import EventIndicator from './admin/columns/events/indicator';
import {EventLabel, EventLabelSettings} from './admin/columns/events/label';
import EventAddons from './admin/columns/events/addons';
/** Settings */
import SettingImageSize from './admin/columns/settings/image-size';
import SettingSubSettingToggle from './admin/columns/settings/sub-setting-toggle';
import SettingDate from './admin/columns/settings/date';
import SettingPro from './admin/columns/settings/pro';
import SettingWidth from './admin/columns/settings/width';
import SettingLabel from './admin/columns/settings/label';
import SettingCustomField from './admin/columns/settings/custom-field';
import SettingNumberFormat from './admin/columns/settings/number-format';
import SettingTypeSelector from "./admin/columns/settings/type";
import ScreenOption from "./modules/screen-option";

require( 'admin-columns-js/polyfill/customevent' );
require( 'admin-columns-js/polyfill/nodelist' );

global.AdminColumns = typeof AdminColumns !== "undefined" ? AdminColumns : {};

AC.Column = new Initiator(); // Todo remove from
AdminColumns.Column = AC.Column;

jQuery( document ).on( 'AC_Form_Loaded', function() {

	AdminColumns.Tooltips = new Tooltip();
	/** Register Events **/
	AdminColumns.Column
		.registerEvent( 'toggle', EventToggle )
		.registerEvent( 'remove', EventRemove )
		.registerEvent( 'clone', EventClone )
		.registerEvent( 'refresh', EventRefresh )
		.registerEvent( 'type_selector', EventTypeSelector )
		.registerEvent( 'indicator', EventIndicator )
		.registerEvent( 'label', EventLabel )
		.registerEvent( 'label_setting', EventLabelSettings )
		.registerEvent( 'addons', EventAddons )

		/** Register Settings **/
		.registerSetting( 'date', SettingDate )
		.registerSetting( 'image_size', SettingImageSize )
		.registerSetting( 'pro', SettingPro )
		.registerSetting( 'sub_setting_toggle', SettingSubSettingToggle )
		.registerSetting( 'width', SettingWidth )
		.registerSetting( 'customfield', SettingCustomField )
		.registerSetting( 'number_format', SettingNumberFormat )
		.registerSetting( 'type_selector', SettingTypeSelector )
		.registerSetting( 'label', SettingLabel );
} );

jQuery( document ).ready( function() {
	AC.Form = new Form( '#listscreen_settings' );
	AdminColumns.Form = AC.Form;
	Modals.init().register( new Modal( document.querySelector( '#ac-modal-pro' ) ), 'pro' );

	new Menu().init();
	new Feedback( '.sidebox#direct-feedback' );

	[ 'AC_Column_Change', 'AC_Column_Refresh' ].forEach( hook => {
		jQuery( document ).on( hook, () => ac_pointers() );
	} );

	jQuery( document ).on( 'AC_Column_Created', function( e, column ) {
		setTimeout( function() {
			ac_pointers();
		}, 100 )
	} );

	if ( AC.hasOwnProperty( 'uninitialized_list_screens' ) && Object.keys( AC.uninitialized_list_screens ).length > 0 ) {
		new ListScreenInitializeController( AC.uninitialized_list_screens );
	}

	AdminColumns.ScreenOptions = {};

	document.querySelectorAll( '[data-ac-screen-option]' ).forEach( el => {
		let name = el.dataset.acScreenOption;
		AdminColumns.ScreenOptions[ name ] = new ScreenOption( el, name );
	} );

	let showColumnId = document.querySelector( '[data-ac-screen-option="show_column_id"] input' );
	if ( showColumnId ) {
		showColumnId.addEventListener( 'change', () => {
			showColumnId.checked
				? document.querySelector( '.ac-boxes' ).classList.add( 'show-column-id' )
				: document.querySelector( '.ac-boxes' ).classList.remove( 'show-column-id' );
		} );
	}

	let showColumnType = document.querySelector( '[data-ac-screen-option="show_column_type"] input' );
	if ( showColumnType ) {
		showColumnType.addEventListener( 'change', () => {
			showColumnType.checked
				? document.querySelector( '.ac-boxes' ).classList.add( 'show-column-type' )
				: document.querySelector( '.ac-boxes' ).classList.remove( 'show-column-type' );
		} );
	}

	let showListScreenId = document.querySelector( '[data-ac-screen-option="show_list_screen_id"] input' );
	if ( showListScreenId ) {
		showListScreenId.addEventListener( 'change', () => {
			showListScreenId.checked
				? document.querySelector( '.ac-admin' ).classList.add( 'show-list-screen-id' )
				: document.querySelector( '.ac-admin' ).classList.remove( 'show-list-screen-id' );
		} );
	}

	let showListScreenType = document.querySelector( '[data-ac-screen-option="show_list_screen_type"] input' );
	if ( showListScreenType ) {
		showListScreenType.addEventListener( 'change', () => {
			showListScreenType.checked
				? document.querySelector( '.ac-admin' ).classList.add( 'show-list-screen-type' )
				: document.querySelector( '.ac-admin' ).classList.remove( 'show-list-screen-type' );
		} );
	}

} );