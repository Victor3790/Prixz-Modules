<?php
/**
 * Class to set options and option fields on a custom admin view.
 *
 * WARNING: This class has not been properly documented.
 * WARNING: This class has not been tested properly, use with caution.
 *
 * @package Vk_custom_libs
 */

namespace Vk_custom_libs;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class to set options and option fields on a custom admin view.
 */
class Settings {

	/**
	 * The slug of the page to add the settings to.
	 *
	 * @var string
	 */
	private $page_slug;

	/**
	 * The settings group to add the settings to.
	 *
	 * @var string
	 */
	private $settings_group;

	/**
	 * The constructor for the class.
	 *
	 * @param string $page_slug       The slug of the page to add the settings to.
	 * @param string $settings_group  The settings group to add the settings to.
	 */
	public function __construct( string $page_slug, string $settings_group ) {
		$this->set_page_slug( $page_slug );
		$this->set_settings_group( $settings_group );
	}

	/**
	 * Get the page slug.
	 *
	 * @return string
	 */
	public function get_page_slug(): string {
		return $this->page_slug;
	}

	/**
	 * Set the page slug.
	 *
	 * @param string $page_slug The slug of the page to add the settings to.
	 */
	public function set_page_slug( string $page_slug ): void {
		$this->page_slug = $page_slug;
	}

	/**
	 * Get the settings group.
	 *
	 * @return string
	 */
	public function get_settings_group(): string {
		return $this->settings_group;
	}

	/**
	 * Set the settings group.
	 *
	 * @param string $settings_group The settings group to add the settings to.
	 */
	public function set_settings_group( string $settings_group ): void {
		$this->settings_group = $settings_group;
	}

	/**
	 * This function will add the settings sections and fields to the admin view.
	 *
	 * @param array $settings_sections The settings sections to add.
	 */
	public function add_settings_sections( array $settings_sections ): void {

		foreach ( $settings_sections as $section_id => $section_data ) {

			$this->add_section( $section_id, $section_data );

			foreach ( $section_data['settings'] as $setting_name => $setting_data ) {

				$this->add_setting( $setting_name, $section_id, $setting_data );
			}
		}
	}

	/**
	 * This function will echo the section header.
	 */
	public function echo_section_header(): void {

		echo '';
	}

	/**
	 * This function will add a section to the admin view.
	 * It will return false if the page slug is empty.
	 * Page slug should never be empty.
	 *
	 * @param string $section_id    The ID of the section.
	 * @param array  $section_data  The data of the section.
	 */
	public function add_section( string $section_id, array $section_data ): bool {

		$page_slug = $this->get_page_slug();

		if ( empty( $page_slug ) ) {
			return false;
		}

		empty( $section_data['section_title'] )
				? $section_title = ''
				: $section_title = $section_data['section_title'];

		empty( $section_data['echo_header_callback'] )
				? $echo_header_callback = array( $this, 'echo_section_header' )
				: $echo_header_callback = $section_data['echo_header_callback'];

		! empty( $section_data['section_args'] ) && is_array( $section_data['section_args'] )
			? $section_args = $section_data['section_args']
			: $section_args = array();

		add_settings_section(
			$section_id,
			$section_title,
			$echo_header_callback,
			$page_slug,
			$section_args
		);

		return true;
	}

	/**
	 * This function will add a setting to the admin view.
	 *
	 * @param string $setting_name    The name of the setting.
	 * @param string $section_id      The ID of the section to add the setting to.
	 * @param array  $setting_data    The data of the setting.
	 */
	public function add_setting( string $setting_name, string $section_id, array $setting_data ): bool {

		$page_slug      = $this->get_page_slug();
		$settings_group = $this->get_settings_group();

		if ( empty( $page_slug ) || empty( $settings_group ) ) {
			return false;
		}

		! empty( $setting_data['setting_args'] ) && is_array( $setting_data['setting_args'] )
			? $setting_args = $setting_data['setting_args']
			: $setting_args = array();

		! empty( $setting_data['field_args'] ) && is_array( $setting_data['field_args'] )
			? $field_args = $setting_data['field_args']
			: $field_args = array();

		$field_args['setting_name'] = $setting_name;

		if ( ! isset( $setting_data['field_label'] ) ) {
			$setting_data['field_label'] = '';
		}

		if ( empty( $setting_data['field_type'] ) ) {
			$setting_data['field_type'] = 'text';
		}

		! empty( $setting_data['echo_field_callback'] ) && is_callable( $setting_data['echo_field_callback'] )
			? $echo_field_callback = $setting_data['echo_field_callback']
			: $echo_field_callback = $this->get_field_callback( $setting_data['field_type'] );

		register_setting(
			$settings_group,
			$setting_name,
			$setting_args
		);

		add_settings_field(
			$setting_name,
			$setting_data['field_label'],
			$echo_field_callback,
			$page_slug,
			$section_id,
			$field_args
		);

		return true;
	}

	/**
	 * This function will echo a text field.
	 *
	 * @param array $field_args The arguments of the field.
	 */
	public function echo_text_field( array $field_args ): void {

		if ( empty( $field_args ) ) {
			echo 'No input data provided';

			return;
		}

		$field_placeholder = empty( $field_args['placeholder'] ) ? '' : $field_args['placeholder'];

		$option_value = get_option( $field_args['setting_name'] );

		if ( ! $option_value ) {
			echo '<input type="text" name="' . esc_attr( $field_args['setting_name'] ) . '" placeholder="' . esc_attr( $field_placeholder ) . '">';
		} else {
			echo '<input type="text" name="' . esc_attr( $field_args['setting_name'] ) . '" value="' . esc_attr( $option_value ) . '">';
		}
	}

	/**
	 * This function will echo a hidden field.
	 *
	 * @param array $field_args The arguments of the field.
	 */
	public function echo_hidden_field( array $field_args ): void {
		if ( empty( $field_args ) ) {
			return;
		}

		$option_value = get_option( $field_args['setting_name'] );

		if ( ! $option_value ) {
			echo '<input type="hidden" name="' . esc_attr( $field_args['setting_name'] ) . '" value="">';
		} else {
			echo '<input type="hidden" name="' . esc_attr( $field_args['setting_name'] ) . '" value="' . esc_attr( $option_value ) . '">';
		}
	}

	/**
	 * Get the field callback.
	 *
	 * @param string $field_type The type of the field.
	 */
	private function get_field_callback( string $field_type ): callable {
		switch ( $field_type ) {
			case 'text':
				return array( $this, 'echo_text_field' );

			case 'hidden':
				return array( $this, 'echo_hidden_field' );

			default:
				return array( $this, 'echo_text_field' );
		}
	}
}
