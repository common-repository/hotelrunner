<?php

// HOTELRUNNER LANGUAGE FUNCTIONS
function hotelrunner_lang($hotelrunner_lang_symbol)
{
  if( get_option( 'hotelrunner_lang', '' ) == $hotelrunner_lang_symbol )
  {
    echo 'selected';
  }
}

function hotelrunner_lang_options( $hotelrunner_lang_symbol, $hotelrunner_lang_name )
{
  $hotelrunner_lang_name2 = esc_attr( $hotelrunner_lang_name );
  if( get_option( 'hotelrunner_lang', '' ) == $hotelrunner_lang_symbol )
  {
    echo '<option value="'.$hotelrunner_lang_symbol.'" selected>' . esc_attr( $hotelrunner_lang_name2 ) . '</option>';
  }
  else if( get_option( 'hotelrunner_widget_lang', '' ) == $hotelrunner_lang_symbol )
  {
    echo '<option value="'.$hotelrunner_lang_symbol.'" selected>' . esc_attr( $hotelrunner_lang_name2 ) . '</option>';
  }
  else
  {
    echo '<option value="'.$hotelrunner_lang_symbol.'">' . esc_attr( $hotelrunner_lang_name2 ) . '</option>';
  }
}
function hotelrunner_currency_options( $hotelrunner_currency_symbol, $hotelrunner_currency_name )
{
  $hotelrunner_currency_name2 = esc_attr( $hotelrunner_currency_name );
  if( get_option( 'hotelrunner_currency', '' ) == $hotelrunner_currency_symbol )
  {
    echo '<option value="'.$hotelrunner_currency_symbol.'" selected>' . esc_attr( $hotelrunner_currency_name2 ) . '</option>';
  }
  else if( get_option( 'hotelrunner_currency', '' ) == $hotelrunner_currency_symbol )
  {
    echo '<option value="'.$hotelrunner_currency_symbol.'" selected>' . esc_attr( $hotelrunner_currency_name2 ) . '</option>';
  }
  else
  {
    echo '<option value="'.$hotelrunner_currency_symbol.'">' . esc_attr( $hotelrunner_currency_name2 ) . '</option>';
  }
}

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

function load_widget( $is_shortcode, $bgcolor, $inputcolor, $textcolor, $layout, $drop, $lang, $propertycode, $target, $currency, $target_domain )
{
  if($is_shortcode) {
    $bgcolor_new    = $bgcolor;
    $inputcolor_new = $inputcolor;
    $textcolor_new  = $textcolor;
    $lang_new       = $lang;
    $hotelcode_new  = $propertycode;
    $layout_new     = $layout;
    $drop_new       = $drop;
    $target_new     = $target;
    $currency_new   = $currency;
    $target_domain_new = $target_domain;
  }
  else {
    $bgcolor_new    = '#'.$bgcolor;
    $inputcolor_new = '#'.$inputcolor;
    $textcolor_new  = '#'.$textcolor;
    $lang_new       = $lang;
    $hotelcode_new  = $propertycode;
    $layout_new     = $layout;
    $drop_new       = $drop;
    $target_new     = $target;
    $currency_new   = $currency;
    $target_domain_new = $target_domain;
  }

  $code = '
  <script>
  var root = document.documentElement;
  root.style.setProperty("--widget-color", "'.$bgcolor_new.'"); // set Main Color
  root.style.setProperty("--text-color", "'.$textcolor_new.'");		// set Text Color
  root.style.setProperty("--input-background", "'.$inputcolor_new.'");	// set Input Background Color
  var info_property = "'.$target_domain_new.'"; // property code
  var property_code = "'.$hotelcode_new.'";
  var lang_code = "'.$lang_new.'";  // language Symbol
  var hr_currency = "'.$currency_new.'";
  var widget_layout = "'.$layout_new.'"; // inline || square
  var hr_drop = "'.$drop_new.'"; // up || down
  var open_how = "'.$target_new.'";  // _self ||  _blank
  //TRANSLATIONS STARTS
  var hr_jsonURL="//"+ property_code +".hotelrunner.com/api/v1/bv3/infos/booking_widget.json?api_key=7518391247a27ce412d421ffe241c6ffd3f52e7c4b26e993&currency=USD&locale="+ lang_code +"&c_code=null";
  var hr_translations = {};
  window.onload = function loadHrJson() {
      hrQuery.getJSON(hr_jsonURL, function(data) {  //get translations
          var child_age_ranges = `${data.child_age_ranges}`;
          var age_list = [];
          for( var age_v1 = 0; age_v1< child_age_ranges.split(",").length; age_v1++){
              age_list[age_v1] = child_age_ranges.split(",")[age_v1];
          };
          for( var age_v2=0; age_v2<age_list.length; age_v2++){
              age_list[age_v2] = age_list[age_v2].split(".")[age_list[age_v2].split(".").length - 1];
          };
          var max_child_age = Math.max(...age_list); 	//child age max number
          hr_translations = {
              "max_adult_number": data.max_adult_number,
              "max_child_number": data.max_child_number,
              "max_child_age": max_child_age,
              "translate_add_room": data.translations.add_room,
              "translate_adult": data.translations.adult,
              "translate_adults": data.translations.adults,
              "translate_book_now": data.translations.book_now,
              "translate_child": data.translations.child,
              "translate_child_age": data.translations.child_age,
              "translate_children": data.translations.children,
              "translate_done": data.translations.done,
              "translate_remove": data.translations.remove,
              "translate_room": data.translations.room,
              "translate_rooms": data.translations.rooms_count.other,
              "translate_d": data.translations.date_translations.day_names,
              "translate_dabbr": data.translations.date_translations.abbr_day_names,
              "translate_dmin": data.translations.date_translations.abbr_day_names,
              "translate_m": data.translations.date_translations.month_names,
              "translate_mabbr": data.translations.date_translations.abbr_month_names,
              "translate_selected": data.translations.your_selection,
              "translate_night": data.translations.one_night,
              "translate_nights": data.translations.more_night,
              "translate_close": data.translations.close
          };
          if(hr_translations.translate_close == null){
              loadHrJson();
          }
          else{
              runHrWidget();
          }
      });
  };
  //TRANSLATIONS ENDS
  </script>
  <style>

  @media (min-width: 768px) {
    .datepicker {
      width: 200% !important;
    }
  }
  </style>
  <div id="hr_search_widget" style="z-index: 9999999 !important;  margin: auto;position: absolute;left: 0; right: 0;"></div>';
  return $code;
}

function hotelrunner_sanitize( $input )
{
  $replaces = array('@' => '', '½' => '', '#' => '', '$' => '', '€' => '', '₺' => '', '*' => '', '£' => '', ',' => '',
   '.' => '', "'" => '', '"' => '', '&' => '', '+' => '', '%' => '', '^' => '', '!' => '');
  $replaces_count = count( $replaces );
  $output = sanitize_text_field( $input );

  foreach ( $replaces as $key => $value )
  {
    $output = str_replace( $key, '', $output );
  }
  return $output;
}

?>
