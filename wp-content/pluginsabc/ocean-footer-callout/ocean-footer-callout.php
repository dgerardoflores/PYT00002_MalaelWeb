<?php
/**
 * Plugin Name:         Ocean Footer Callout
 * Plugin URI:          https://oceanwp.org/extension/ocean-footer-callout/
 * Description:         Add some relevant/important information about your company or product in your footer.
 * Version:             2.0.1
 * Author:              OceanWP
 * Author URI:          https://oceanwp.org/
 * Requires at least:   5.3
 * Tested up to:        5.4
 *
 * Text Domain: ocean-footer-callout
 * Domain Path: /languages
 *
 * @package Ocean_Footer_Callout
 * @category Core
 * @author OceanWP
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns the main instance of Ocean_Footer_Callout to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Ocean_Footer_Callout
 */
function Ocean_Footer_Callout() {
	return Ocean_Footer_Callout::instance();
} // End Ocean_Footer_Callout()

Ocean_Footer_Callout();

/**
 * Main Ocean_Footer_Callout Class
 *
 * @class Ocean_Footer_Callout
 * @version 1.0.0
 * @since 1.0.0
 * @package Ocean_Footer_Callout
 */
final class Ocean_Footer_Callout {
	/**
	 * Ocean_Footer_Callout The single instance of Ocean_Footer_Callout.
	 *
	 * @var     object
	 * @access  private
	 * @since   1.0.0
	 */
	private static $_instance = null;

	/**
	 * The token.
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $token;

	/**
	 * The version number.
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $version;

	// Admin - Start
	/**
	 * The admin object.
	 *
	 * @var     object
	 * @access  public
	 * @since   1.0.0
	 */
	public $admin;

	/**
	 * Constructor function.
	 *
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function __construct() {
		$this->token       = 'ocean-footer-callout';
		$this->plugin_url  = plugin_dir_url( __FILE__ );
		$this->plugin_path = plugin_dir_path( __FILE__ );
		$this->version     = '2.0.1';

		register_activation_hook( __FILE__, array( $this, 'install' ) );

		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		add_filter( 'ocean_register_tm_strings', array( $this, 'register_tm_strings' ) );
	}

	public function init() {
		add_action( 'init', array( $this, 'setup' ) );
	}

	/**
	 * Main Ocean_Footer_Callout Instance
	 *
	 * Ensures only one instance of Ocean_Footer_Callout is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see Ocean_Footer_Callout()
	 * @return Ocean_Footer_Callout Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	} // End instance()

	/**
	 * Load the localisation file.
	 *
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'ocean-footer-callout', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), '1.0.0' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), '1.0.0' );
	}

	/**
	 * Installation.
	 * Runs on activation. Logs the version number and assigns a notice message to a WordPress option.
	 *
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function install() {
		$this->_log_version_number();
	}

	/**
	 * Log the plugin version number.
	 *
	 * @access  private
	 * @since   1.0.0
	 * @return  void
	 */
	private function _log_version_number() {
		// Log the version number.
		update_option( $this->token . '-version', $this->version );
	}

	/**
	 * Register translation strings.
	 */
	public static function register_tm_strings( $strings ) {

		if ( is_array( $strings ) ) {
			$strings['ofc_callout_text']       = 'Lorem ipsum dolor sit amet consectetur ni adipiscing elit.';
			$strings['ofc_callout_button_url'] = '#';
			$strings['ofc_callout_button_txt'] = 'Get In Touch';
		}

		return $strings;

	}

