<?php

class swip_article_products extends \Elementor\Widget_Base {

	public function get_name() { return 'article_products'; }
	public function get_title() { return __( 'اسلایدر تکی محصول', 'prk' ); }
	public function get_icon() { return 'eicon-checkout'; }
	public function get_categories() { return [ 'prk-category' ]; }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'اسلاید ها', 'prk' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control('list_title', [
			'label'   => esc_html__( 'عنوان اسلایدر', 'prk' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => esc_html__( 'هندزفری مدل ایرپاد پرو Anc', 'prk' ),
		]);

		$repeater->add_control('list_url', [
			'label'   => esc_html__( 'لینک اسلایدر', 'prk' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => '#',
		]);

		$repeater->add_control('list_orginal', [
			'label'        => esc_html__( 'محصول اصل (نمایش لیبل غیر اصل)', 'prk' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		]);

		$repeater->add_control('list_color', [
			'label'     => esc_html__( 'رنگ اسلایدر', 'prk' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#2FE382',
			'selectors' => [
				'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}}',
			],
		]);

		$repeater->add_control('bg_back1', [
			'label'     => esc_html__( 'تصویر پترن پس‌زمینه', 'prk' ),
			'type'      => \Elementor\Controls_Manager::MEDIA,
			'selectors' => [
				'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-image: url({{url}})',
			],
		]);

		$img_carousel = get_parent_theme_file_uri('/assets/img/article_product.png');
		$repeater->add_control('list_img', [
			'label'   => esc_html__( 'تصویر اسلایدر', 'prk' ),
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => [ 'url' => $img_carousel ],
		]);

		// ---- لیبل‌های متنی "پر آیتم" ----
		$repeater->add_control('item_label_non_original', [
			'label'   => esc_html__( 'لیبل «غیر اصل»', 'prk' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'غیر اصــل',
		]);

		$repeater->add_control('item_label_view_all', [
			'label'   => esc_html__( 'لیبل «مشاهده همه»', 'prk' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'مشاهده همه',
		]);

		$repeater->add_control('item_label_view_product', [
			'label'   => esc_html__( 'لیبل «مشاهده محصول» (برای pagination)', 'prk' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'مشاهده محصول',
		]);
		// -----------------------------------

		$this->add_control('list_article', [
			'label'       => esc_html__( 'لیست اسلاید ها', 'prk' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => [
				[ 'list_title' => esc_html__( 'اسلایدر#جدید', 'prk' ) ],
			],
			'title_field' => '{{{ list_title }}}',
		]);

		$this->end_controls_section();

		$this->start_controls_section(
			'setting_sections',
			[
				'label' => esc_html__( 'پیکربندی اسلایدر ها', 'prk' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control('auto_played', [
			'label'        => esc_html__( 'پخش اتوماتیک', 'prk' ),
			'description'  => esc_html__( 'پخش اتوماتیک اسلایدها', 'prk' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		]);

		$this->add_control('border_carousel', [
			'label'     => esc_html__( 'انحنای دور سکشن', 'prk' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => '11px',
			'selectors' => [
				'{{WRAPPER}} .article_slider' => 'border-radius: {{VALUE}}',
			],
		]);

		$this->end_controls_section();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$list_article = isset($settings['list_article']) && is_array($settings['list_article']) ? $settings['list_article'] : [];
		$auto_played  = isset($settings['auto_played']) ? $settings['auto_played'] : '';

		if ( empty($list_article) ) { return; } ?>
		<div class="article_slider">
			<div class="swiper-article-slider">
				<div class="swiper-wrapper">
					<?php foreach ( $list_article as $item ) :
						$item_id   = isset($item['_id']) ? $item['_id'] : '';
						$title     = isset($item['list_title']) ? $item['list_title'] : '';
						$url       = !empty($item['list_url']) ? $item['list_url'] : '#';
						$img_url   = isset($item['list_img']['url']) ? $item['list_img']['url'] : '';
						$is_origin = !empty($item['list_orginal']); // 'yes' => truthy

						$lbl_non_original = !empty($item['item_label_non_original']) ? $item['item_label_non_original'] : 'غیر اصــل';
						$lbl_view_all     = !empty($item['item_label_view_all']) ? $item['item_label_view_all'] : 'مشاهده همه';
						$lbl_view_product = !empty($item['item_label_view_product']) ? $item['item_label_view_product'] : 'مشاهده محصول';
					?>
					<div class="swiper-slide article elementor-repeater-item-<?php echo esc_attr($item_id); ?>"
							 data-view-product-label="<?php echo esc_attr($lbl_view_product); ?>">
						<article class="article_item">
							<div class="thumb-off">
								<img class="t1 shower" src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($title ?: 'article-slider'); ?>">
							</div>

							<span class="article_backer"></span>

							<div class="article_orginal">
								<?php if ( $is_origin ) : ?>
									<span><?php echo esc_html($lbl_non_original); ?></span>
								<?php endif; ?>
							</div>

							<h4><?php echo esc_html($title); ?></h4>

							<a class="product-item-link" href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener">
								<?php echo esc_html($lbl_view_all); ?> <i class="ri-arrow-left-line" aria-hidden="true"></i>
							</a>
						</article>
					</div>
					<?php endforeach; ?>
				</div>

				<!-- متن pagination از اسلاید فعال با JS ست می‌شود -->
				<div class="swiper-pagination"></div>
			</div>
		</div>
		<script>
		jQuery(function($){
			var swiper = new Swiper('.swiper-article-slider', {
				pagination: {
					el: '.swiper-pagination',
					dynamicBullets: true,
					lazy: true
				},
				loop: true,
				loopedSlides: 2,
				<?php if ( $auto_played === 'yes' ) : ?>
				autoplay: {
					delay: 3500,
					disableOnInteraction: false
				},
				<?php endif; ?>
			});
		});
		</script>
		<?php
		// نکته: جاوااسکریپت را بیرون از <script> و در فایل جداگانه قرار بده (مطابق ترجیح شما).
		$autoplay_enabled = ($auto_played === 'yes') ? 'true' : 'false';
		// می‌تونی این دیتاها رو برای init در فایل JS استفاده کنی (data-attributes یا wp_localize_script).
		echo '<span class="prk-article-slider-config" data-autoplay="'.esc_attr($autoplay_enabled).'" hidden></span>';
	}
}
