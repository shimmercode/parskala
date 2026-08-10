<!-- مدال انتخاب موقعیت مکانی-->
<div id="tekecablSearchcityModal"
  class="citycategorychoosemodal remodal remodal-maxed view_product remodal-md filter-location"
   data-remodal-id="location-piker"
    data-remodal-options="hashTracking: false">

  <div class="filter-location-header flexd">
      <span class="title-feed"><?= prk_option('prk_filter_location_pop_title');?></span>
      <span aria-hidden="true" class='delallcities'>حذف همه</span>
      <!-- <button data-remodal-action="close" class="remodal-close"></button> -->
  </div>

  <div class='topp-part-modal-body'>

  	<?php
      $search_placeholder_filter = prk_option('prk_filter_location_search_title') ? prk_option('prk_filter_location_search_title') : 'جستجو در شهرها';
      echo '<div class="selected-cities">';
        if(isset($_COOKIE['prskalaSearchCity'])){
      	$city =  $_COOKIE['prskalaSearchCity'];
      	$city_categories = explode(',', $city);
        	//var_dump($city_categories);
        	if( ! empty($city_categories) ){
        		foreach ($city_categories as $city) {
        			echo "<div data-id=\"" . $city . "\" class=\"selectedcty\" id=\"selectedcty" . $city . "\">" . get_term_by('id', $city, 'city_categories')->name . "<i class=\"ri-close-line\" ></i></div>";
        		}
        	}
        }
      echo '</div>';


  	?>

  </div>
  <div class="flex-location location">

    <div class='searchpartdiv'>
        <i class='prk-search-normal-1'></i><input placeholder='<?php echo $search_placeholder_filter;?>' type='text' autocomplete="off" class='searchcity-input'/>
    </div>

  </div>

  <div id="checkbox-container" class="citieslists">

     <?php
      $cities = get_terms('city_categories', array('hide_empty' => 0, 'parent' => 0));

      foreach ($cities as $city) {

      echo "<div class='location-item'><div class='city' id='" . $city->term_id . "'><span>" . $city->name;
          echo "</span><i class=\"ri-arrow-left-s-line\" aria-hidden=\"true\"></i>";
      echo "</div></div>";
      }
    ?>

  </div>

  <div class="remodal-footer flexd">

    <button type="button" data-remodal-action="close" class="btn btn-primary button_border">انصراف</button>
    <button type="button" class="btn btn-primary taeedcityloactionmodalsetcookie button_bodner">تایید</button>


  </div>

</div>