	/**
	 * Setup all the things.
	 * Only executes if OceanWP or a child theme using OceanWP as a parent is active and the extension specific filter returns true.
	 *
	 * @return void
	 */
	public function setup() {
		$theme = wp_get_theme();

		if ( 'OceanWP' == $theme->name || 'oceanwp' == $theme->template ) {
			// Capabilities
			$capabilities = apply_filters( 'ocean_main_metaboxes_capabilities', 'manage_options' );

			add_action( 'customize_register', array( $this, 'customize_register' ) );
			add_action( 'customize_preview_init', array( $this, 'customize_preview_js' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 999 );
			if ( current_user_can( $capabilities ) ) {
				add_action( 'butterbean_register', array( $this, 'new_tab' ), 10, 2 );
			}
			add_action( 'ocean_before_footer', array( $this, 'footer_callout' ) );
			add_filter( 'ocean_head_css', array( $this, 'head_css' ) );
		}
	}

	/**
	 * Customizer Controls and settings
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function customize_register( $wp_customize ) {

		/**
		 * Add a new section
		 */
		$wp_customize->add_section(
			'ofc_section',
			array(
				'title'    => esc_html__( 'Footer Callout', 'ocean-footer-callout' ),
				'priority' => 210,
			)
		);

		/**
		 * Callout Template
		 */
		$wp_customize->add_setting(
			'ofc_callout_template',
			array(
				'default'           => '0',
				'sanitize_callback' => 'oceanwp_sanitize_select',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ofc_callout_template',
				array(
					'label'       => esc_html__( 'Select Template', 'ocean-footer-callout' ),
					'description' => esc_html__( 'Choose a template created in Theme Panel > My Library.', 'ocean-footer-callout' ),
					'type'        => 'select',
					'section'     => 'ofc_section',
					'settings'    => 'ofc_callout_template',
					'priority'    => 10,
					'choices'     => oceanwp_customizer_helpers( 'library' ),
				)
			)
		);

		/**
		 * Callout text
		 */
		$wp_customize->add_setting(
			'ofc_callout_text',
			array(
				'default'           => 'Lorem ipsum dolor sit amet consectetur ni adipiscing elit.',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'wp_kses_post',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ofc_callout_text',
				array(
					'label'    => esc_html__( 'Content', 'ocean-footer-callout' ),
					'section'  => 'ofc_section',
					'settings' => 'ofc_callout_text',
					'type'     => 'textarea',
					'priority' => 10,
				)
			)
		);

		/**
		 * Callout text Typography
		 */
		$wp_customize->add_setting(
			'ofc_callout_text_typo_font_family',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_setting(
			'ofc_callout_text_typo_font_size',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_setting(
			'ofc_callout_text_typo_font_weight',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_key',
			)
		);
		$wp_customize->add_setting(
			'ofc_callout_text_typo_font_style',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_key',
			)
		);
		$wp_customize->add_setting(
			'ofc_callout_text_typo_transform',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_key',
			)
		);
		$wp_customize->add_setting(
			'ofc_callout_text_typo_line_height',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_setting(
			'ofc_callout_text_typo_spacing',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Typo_Control(
				$wp_customize,
				'ofc_callout_text_typo',
				array(
					'label'    => esc_html__( 'Typography', 'ocean-footer-callout' ),
					'section'  => 'ofc_section',
					'settings' => array(
						'family'      => 'ofc_callout_text_typo_font_family',
						'size'        => 'ofc_callout_text_typo_font_size',
						'weight'      => 'ofc_callout_text_typo_font_weight',
						'style'       => 'ofc_callout_text_typo_font_style',
						'transform'   => 'ofc_callout_text_typo_transform',
						'line_height' => 'ofc_callout_text_typo_line_height',
						'spacing'     => 'ofc_callout_text_typo_spacing',
					),
					'priority' => 10,
					'l10n'     => array(),
				)
			)
		);

		/**
		 * Callout button heading
		 */
		$wp_customize->add_setting(
			'ofc_callout_button_heading',
			array(
				'sanitize_callback' => 'wp_kses',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Heading_Control(
				$wp_customize,
				'ofc_callout_button_heading',
				array(
					'label'    => esc_html__( 'Button', 'ocean' ),
					'section'  => 'ofc_section',
					'priority' => 10,
				)
			)
		);

		/**
		 * Callout button
		 */
		$wp_customize->add_setting(
			'ofc_callout_button',
			array(
				'default'           => true,
				'sanitize_callback' => 'oceanwp_sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ofc_callout_button',
				array(
					'label'    => esc_html__( 'Enable Button', 'ocean-footer-callout' ),
					'section'  => 'ofc_section',
					'settings' => 'ofc_callout_button',
					'type'     => 'checkbox',
					'priority' => 10,
				)
			)
		);

		/**
		 * Callout button
		 */
		$wp_customize->add_setting(
			'ofc_callout_button_url',
			array(
				'default'           => '#',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ofc_callout_button_url',
				array(
					'label'    => esc_html__( 'Button URL', 'ocean-footer-callout' ),
					'section'  => 'ofc_section',
					'settings' => 'ofc_callout_button_url',
					'type'     => 'text',
					'priority' => 10,
				)
			)
		);

		/**
		 * Callout button text
		 */
		$wp_customize->add_setting(
			'ofc_callout_button_txt',
			array(
				'default'           => esc_html__( 'Get In Touch', 'ocean-footer-callout' ),
				'transport'         => 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ofc_callout_button_txt',
				array(
					'label'    => esc_html__( 'Button Text', 'ocean-footer-callout' ),
					'section'  => 'ofc_section',
					'settings' => 'ofc_callout_button_txt',
					'type'     => 'text',
					'priority' => 10,
				)
			)
		);

		/**
		 * Callout button target
		 */
		$wp_customize->add_setting(
			'ofc_callout_button_target',
			array(
				'default'           => 'blank',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'oceanwp_sanitize_select',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ofc_callout_button_target',
				array(
					'label'    => esc_html__( 'Button Target', 'ocean-footer-callout' ),
					'section'  => 'ofc_section',
					'settings' => 'ofc_callout_button_target',
					'type'     => 'select',
					'choices'  => array(
						'blank' => esc_html__( 'Blank', 'ocean-footer-callout' ),
						'self'  => esc_html__( 'Self', 'ocean-footer-callout' ),
					),
					'priority' => 10,
				)
			)
		);

		/**
		 * Callout button rel
		 */
		$wp_customize->add_setting(
			'ofc_callout_button_rel',
			array(
				'default'           => '',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'oceanwp_sanitize_select',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ofc_callout_button_rel',
				array(
					'label'    => esc_html__( 'Button Rel', 'ocean-footer-callout' ),
					'section'  => 'ofc_section',
					'settings' => 'ofc_callout_button_rel',
					'type'     => 'select',
					'choices'  => array(
						''           => esc_html__( 'None', 'ocean-footer-callout' ),
						'nofollow'   => esc_html__( 'Nofollow', 'ocean-footer-callout' ),
						'noopnoref'  => esc_html__( 'Noopener Noreferrer', 'ocean-footer-callout' ),
						'nofnopnorr' => esc_html__( 'Nofollow Noopener Noreferrer', 'ocean-footer-callout' ),
					),
					'priority' => 10,
				)
			)
		);

		/**
		 * Callout button custom classes
		 */
		$wp_customize->add_setting(
			'ofc_callout_button_classes',
			array(
				'sanitize_callback' => 'wp_filter_nohtml_kses',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'ofc_callout_button_classes',
				array(
					'label'    => esc_html__( 'Button Custom Classes', 'ocean-footer-callout' ),
					'section'  => 'ofc_section',
					'settings' => 'ofc_callout_button_classes',
					'type'     => 'text',
					'priority' => 10,
				)
			)
		);

		/**
		 * Callout button Typography
		 */
		$wp_customize->add_setting(
			'ofc_callout_button_typo_font_family',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_setting(
			'ofc_callout_button_typo_font_size',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_setting(
			'ofc_callout_button_typo_font_weight',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_key',
			)
		);
		$wp_customize->add_setting(
			'ofc_callout_button_typo_font_style',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_key',
			)
		);
		$wp_customize->add_setting(
			'ofc_callout_button_typo_transform',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_key',
			)
		);
		$wp_customize->add_setting(
			'ofc_callout_button_typo_line_height',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_setting(
			'ofc_callout_button_typo_spacing',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Typo_Control(
				$wp_customize,
				'ofc_callout_button_typo',
				array(
					'label'    => esc_html__( 'Typography', 'ocean-footer-callout' ),
					'section'  => 'ofc_section',
					'settings' => array(
						'family'      => 'ofc_callout_button_typo_font_family',
						'size'        => 'ofc_callout_button_typo_font_size',
						'weight'      => 'ofc_callout_button_typo_font_weight',
						'style'       => 'ofc_callout_button_typo_font_style',
						'transform'   => 'ofc_callout_button_typo_transform',
						'line_height' => 'ofc_callout_button_typo_line_height',
						'spacing'     => 'ofc_callout_button_typo_spacing',
					),
					'priority' => 10,
					'l10n'     => array(),
				)
			)
		);

		/**
		 * Callout styling
		 */
		$wp_customize->add_setting(
			'ofc_callout_styling_heading',
			array(
				'sanitize_callback' => 'wp_kses',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Heading_Control(
				$wp_customize,
				'ofc_callout_styling_heading',
				array(
					'label'    => esc_html__( 'Styling', 'ocean' ),
					'section'  => 'ofc_section',
					'priority' => 10,
				)
			)
		);

		/**
		 * Callout padding
		 */
		$wp_customize->add_setting(
			'ofc_callout_top_padding',
			array(
				'transport'         => 'postMessage',
				'default'           => '30',
				'sanitize_callback' => 'oceanwp_sanitize_number',
			)
		);
		$wp_customize->add_setting(
			'ofc_callout_bottom_padding',
			array(
				'transport'         => 'postMessage',
				'default'           => '30',
				'sanitize_callback' => 'oceanwp_sanitize_number',
			)
		);

		$wp_customize->add_setting(
			'ofc_callout_tablet_top_padding',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'oceanwp_sanitize_number_blank',
			)
		);
		$wp_customize->add_setting(
			'ofc_callout_tablet_bottom_padding',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'oceanwp_sanitize_number_blank',
			)
		);

		$wp_customize->add_setting(
			'ofc_callout_mobile_top_padding',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'oceanwp_sanitize_number_blank',
			)
		);
		$wp_customize->add_setting(
			'ofc_callout_mobile_bottom_padding',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'oceanwp_sanitize_number_blank',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Dimensions_Control(
				$wp_customize,
				'ofc_callout_padding',
				array(
					'label'       => esc_html__( 'Padding (px)', 'oceanwp' ),
					'section'     => 'ofc_section',
					'settings'    => array(
						'desktop_top'    => 'ofc_callout_top_padding',
						'desktop_bottom' => 'ofc_callout_bottom_padding',
						'tablet_top'     => 'ofc_callout_tablet_top_padding',
						'tablet_bottom'  => 'ofc_callout_tablet_bottom_padding',
						'mobile_top'     => 'ofc_callout_mobile_top_padding',
						'mobile_bottom'  => 'ofc_callout_mobile_bottom_padding',
					),
					'priority'    => 10,
					'input_attrs' => array(
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					),
				)
			)
		);

