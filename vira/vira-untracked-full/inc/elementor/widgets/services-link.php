<?php
class services_link extends \Elementor\Widget_Base {

	public function get_name() {
		return 'services_links';
	}

	public function get_title() {
		return __( 'سرویس پیوندی', 'prk' );
	}

	public function get_icon() {
		return 'eicon-external-link-square';
	}

	public function get_categories() {
		return [ 'prk-category' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'آیتم های پیوندی', 'prk' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'description' => 'این سکشن ها فقط در نسخه دسکتاپ نمایش داده میشوند !',
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'list_title',
			[
				'label' => esc_html__( 'عنوان آیتم', 'prk' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'آیتم جدید', 'prk' ),
			]
		);

		$repeater->add_control(
			'list_icon',
			[
				'label' => esc_html__( 'آیکن آیتم', 'prk' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default' => 'ri-restart-line',
				'description' => wp_kses_post( 'دریافت آیکن از سایت <a href="https://remixicon.com/" target="_blank" rel="noopener">Remixicon</a>' ),
			]
		);

		$repeater->add_control(
			'list_url',
			[
				'label' => esc_html__( 'لینک آیتم', 'prk' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '#',
			]
		);
		$repeater->add_control(
		'list_icon_color',
		[
			'label' => esc_html__( 'رنگ آیکن', 'prk' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'default' => '#fff',
		]
		);

		$this->add_control(
			'list_article',
			[
				'label' => esc_html__( 'لیست آیتم‌ها', 'prk' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
				[
					'list_title' => 'گردونه شانس',
					'list_icon'  => 'ri-restart-line',
					'list_url'   => '#',
				],
				[
					'list_title' => 'ماموریت ها',
					'list_icon'  => 'ri-rocket-line',
					'list_url'   => '#',
				],
				[
					'list_title' => 'جایزه',
					'list_icon'  => 'ri-gift-line',
					'list_url'   => '#',
				],
				],
				'title_field' => '{{{ list_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'settings_section',
			[
				'label' => esc_html__( 'پیکربندی آیتم', 'prk' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'list_backer',
			[
				'label' => esc_html__( 'رنگ پس‌زمینه سکشن', 'prk' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .services_links' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'border_carousel',
			[
				'label' => esc_html__( 'انحنای گوشه‌ها', 'prk' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '11px',
				'selectors' => [
					'{{WRAPPER}} .services_links' => 'border-radius: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$list_article = isset($settings['list_article']) && is_array($settings['list_article']) ? $settings['list_article'] : [];

		// اگر رنگ پس‌زمینه تنظیم شده بود، کلاس over را به همه آیتم‌ها بده (گلوبال، نه per-item)
		$has_over = !empty($settings['list_backer']);

		if (empty($list_article)) {
			return;
		}
		?>
		<div class="services_links">
			<?php foreach ($list_article as $item): 
				$item_id = isset($item['_id']) ? $item['_id'] : '';
				$icon    = isset($item['list_icon']) && $item['list_icon'] !== '' ? $item['list_icon'] : 'ri-restart-line';
				$title   = isset($item['list_title']) ? $item['list_title'] : '';
				$url     = isset($item['list_url']) && $item['list_url'] !== '' ? $item['list_url'] : '#';

				$classes = 'services_item noselect elementor-repeater-item-' . $item_id;
				if ( $has_over ) {
					$classes .= ' over';
				}
				?>
				<article class="<?php echo esc_attr($classes); ?>">
					<a href="<?php echo esc_url($url); ?>">
			        <i class="<?php echo esc_attr($icon); ?>" style="color: <?php echo esc_attr($item['list_icon_color'] ?? '#333'); ?>;"></i>
			        <h4><?php echo esc_html($title); ?></h4>
					</a>
				</article>
			<?php endforeach; ?>
		</div>
		<?php
	}
}
