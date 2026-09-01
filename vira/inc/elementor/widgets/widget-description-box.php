<?php
class news_description_box extends \Elementor\Widget_Base {


	public function get_name() {
		return 'description-box';
	}

	public function get_title() {
		return 'باکس نوشته - prk';
	}

	public function get_icon() {
		return 'eicon-flip-box';
	}

	public function get_categories() {
		return [ 'prk-category' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'text',
			[
				'label' => 'باکس نوشته',
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title_section',
			[
				'label' => esc_html__( 'متن باکس', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 10,
				'default' => esc_html__( 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.', 'textdomain' ),
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
	$settings = $this->get_settings_for_display();

	?>

		<div class="footer-description-shop">
          <div class="term-description readmore_box">
            
			<p>
				<?php echo $settings['title_section'];?>
			</p>

		  </div>


		    <a href="#" class="mask-handler"><span class="show-more">نمایش بیشتر</span><span class="show-less">- بستن</span></a>
		</div>

	<?php
	}

	protected function _content_template() {}

}
