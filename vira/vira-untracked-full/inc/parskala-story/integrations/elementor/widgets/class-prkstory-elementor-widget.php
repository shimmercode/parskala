<?php
/**
 * Elementor Widget.
 *
 * @package PRK_Story
 */

namespace Prkstory\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Prkstory_Elementor_Widget
 *
 * @package Prkstory\Widgets
 */
class Prkstory_Elementor_Widget extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function get_name() {
		return 'prkstory';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 * @since 1.2.0
	 *
	 * @access public
	 */
	public function get_title() {
		return esc_html__( 'استوری ساز', 'parskala' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 * @since 1.2.0
	 *
	 * @access public
	 */
	public function get_icon() {
		return 'eicon-instagram-post';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @return array Widget categories.
	 * @since 1.2.0
	 *
	 * @access public
	 */
	public function get_categories() {
		return array( 'prk-category' );
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.2.0
	 *
	 * @access protected
	 */
	protected function register_controls() { // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
		$this->start_controls_section(
			'box_section',
			array(
				'label' => esc_html__( 'Story Box', 'parskala' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'box',
			array(
				'label'   => esc_html__( 'Select Story Box', 'parskala' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 0,
				'description' => 'استوری انتخاب شده در صفحه اصلی نمایش داده میشود !',
				'options' => prkstory_helpers()->get_story_boxes( true ),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.2.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			?>
			<style>
			.prk-story-preview {
				background-color: #fdfdfd;
		    padding: 40px 35px;
		    color: #333;
		    border-radius: 8px;
		    position: relative;
		    overflow: hidden;
		    text-align: center;
		    border: 1px solid #e3e3e3;
			}


			.prk-story-preview .prk-story-shortcode {
				font-weight: 700;
				font-size: 18px;
				font-family: prk-font !important;
			}
			</style>
			<div class="prk-story-preview">
				<span class="prk-story-shortcode">
					<?php if ( empty( $settings['box'] ) ) : ?>
						<?php esc_html_e( 'Select a Story Box', 'parskala' ); ?>
					<?php else : ?>
						[prk-story id="<?php echo esc_html( $settings['box'] ); ?>"]
					<?php endif; ?>
				</span>
			</div>
			<?php
		} else {
			echo do_shortcode( '[prkstory id="' . $settings['box'] . '"]' );
		}
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.2.0
	 *
	 * @access protected
	 */
	protected function content_template() { // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
		?>
		<style>
			.prk-story-preview {
				background-color: #fdfdfd;
				padding: 40px 35px;
				color: #333;
				border-radius: 8px;
				position: relative;
				overflow: hidden;
				text-align: center;
			}


			.prk-story-preview .prk-story-shortcode {
				font-weight: 700;
				font-size: 18px;
				font-family: prk-font !important;
			}
		</style>
		<div class="prk-story-preview">
			<span class="prk-story-shortcode">
				<# if( settings.box * 1 !== 0 ) { #>
				[prk-story id="{{{ settings.box }}}"]
				<# } else { #>
				<?php esc_html_e( 'Select a Story Box', 'parskala' ); ?>
				<# } #>
			</span>
		</div>
		<?php
	}
}