		/**
		 * Callout background
		 */
		$wp_customize->add_setting(
			'ofc_callout_bg',
			array(
				'default'           => '#1b1b1b',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'oceanwp_sanitize_color',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Color_Control(
				$wp_customize,
				'ofc_callout_bg',
				array(
					'label'    => esc_html__( 'Background', 'ocean-footer-callout' ),
					'section'  => 'ofc_section',
					'settings' => 'ofc_callout_bg',
					'priority' => 10,
				)
			)
		);

		/**
		 * Callout border color
		 */
		$wp_customize->add_setting(
			'ofc_callout_border',
			array(
				'default'           => '#1b1b1b',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'oceanwp_sanitize_color',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Color_Control(
				$wp_customize,
				'ofc_callout_border',
				array(
					'label'    => esc_html__( 'Border Color', 'ocean-footer-callout' ),
					'section'  => 'ofc_section',
					'settings' => 'ofc_callout_border',
					'priority' => 10,
				)
			)
		);

		/**
		 * Callout color
		 */
		$wp_customize->add_setting(
			'ofc_callout_color',
			array(
				'default'           => '#dddddd',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'oceanwp_sanitize_color',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Color_Control(
				$wp_customize,
				'ofc_callout_color',
				array(
					'label'    => esc_html__( 'Text Color', 'ocean-footer-callout' ),
					'section'  => 'ofc_section',
					'settings' => 'ofc_callout_color',
					'priority' => 10,
				)
			)
		);

		/**
		 * Callout links color
		 */
		$wp_customize->add_setting(
			'ofc_callout_links_color',
			array(
				'default'           => '#ffffff',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'oceanwp_sanitize_color',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Color_Control(
				$wp_customize,
				'ofc_callout_links_color',
				array(
					'label'    => esc_html__( 'Links', 'ocean-footer-callout' ),
					'section'  => 'ofc_section',
					'settings' => 'ofc_callout_links_color',
					'priority' => 10,
				)
			)
		);

		/**
		 * Callout links color hover
		 */
		$wp_customize->add_setting(
			'ofc_callout_links_color_hover',
			array(
				'default'           => '#13aff0',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'oceanwp_sanitize_color',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Color_Control(
				$wp_customize,
				'ofc_callout_links_color_hover',
				array(
					'label'    => esc_html__( 'Links: Hover', 'ocean-footer-callout' ),
					'section'  => 'ofc_section',
					'settings' => 'ofc_callout_links_color_hover',
					'priority' => 10,
				)
			)
		);

		/**
		 * Callout button border radius
		 */
		$wp_customize->add_setting(
			'ofc_callout_button_border_radius',
			array(
				'default'           => '30',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'oceanwp_sanitize_number',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Range_Control(
				$wp_customize,
				'ofc_callout_button_border_radius',
				array(
					'label'    => esc_html__( 'Button Border Radius (px)', 'ocean-footer-callout' ),
					'section'  => 'ofc_section',
					'settings' => 'ofc_callout_button_border_radius',
					'priority' => 10,
				)
			)
		);

		/**
		 * Callout button background
		 */
		$wp_customize->add_setting(
			'ofc_callout_button_bg',
			array(
				'default'           => '#13aff0',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'oceanwp_sanitize_color',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Color_Control(
				$wp_customize,
				'ofc_callout_button_bg',
				array(
					'label'    => esc_html__( 'Button Background', 'ocean-footer-callout' ),
					'section'  => 'ofc_section',
					'settings' => 'ofc_callout_button_bg',
					'priority' => 10,
				)
			)
		);

		/**
		 * Callout button color
		 */
		$wp_customize->add_setting(
			'ofc_callout_button_color',
			array(
				'default'           => '#ffffff',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'oceanwp_sanitize_color',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Color_Control(
				$wp_customize,
				'ofc_callout_button_color',
				array(
					'label'    => esc_html__( 'Button Color', 'ocean-footer-callout' ),
					'section'  => 'ofc_section',
					'settings' => 'ofc_callout_button_color',
					'priority' => 10,
				)
			)
		);

		/**
		 * Callout button hover background
		 */
		$wp_customize->add_setting(
			'ofc_callout_button_hover_bg',
			array(
				'default'           => '#0b7cac',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'oceanwp_sanitize_color',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Color_Control(
				$wp_customize,
				'ofc_callout_button_hover_bg',
				array(
					'label'    => esc_html__( 'Button: Hover Background', 'ocean-footer-callout' ),
					'section'  => 'ofc_section',
					'settings' => 'ofc_callout_button_hover_bg',
					'priority' => 10,
				)
			)
		);

		/**
		 * Callout button hover color
		 */
		$wp_customize->add_setting(
			'ofc_callout_button_hover_color',
			array(
				'default'           => '#ffffff',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'oceanwp_sanitize_color',
			)
		);

		$wp_customize->add_control(
			new OceanWP_Customizer_Color_Control(
				$wp_customize,
				'ofc_callout_button_hover_color',
				array(
					'label'    => esc_html__( 'Button: Hover Color', 'ocean-footer-callout' ),
					'section'  => 'ofc_section',
					'settings' => 'ofc_callout_button_hover_color',
					'priority' => 10,
				)
			)
		);
	}

	/**
	 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
	 */
	public function customize_preview_js() {
		wp_enqueue_script( 'ofc-customizer', plugins_url( '/assets/js/customizer.min.js', __FILE__ ), array( 'customize-preview' ), '1.0', true );
		wp_localize_script(
			'ofc-customizer',
			'ofc_callout',
			array(
				'googleFontsUrl'    => '//fonts.googleapis.com',
				'googleFontsWeight' => '100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i',
			)
		);
	}

	/**
	 * Enqueue scripts.
	 */
	public function scripts() {

		// Load main stylesheet
		wp_enqueue_style( 'ofc-style', plugins_url( '/assets/css/style.min.css', __FILE__ ) );

		// If rtl
		if ( is_RTL() ) {
			wp_enqueue_style( 'ofc-style-rtl', plugins_url( '/assets/css/rtl.css', __FILE__ ) );
		}

		// Callout font
		$settings = array(
			'ofc_callout_text_typo_font_family',
			'ofc_callout_button_typo_font_family',
		);

		foreach ( $settings as $setting ) {

			// Get fonts
			$fonts = array();
			$val   = get_theme_mod( $setting );

			// If there is a value lets do something
			if ( ! empty( $val ) ) {

				// Sanitize
				$val = str_replace( '"', '', $val );

				$fonts[] = $val;

			}

			// Loop through and enqueue fonts
			if ( ! empty( $fonts ) && is_array( $fonts ) ) {
				foreach ( $fonts as $font ) {
					oceanwp_enqueue_google_font( $font );
				}
			}
		}

	}

	/**
	 * Add new tab in metabox.
	 */
	public static function new_tab( $butterbean, $post_type ) {

		// Gets the manager object we want to add sections to.
		$manager = $butterbean->get_manager( 'oceanwp_mb_settings' );

		$manager->register_section(
			'oceanwp_mb_callout',
			array(
				'label' => esc_html__( 'Callout', 'ocean-footer-callout' ),
				'icon'  => 'dashicons-format-aside',
			)
		);

		$manager->register_control(
			'ofc_meta_disable_footer_callout', // Same as setting name.
			array(
				'section'     => 'oceanwp_mb_callout',
				'type'        => 'buttonset',
				'label'       => esc_html__( 'Display Callout', 'ocean-footer-callout' ),
				'description' => esc_html__( 'Enable or disable the footer callout.', 'ocean-footer-callout' ),
				'choices'     => array(
					''       => esc_html__( 'Default', 'ocean-footer-callout' ),
					'enable' => esc_html__( 'Enable', 'ocean-footer-callout' ),
					'on'     => esc_html__( 'Disable', 'ocean-footer-callout' ),
				),
			)
		);

		$manager->register_setting(
			'ofc_meta_disable_footer_callout', // Same as control name.
			array(
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$manager->register_control(
			'ofc_meta_callout_button_url', // Same as setting name.
			array(
				'section'     => 'oceanwp_mb_callout',
				'type'        => 'text',
				'label'       => esc_html__( 'Callout Button Url', 'ocean-footer-callout' ),
				'description' => esc_html__( 'Enter a valid link.', 'ocean-footer-callout' ),
			)
		);

		$manager->register_setting(
			'ofc_meta_callout_button_url', // Same as control name.
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$manager->register_control(
			'ofc_meta_callout_button_txt', // Same as setting name.
			array(
				'section'     => 'oceanwp_mb_callout',
				'type'        => 'text',
				'label'       => esc_html__( 'Callout Button Text', 'ocean-footer-callout' ),
				'description' => esc_html__( 'Enter your text.', 'ocean-footer-callout' ),
			)
		);

		$manager->register_setting(
			'ofc_meta_callout_button_txt', // Same as control name.
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$manager->register_control(
			'ofc_meta_callout_text', // Same as setting name.
			array(
				'section'     => 'oceanwp_mb_callout',
				'type'        => 'editor',
				'label'       => esc_html__( 'Callout Text', 'ocean-footer-callout' ),
				'description' => esc_html__( 'Override the default callout text.', 'ocean-footer-callout' ),
			)
		);

		$manager->register_setting(
			'ofc_meta_callout_text', // Same as control name.
			array(
				'sanitize_callback' => 'wp_kses_post',
			)
		);

	}

	/**
	 * Display the footer callout.
	 */
	public function display_footer_callout() {

		// Return true by default
		$return = true;

		// Return false if disabled
		if ( 'on' == get_post_meta( get_the_ID(), 'ofc_meta_disable_footer_callout', true ) ) {
			$return = false;
		}

		// Apply filters and return
		return apply_filters( 'ofc_display_footer_callout', $return );

	}

	/**
	 * Gets the footer callout template part.
	 */
	public function footer_callout() {

		// Return if disabled
		if ( ! self::display_footer_callout() ) {
			return;
		}

		$file       = $this->plugin_path . 'template/footer-callout.php';
		$theme_file = get_stylesheet_directory() . '/templates/extra/footer-callout.php';

		if ( file_exists( $theme_file ) ) {
			$file = $theme_file;
		}

		if ( file_exists( $file ) ) {
			include $file;
		}

	}

	/**
	 * Add css in head tag.
	 */
	public function head_css( $output ) {

		// Global vars
		$top_padding           = get_theme_mod( 'ofc_callout_top_padding', '30' );
		$bottom_padding        = get_theme_mod( 'ofc_callout_bottom_padding', '30' );
		$tablet_top_padding    = get_theme_mod( 'ofc_callout_tablet_top_padding' );
		$tablet_bottom_padding = get_theme_mod( 'ofc_callout_tablet_bottom_padding' );
		$mobile_top_padding    = get_theme_mod( 'ofc_callout_mobile_top_padding' );
		$mobile_bottom_padding = get_theme_mod( 'ofc_callout_mobile_bottom_padding' );
		$background            = get_theme_mod( 'ofc_callout_bg', '#1B1B1B' );
		$border                = get_theme_mod( 'ofc_callout_border', '#1B1B1B' );
		$color                 = get_theme_mod( 'ofc_callout_color', '#dddddd' );
		$links                 = get_theme_mod( 'ofc_callout_links_color', '#ffffff' );
		$links_hover           = get_theme_mod( 'ofc_callout_links_color_hover', '#13aff0' );
		$button_border_radius  = get_theme_mod( 'ofc_callout_button_border_radius', '30' );
		$button_bg             = get_theme_mod( 'ofc_callout_button_bg', '#13aff0' );
		$button_color          = get_theme_mod( 'ofc_callout_button_color', '#ffffff' );
		$button_hover_bg       = get_theme_mod( 'ofc_callout_button_hover_bg', '#0b7cac' );
		$button_hover_color    = get_theme_mod( 'ofc_callout_button_hover_color', '#ffffff' );

		// Text typography
		$text_font_family    = get_theme_mod( 'ofc_callout_text_typo_font_family' );
		$text_font_size      = get_theme_mod( 'ofc_callout_text_typo_font_size' );
		$text_font_weight    = get_theme_mod( 'ofc_callout_text_typo_font_weight' );
		$text_font_style     = get_theme_mod( 'ofc_callout_text_typo_font_style' );
		$text_text_transform = get_theme_mod( 'ofc_callout_text_typo_transform' );
		$text_line_height    = get_theme_mod( 'ofc_callout_text_typo_line_height' );
		$text_letter_spacing = get_theme_mod( 'ofc_callout_text_typo_spacing' );

		// Button typography
		$button_font_family    = get_theme_mod( 'ofc_callout_button_typo_font_family' );
		$button_font_size      = get_theme_mod( 'ofc_callout_button_typo_font_size' );
		$button_font_weight    = get_theme_mod( 'ofc_callout_button_typo_font_weight' );
		$button_font_style     = get_theme_mod( 'ofc_callout_button_typo_font_style' );
		$button_text_transform = get_theme_mod( 'ofc_callout_button_typo_transform' );
		$button_line_height    = get_theme_mod( 'ofc_callout_button_typo_line_height' );
		$button_letter_spacing = get_theme_mod( 'ofc_callout_button_typo_spacing' );

		// Define css var
		$css             = '';
		$text_typo_css   = '';
		$button_typo_css = '';

		// CSS if boxed style
		$boxed_style      = get_theme_mod( 'ocean_main_layout_style', 'wide' );
		$boxed_width      = get_theme_mod( 'ocean_boxed_width', '1280' );
		$half_boxed_width = $boxed_width / 2;
		if ( 'boxed' == $boxed_style ) {
			$css .= 'body.has-parallax-footer #footer-callout-wrap {width:' . $boxed_width . 'px;left:50%;margin-left:-' . $half_boxed_width . 'px}';
		}

		// Padding
		if ( isset( $top_padding ) && '30' != $top_padding && '' != $top_padding
			|| isset( $bottom_padding ) && '30' != $bottom_padding && '' != $bottom_padding ) {
			$css .= '#footer-callout-wrap{padding:' . oceanwp_spacing_css( $top_padding, '', $bottom_padding, '' ) . '}';
		}

		// Tablet padding
		if ( isset( $tablet_top_padding ) && '' != $tablet_top_padding
			|| isset( $tablet_bottom_padding ) && '' != $tablet_bottom_padding ) {
			$css .= '@media (max-width: 768px){#footer-callout-wrap{padding:' . oceanwp_spacing_css( $tablet_top_padding, '', $tablet_bottom_padding, '' ) . '}}';
		}

		// Mobile padding
		if ( isset( $mobile_top_padding ) && '' != $mobile_top_padding
			|| isset( $mobile_bottom_padding ) && '' != $mobile_bottom_padding ) {
			$css .= '@media (max-width: 480px){#footer-callout-wrap{padding:' . oceanwp_spacing_css( $mobile_top_padding, '', $mobile_bottom_padding, '' ) . '}}';
		}

		// Add background
		if ( ! empty( $background ) && '#1B1B1B' != $background ) {
			$css .= '#footer-callout-wrap{background-color:' . $background . ';}';
		}

		// Add border
		if ( ! empty( $border ) && '#1B1B1B' != $border ) {
			$css .= '#footer-callout-wrap{border-color:' . $border . ';}';
		}

		// Add color
		if ( ! empty( $color ) && '#dddddd' != $color ) {
			$css .= '#footer-callout-wrap{color:' . $color . ';}';
		}

		// Add links
		if ( ! empty( $links ) && '#ffffff' != $links ) {
			$css .= '.footer-callout-content a{color:' . $links . ';}';
		}

		// Add links hover
		if ( ! empty( $links_hover ) && '#13aff0' != $links_hover ) {
			$css .= '.footer-callout-content a:hover{color:' . $links_hover . ';}';
		}

		// Add button border radius
		if ( ! empty( $button_border_radius ) && '30' != $button_border_radius ) {
			$css .= '#footer-callout .callout-button{border-radius:' . $button_border_radius . 'px;}';
		}

		// Add button background
		if ( ! empty( $button_bg ) && '#13aff0' != $button_bg ) {
			$css .= '#footer-callout .callout-button{background-color:' . $button_bg . ';}';
		}

		// Add button color
		if ( ! empty( $button_color ) && '#ffffff' != $button_color ) {
			$css .= '#footer-callout .callout-button{color:' . $button_color . ';}';
		}

		// Add button hover background
		if ( ! empty( $button_hover_bg ) && '#0b7cac' != $button_hover_bg ) {
			$css .= '#footer-callout .callout-button:hover{background-color:' . $button_hover_bg . ';}';
		}

		// Add button hover color
		if ( ! empty( $button_hover_color ) && '#ffffff' != $button_hover_color ) {
			$css .= '#footer-callout .callout-button:hover{color:' . $button_hover_color . ';}';
		}

		// Add text font family
		if ( ! empty( $text_font_family ) ) {
			$text_typo_css .= 'font-family:' . $text_font_family . ';';
		}

		// Add text font size
		if ( ! empty( $text_font_size ) ) {
			$text_typo_css .= 'font-size:' . $text_font_size . ';';
		}

		// Add text font weight
		if ( ! empty( $text_font_weight ) ) {
			$text_typo_css .= 'font-weight:' . $text_font_weight . ';';
		}

		// Add text font style
		if ( ! empty( $text_font_style ) ) {
			$text_typo_css .= 'font-style:' . $text_font_style . ';';
		}

		// Add text text transform
		if ( ! empty( $text_text_transform ) ) {
			$text_typo_css .= 'text-transform:' . $text_text_transform . ';';
		}

		// Add text line height
		if ( ! empty( $text_line_height ) ) {
			$text_typo_css .= 'line-height:' . $text_line_height . ';';
		}

		// Add text letter spacing
		if ( ! empty( $text_letter_spacing ) ) {
			$text_typo_css .= 'letter-spacing:' . $text_letter_spacing . ';';
		}

		// text typography css
		if ( ! empty( $text_typo_css ) ) {
			$css .= '#footer-callout .footer-callout-content{' . $text_typo_css . '}';
		}

		// Add button font family
		if ( ! empty( $button_font_family ) ) {
			$button_typo_css .= 'font-family:' . $button_font_family . ';';
		}

		// Add button font size
		if ( ! empty( $button_font_size ) ) {
			$button_typo_css .= 'font-size:' . $button_font_size . ';';
		}

		// Add button font weight
		if ( ! empty( $button_font_weight ) ) {
			$button_typo_css .= 'font-weight:' . $button_font_weight . ';';
		}

		// Add button font style
		if ( ! empty( $button_font_style ) ) {
			$button_typo_css .= 'font-style:' . $button_font_style . ';';
		}

		// Add button text transform
		if ( ! empty( $button_text_transform ) ) {
			$button_typo_css .= 'text-transform:' . $button_text_transform . ';';
		}

		// Add button line height
		if ( ! empty( $button_line_height ) ) {
			$button_typo_css .= 'line-height:' . $button_line_height . ';';
		}

		// Add button letter spacing
		if ( ! empty( $button_letter_spacing ) ) {
			$button_typo_css .= 'letter-spacing:' . $button_letter_spacing . ';';
		}

		// button typography css
		if ( ! empty( $button_typo_css ) ) {
			$css .= '#footer-callout .callout-button{' . $button_typo_css . '}';
		}

		// Return CSS
		if ( ! empty( $css ) ) {
			$output .= '/* Footer Callout CSS */' . $css;
		}

		// Return output css
		return $output;

	}

} // End Class

// --------------------------------------------------------------------------------
// region Freemius
// --------------------------------------------------------------------------------

if ( ! function_exists( 'ocean_footer_callout_fs' ) ) {
	// Create a helper function for easy SDK access.
	function ocean_footer_callout_fs() {
		global $ocean_footer_callout_fs;

		if ( ! isset( $ocean_footer_callout_fs ) ) {
			$ocean_footer_callout_fs = OceanWP_EDD_Addon_Migration::instance( 'ocean_footer_callout_fs' )->init_sdk(
				array(
					'id'         => '3754',
					'slug'       => 'ocean-footer-callout',
					'public_key' => 'pk_c3ff094ed1cbaf287c6f833d3ba09',
				)
			);

			if ( $ocean_footer_callout_fs->can_use_premium_code__premium_only() ) {
				Ocean_Footer_Callout::instance()->init();
			}
		}

		return $ocean_footer_callout_fs;
	}

	function ocean_footer_callout_fs_addon_init() {
		if ( class_exists( 'Ocean_Extra' ) ) {
			OceanWP_EDD_Addon_Migration::instance( 'ocean_footer_callout_fs' )->init();
		}
	}

	if ( 0 == did_action( 'owp_fs_loaded' ) ) {
		// Init add-on only after parent theme was loaded.
		add_action( 'owp_fs_loaded', 'ocean_footer_callout_fs_addon_init', 15 );
	} else {
		if ( class_exists( 'Ocean_Extra' ) ) {
			/**
			 * This makes sure that if the theme was already loaded
			 * before the plugin, it will run Freemius right away.
			 *
			 * This is crucial for the plugin's activation hook.
			 */
			ocean_footer_callout_fs_addon_init();
		}
	}

	function ocean_footer_callout_fs_try_migrate() {
		OceanWP_EDD_Addon_Migration::instance( 'ocean_footer_callout_fs' )->try_migrate_addon(
			'343',
			'Ocean_Footer_Callout',
			'Footer Callout'
		);
	}
}

// endregion
