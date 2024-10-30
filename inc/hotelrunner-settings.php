<?php

require_once('hotelrunner-admin-functions.php');

/**
 * Add menu page.
 * @return [type] [description]
 */

function hotelrunner_menu_page()
{
    add_menu_page( esc_attr( 'HotelRunner Widget', HOTELRUNNER_TEXT_DOMAIN ), esc_attr( 'HotelRunner Widget', HOTELRUNNER_TEXT_DOMAIN ), 'manage_options', HOTELRUNNER_TEXT_DOMAIN, 'hotelrunner_menu_page_content', HOTELRUNNER_URL . '/assets/img/hotelrunner-icon3.png', 11 );
}
add_action( 'admin_menu', 'hotelrunner_menu_page' );

/**
 * Added page contents.
 * @return [type] [description]
 */
function hotelrunner_menu_page_content()
{
    ?>

    <?php

    $hotel_code  = stripslashes( get_option( 'hr-hotel_code',    'hr-template' ) );
    $w_layout    = stripslashes( get_option( 'hr-widget_layout', 'inline' ) );
    $hr_drop     = stripslashes( get_option( 'hr-drop',          'down' ) );
    $bgcolor     = stripslashes( get_option( 'hr-bgcolor',       '#f15f22' ) );
    $input_color = stripslashes( get_option( 'hr-inputcolor',   '#fff' ) );
    $textcolor     = stripslashes( get_option( 'hr-textcolor',       '#000' ) );
    $w_statu     = stripslashes( get_option( 'hr-widget_statu',  '' ) );
    $hrlang      = stripslashes( get_option( 'hotelrunner_lang', 'en-US' ) );
    $hr_target      = stripslashes( get_option( 'hotelrunner_target_link', '_blank' ) );
    $hr_currency      = stripslashes( get_option( 'hotelrunner_currency', 'USD' ) );
    $hotelrunner_target_domain = stripslashes( get_option( 'hotelrunner_target_domain', '' ) );

		?>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <div class="container-fluid">
      <div class="row">
        <div class="col-12 mt-3 px-0">
          <?php if( isset( $_POST['hr-submit'] ) )
          {
            if($_POST['drop'] == "down")
            {
              $hr_drop = "down";
            }
            else if($_POST['drop'] == "up")
            {
              $hr_drop = "up";
            }
            else{
              $hr_drop = "down";
            }

            if($_POST['widget_layout'] == "square")
            {
              $w_layout = "square";
            }
            else if($_POST['widget_layout'] == "inline"){
              $w_layout = "inline";
            }
            else{
              $w_layout = "inline";
            }

            if($_POST['widget_statu'])
            {
              $w_statu = true;
            }
            else{
              $w_statu = false;
            }

            $hotel_code = isset( $_POST['hotel_code'] ) ? wp_unslash( hotelrunner_sanitize($_POST['hotel_code']) ) : '';
            $bgcolor    = sanitize_hex_color( '#' . $_POST['bgcolor'] );
            $input_color    = sanitize_hex_color( '#' . $_POST['inputcolor'] );
            $textcolor    = sanitize_hex_color( '#' . $_POST['textcolor'] );
            $hrlang     = isset( $_POST['hotelrunner_lang'] ) ? wp_unslash( hotelrunner_sanitize($_POST['hotelrunner_lang']) ) : '';
            $hr_target = isset( $_POST['hotelrunner_target_link'] ) ? wp_unslash( hotelrunner_sanitize($_POST['hotelrunner_target_link']) ) : '';
            $hr_currency = isset( $_POST['hotelrunner_currency'] ) ? wp_unslash( hotelrunner_sanitize($_POST['hotelrunner_currency']) ) : '';
            $hotelrunner_target_domain = isset( $_POST['hotelrunner_target_domain'] ) ? wp_unslash( $_POST['hotelrunner_target_domain'] ) : '';

            update_option( 'hr-hotel_code', $hotel_code );
            update_option( 'hr-widget_layout', $w_layout );
            update_option( 'hr-drop', $hr_drop );
            update_option( 'hr-bgcolor', $bgcolor );
            update_option( 'hr-inputcolor', $input_color );
            update_option( 'hr-textcolor', $textcolor );
            update_option( 'hr-widget_statu', $w_statu );
            update_option( 'hotelrunner_lang', $hrlang );
            update_option( 'hotelrunner_target_link', $hr_target );
            update_option( 'hotelrunner_currency', $hr_currency );
            update_option( 'hotelrunner_target_domain', $hotelrunner_target_domain );

      			?>
      			<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible">
        			<p><strong><?php esc_attr_e( 'HotelRunner Widget Settings have been saved!', HOTELRUNNER_TEXT_DOMAIN ); ?></strong></p>
          		<button type="button" class="notice-dismiss">
          		    <span class="screen-reader-text"><?php esc_attr_e( 'Dismiss this notice.', HOTELRUNNER_TEXT_DOMAIN ); ?></span>
        			</button>
      			</div>
      			<?php
      		}?>
        </div>
      </div>
      <!-- row start -->
      <div class="row">
        <div class="col-12 text-center">
          <img src="https://github.com/melihozsecgin/hotelrunner-booking-plugin/blob/master/assets/hrbanner.png?raw=true" alt="" width="300">
          <h3><?php esc_attr_e( 'HotelRunner Booking Button Wordpress Widget', HOTELRUNNER_TEXT_DOMAIN ); ?> <span class="badge badge-light hotelrunner-bg text-white">v1.6</span></h3>
        </div>
      </div>
      <!-- row end -->

      <!-- row start -->
      <div class="row my-4">
        <!-- column start -->
        <div class="col-12">
          <div class="box hotelrunner-bg text-white hotelrunner-box-header p-3 shadow">
            <h4><?php esc_attr_e('Settings', HOTELRUNNER_TEXT_DOMAIN) ?></h4>
          </div>
          <div class="box bg-white p-3">
            <ul class="nav nav-tabs" id="settingsTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">
                  <?php esc_attr_e('General', HOTELRUNNER_TEXT_DOMAIN) ?>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="parameters-tab" data-toggle="tab" href="#parameters" role="tab" aria-controls="parameters" aria-selected="false">
                  <?php esc_attr_e('Parameters', HOTELRUNNER_TEXT_DOMAIN) ?>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="info-tab" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false">
                  <?php esc_attr_e('Help', HOTELRUNNER_TEXT_DOMAIN) ?>
                </a>
              </li>
            </ul>
          </div>
          <div class="box bg-white shadow-sm hotelrunner-box-body p-3 px-5">
            <form method="post" id="hotelrunner_form" action="admin.php?page=hotelrunner" >
              <div class="tab-content" id="settingsTabContent">
                <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                  <div class="row my-3">
                    <div class="col-12">
                      <div class="mb-4">
                        <h4><?php esc_attr_e('General Settings', HOTELRUNNER_TEXT_DOMAIN) ?></h4>
                        <p><?php esc_attr_e('These settings apply when the shortcode is used', HOTELRUNNER_TEXT_DOMAIN) ?></p>
                      </div>
                    </div>
                    <!-- Hotel Property Code -->
                    <div class="col-lg-6 col-12">
                      <div class="form-group">
                        <!-- Hotel Property Code Title -->
                        <label for="hotel_code" class="input-title" data-toggle="modal" data-target="#propertcodeModal">
                          <!-- Button trigger modal -->
                          <?php echo esc_html( esc_attr_e('Hotel Property Code (ex:', HOTELRUNNER_TEXT_DOMAIN)); ?> <code class="hotelrunner-text"><b>test-hotel</b></code>)
                        </label>
                          <!-- Hotel Property Code Input -->
                        <input type="text" class="mw-100 hotelrunner-form-control" id="hotel_code" name="hotel_code" value="<?php echo esc_attr( wp_unslash($hotel_code) ) ?>" placeholder="<?php echo esc_html( esc_attr_e('Enter your hotel code', HOTELRUNNER_TEXT_DOMAIN)); ?>">
                      </div>
                    </div>
                    <div class="col-lg-6 col-12">
                      <div class="form-group">
                        <!-- Hotel Property Code Title -->
                        <label for="hotelrunner_target_domain" class="input-title">
                          <!-- Button trigger modal -->
                          <?php echo esc_html( esc_attr_e('Target Domain', HOTELRUNNER_TEXT_DOMAIN)); ?>
                        </label>
                          <!-- Hotel Property Code Input -->
                        <input type="text" class="mw-100 hotelrunner-form-control" id="hotelrunner_target_domain" name="hotelrunner_target_domain" value="<?php echo esc_attr( wp_unslash($hotelrunner_target_domain) ) ?>" placeholder="<?php echo esc_html( esc_attr_e('Enter your domain', HOTELRUNNER_TEXT_DOMAIN)); ?>">
                      </div>
                    </div>
                    <!-- HOTEL CODE END -->
                    <!-- column start -->
                    <div class="col-lg-4 col-xl-4 col-md-6 col-12 col-sm-12 col-xs-12">
                      <!-- LANGUAGES START -->
                      <div class="form-group">
                        <label for="hotelrunner_lang" class="input-title"><?php esc_attr_e('Select your widget language', HOTELRUNNER_TEXT_DOMAIN); ?> <span id="langcode"></span> </label>
                        <select class="mw-100 hotelrunner-form-control" name="hotelrunner_lang" id="hotelrunner_lang">
                          <option value="none" disabled><?php esc_attr_e('Select Language', HOTELRUNNER_TEXT_DOMAIN); ?></option>
                          <?php
                          $dizi = array(
                            "af-ZA" => "Afrikaans",
                            'az-AZ' => 'Azərbaycan dili',
                            'id-ID' => 'Bahasa Indonesia',
                            'ms-MY' => 'Bahasa Melayu',
                            'jv-ID' => 'Basa Jawa',
                            'bs-BA' => 'Bosanski',
                            'ca-ES' => 'Català',
                            'cs-CZ' => 'Čeština',
                            'cy-GB' => 'Cymraeg',
                            'da-DK' => 'Dansk',
                            'de-DE' => 'Deutsch',
                            'et-EE' => 'Eesti',
                            'en' => 'English',
                            'en-GB' => 'English (UK)',
                            'en-US' => 'English (US)',
                            'es' => 'Español)',
                            'es-CO' => 'Español  (Colombia)',
                            'es-ES' => 'Español (España)',
                            'eu-ES' => 'Basque',
                            'tl-PH' => 'Filipino',
                            'fr-FR' => 'Français',
                            # {:shortSymbol => "fr", :symbol => "fr", :name => "Français", :enName => "French"},
                            'fr-CA' => 'Français (Canada)',
                            'fy-NL' => 'Frysk',
                            'gl-ES' => 'Galego',
                            'gn-PY' => 'Guarani',
                            'hr' => 'Hrvatski',
                            'is-IS' => 'Íslenska',
                            'it-IT' => 'Italiano',
                            'sw' => 'Kiswahili',
                            'ku-TR' => 'Kurdî (Kurmancî)',
                            'lv-LV' => 'Latviešu',
                            'lt-LT' => 'Lietuvių',
                            'hu' => 'Magyar',
                            'nl-NL' => 'Nederlands',
                            'nl-BE' => 'Nederlands (België)',
                            'no-NO' => 'Norsk (nynorsk)',
                            'uz-UZ' => 'Ozbek',
                            'pl' => 'Polski',
                            'pt' => 'Português',
                            'pt-BR' => 'Português (Brasil)',
                            'pt-PT' => 'Português (Portugal)',
                            'ro' => 'Română',
                            'sq-AL' => 'Shqip',
                            'sk-SK' => 'Slovenčina',
                            'sl-SI' => 'Slovenščina',
                            'fi-FI' => 'Suomi',
                            'sv' => 'Svenska',
                            'vi-VN' => 'Tiếng  Việt',
                            'tr' => 'Türkçe',
                            'el' => 'Ελληνικά',
                            'be' => 'Беларуская',
                            'bg' => 'Български',
                            'kk' => 'Қазақша',
                            'mk-MK' => 'Македонски',
                            'mn-MN' => 'Монгол',
                            'ru' => 'Русский',
                            'sr-RS' => 'Српски',
                            'tg-TJ' => 'Тоҷикӣ',
                            'uk-UA' => 'Українська',
                            'ka-GE' => 'ქართული',
                            'hy-AM' => 'Հայերեն',
                            'he-IL' => '‏עברית‏',
                            'he-AL' => '',
                            'ur-PK' => '‏اردو‏',
                            'ar-AR' => '‏العربية‏',
                            'ps-AF' => '‏پښتو‏',
                            'fa-IR' => '‏فارسی‏',
                            'ne-NP' => 'नेपाली',
                            'mr-IN' => 'मराठी',
                            'hi' => 'हिन्दी',
                            'bn-IN' => 'বাংলা',
                            'pa-IN' => 'ਪੰਜਾਬੀ',
                            'gu-IN' => 'ગુજરાતી',
                            'ta-IN' => 'தமிழ்',
                            'te-IN' => 'తెలుగు',
                            'kn-IN' => 'ಕನ್ನಡ',
                            'ml-IN' => 'മലയാളം',
                            'si-LK' => 'සිංහල',
                            'th' => 'ภาษาไทย',
                            'ko' => '한국어',
                            'zh-TW' => '中文(台灣)',
                            'zh-CN' => '中文(简体)',
                            'zh-HK' => '中文(香港)',
                            'ja' => '日本語',
                            'ja-KS' => '日本語(関西)'
                          );
                          foreach ($dizi as $key => $value)
                          {
                            hotelrunner_lang_options($key, $value);
                          }
                          ?>
                        </select>
                      </div>
                      <!-- LANGUAGES END -->
                    </div>
                    <!-- COLUMN END -->

                    <!-- column start -->
                    <div class="col-lg-4 col-xl-4 col-md-6 col-12 col-sm-12 col-xs-12">
                      <!-- Widget Layout (square, inline) -->
                      <div class="form-group">
                        <!-- Widget Layout Title -->
                        <label for="widget_layout" class="input-title"> <?php echo esc_html( esc_attr_e('Widget Layout', HOTELRUNNER_TEXT_DOMAIN)); ?> </label>
                          <!-- Widget Layout Select -->
                        <select class="mw-100 hotelrunner-form-control" name="widget_layout" id="widget_layout">
                          <option value="none" disabled> <?php esc_attr_e('Select Widget Layout', HOTELRUNNER_TEXT_DOMAIN); ?> </option>
                          <option value="inline" <?php if(get_option( 'hr-widget_layout', '' ) == 'inline') echo 'selected'; ?> > <?php esc_attr_e('Inline', HOTELRUNNER_TEXT_DOMAIN); ?> </option>
                          <option value="square" <?php if(get_option( 'hr-widget_layout', '' ) == 'square') echo 'selected'; ?> > <?php esc_attr_e('Square', HOTELRUNNER_TEXT_DOMAIN); ?> </option>
                        </select>
                      </div>
                      <!-- WIDGET LAYOUT END -->
                    </div>
                    <!-- COLUMN END -->

                    <!-- column start -->
                    <div class="col-lg-4 col-xl-4 col-md-6 col-12 col-sm-12 col-xs-12">
                      <!-- Drop Option (up,down) -->
                      <div class="form-group">
                        <!-- Drop Option Title -->
                        <label for="drop" class="input-title"> <?php esc_attr_e('Drop Option', HOTELRUNNER_TEXT_DOMAIN); ?> <span id="drop_icon" class="ml-5px"><?php if(get_option( 'hr-drop', '' ) == 'up'){ ?> <i class="up"></i> <?php } else { ?> <i class="down"></i> <?php } ?></span> </label>
                        <select class="mw-100 hotelrunner-form-control" name="drop" id="drop">
                          <option value="none" disabled> <?php esc_attr_e('Select Drop Option', HOTELRUNNER_TEXT_DOMAIN); ?> </option>
                          <option value="up" <?php if(get_option( 'hr-drop', '' ) == 'up') echo 'selected'; ?> > <?php esc_attr_e('Up', HOTELRUNNER_TEXT_DOMAIN); ?> </option>
                          <option value="down" <?php if(get_option( 'hr-drop', '' ) == 'down') echo 'selected'; ?> > <?php esc_attr_e('Down', HOTELRUNNER_TEXT_DOMAIN); ?> </option>
                        </select>
                      </div>
                      <!-- Drop Option End -->
                    </div>
                    <!-- COLUMN END -->

                    <!-- column start -->
                    <div class="col-lg-4 col-xl-4 col-md-6 col-12 col-sm-12 col-xs-12">
                      <!-- Widget Background Color -->
                      <div class="form-group">
                        <!-- Widget Background Color Title -->
                        <label for="bgcolor" class="input-title"> <?php _e('Widget Background Color', HOTELRUNNER_TEXT_DOMAIN); ?> </label>
                        <!-- Widget Background Color Input -->
                        <input type="text" maxlength="16" name="bgcolor" id="bgcolor" class="mw-100 jscolor hotelrunner-form-control" value="<?php echo esc_attr( wp_unslash($bgcolor) ) ?>" placeholder="<?php echo esc_html( esc_attr_e('Enter Color', HOTELRUNNER_TEXT_DOMAIN)); ?>">
                      </div>
                      <!-- BG COLOR END -->
                    </div>
                    <!-- COLUMN END -->

                    <!-- row start -->
                    <div class="col-lg-4 col-xl-4 col-md-6 col-12 col-sm-12 col-xs-12">
                      <!-- Input Color -->
                      <div class="form-group">
                        <!-- Input Color Title -->
                        <label for="inputcolor" class="input-title"> <?php _e('Input Color', HOTELRUNNER_TEXT_DOMAIN); ?> </label>
                        <!-- Input Color Input -->
                        <input type="text" maxlength="16" name="inputcolor" id="inputcolor" class="mw-100 jscolor hotelrunner-form-control" value="<?php echo esc_attr( wp_unslash($input_color) ) ?>" placeholder="<?php echo esc_html( esc_attr_e('Enter Color', HOTELRUNNER_TEXT_DOMAIN)); ?>">
                      </div>
                      <!-- Input Color End -->
                    </div>
                    <!-- row end -->

                    <!-- row start -->
                    <div class="col-lg-4 col-xl-4 col-md-6 col-12 col-sm-12 col-xs-12">
                      <!-- Text Color -->
                      <div class="form-group">
                        <!-- Text Color Title -->
                        <label for="textcolor" class="input-title"> <?php _e('Text Color', HOTELRUNNER_TEXT_DOMAIN); ?> </label>
                        <!-- Text Color Input -->
                        <input type="text" maxlength="16" name="textcolor" id="textcolor" class="mw-100 jscolor hotelrunner-form-control" value="<?php echo esc_attr( wp_unslash($textcolor) ) ?>" placeholder="<?php echo esc_html( esc_attr_e('Enter Color', HOTELRUNNER_TEXT_DOMAIN)); ?>">
                      </div>
                    </div>
                    <!-- TEXT COLOR END -->

                    <!-- column start -->
                    <div class="col-lg-6 col-xl-6 col-md-6 col-12 col-sm-12 col-xs-12">
                      <!-- Drop Option (up,down) -->
                      <div class="form-group">
                        <!-- Drop Option Title -->
                        <label for="hotelrunner_target_link" class="input-title"> <?php esc_attr_e('Target Link (How Open)', HOTELRUNNER_TEXT_DOMAIN); ?> </label>
                        <select class="mw-100 hotelrunner-form-control" name="hotelrunner_target_link" id="hotelrunner_target_link">
                          <option value="none" disabled> <?php esc_attr_e('Select Option', HOTELRUNNER_TEXT_DOMAIN); ?> </option>
                          <option value="_blank" <?php if(get_option( 'hotelrunner_target_link', '' ) == '_blank') echo 'selected'; ?> > <?php esc_attr_e('Blank (In new tab)', HOTELRUNNER_TEXT_DOMAIN); ?> </option>
                          <option value="_self" <?php if(get_option( 'hotelrunner_target_link', '' ) == '_self') echo 'selected'; ?> > <?php esc_attr_e('Self', HOTELRUNNER_TEXT_DOMAIN); ?> </option>
                        </select>
                      </div>
                      <!-- Drop Option End -->
                    </div>
                    <!-- COLUMN END -->

                    <!-- column start -->
                    <div class="col-lg-6 col-xl-6 col-md-6 col-12 col-sm-12 col-xs-12">
                      <!-- Drop Option (up,down) -->
                      <div class="form-group">
                        <!-- Drop Option Title -->
                        <label for="hotelrunner_currency" class="input-title"> <?php esc_attr_e('Select Currency', HOTELRUNNER_TEXT_DOMAIN); ?> </label>
                        <select class="mw-100 hotelrunner-form-control" name="hotelrunner_currency" id="hotelrunner_currency">
                          <option value="none" disabled><?php esc_attr_e('Select Currency', HOTELRUNNER_TEXT_DOMAIN); ?></option>
                          <?php
                          $currency_array = array(
                            'AED' => 'AED - United Arab Emirates Dirham',
                            'AFN' => 'AFN - Afghan Afghani',
                            'ALL' => 'ALL - Albanian Lek',
                            'AMD' => 'AMD - Armenian Dram',
                            'ANG' => 'ANG - Netherlands Antillean Gulden',
                            'AOA' => 'AOA - Angolan Kwanza',
                            'ARS' => 'ARS - Argentine Peso',
                            'AUD' => 'AUD - Australian Dollar',
                            'AWG' => 'AWG - Aruban Florin',
                            'AZN' => 'AZN - Azerbaijani Manat',
                            'BAM' => 'BAM - Bosnia and Herzegovina Convertible Mark',
                            'BBD' => 'BBD - Barbadian Dollar',
                            'BDT' => 'BDT - Bangladeshi Taka',
                            'BGN' => 'BGN - Bulgarian Lev',
                            'BHD' => 'BHD - Bahraini Dinar',
                            'BIF' => 'BIF - Burundian Franc',
                            'BMD' => 'BMD - Bermudian Dollar',
                            'BND' => 'BND - Brunei Dollar',
                            'BOB' => 'BOB - Bolivian Boliviano',
                            'BRL' => 'BRL - Brazilian Real',
                            'BSD' => 'BSD - Bahamian Dollar',
                            'BTN' => 'BTN - Bhutanese Ngultrum',
                            'BWP' => 'BWP - Botswana Pula',
                            'BYR' => 'BYR - Belarusian Ruble',
                            'BZD' => 'BZD - Belize Dollar',
                            'CAD' => 'CAD - Canadian Dollar',
                            'CDF' => 'CDF - Congolese Franc',
                            'CHF' => 'CHF - Swiss Franc',
                            'CLP' => 'CLP - Chilean Peso',
                            'CNY' => 'CNY - Chinese Renminbi Yuan',
                            'COP' => 'COP - Colombian Peso',
                            'CRC' => 'CRC - Costa Rican Colón',
                            'CUP' => 'CUP - Cuban Peso',
                            'CVE' => 'CVE - Cape Verdean Escudo',
                            'CZK' => 'CZK - Czech Koruna',
                            'DJF' => 'DJF - Djiboutian Franc',
                            'DKK' => 'DKK - Danish Krone',
                            'DOP' => 'DOP - Dominican Peso',
                            'DZD' => 'DZD - Algerian Dinar',
                            'EGP' => 'EGP - Egyptian Pound',
                            'ETB' => 'ETB - Ethiopian Birr',
                            'EUR' => 'EUR - Euro',
                            'FJD' => 'FJD - Fijian Dollar',
                            'FKP' => 'FKP - Falkland Pound',
                            'GBP' => 'GBP - British Pound',
                            'GEL' => 'GEL - Georgian Lari',
                            'GHS' => 'GHS - Ghanaian Cedi',
                            'GIP' => 'GIP - Gibraltar Pound',
                            'GMD' => 'GMD - Gambian Dalasi',
                            'GNF' => 'GNF - Guinean Franc',
                            'GTQ' => 'GTQ - Guatemalan Quetzal',
                            'GYD' => 'GYD - Guyanese Dollar',
                            'HKD' => 'HKD - Hong Kong Dollar',
                            'HNL' => 'HNL - Honduran Lempira',
                            'HRK' => 'HRK - Croatian Kuna',
                            'HTG' => 'HTG - Haitian Gourde',
                            'HUF' => 'HUF - Hungarian Forint',
                            'IDR' => 'IDR - Indonesian Rupiah',
                            'ILS' => 'ILS - Israeli New Sheqel',
                            'INR' => 'INR - Indian Rupee',
                            'IQD' => 'IQD - Iraqi Dinar',
                            'IRR' => 'IRR - Iranian Rial',
                            'ISK' => 'ISK - Icelandic Króna',
                            'JMD' => 'JMD - Jamaican Dollar',
                            'JOD' => 'JOD - Jordanian Dinar',
                            'JPY' => 'JPY - Japanese Yen',
                            'KES' => 'KES - Kenyan Shilling',
                            'KGS' => 'KGS - Kyrgyzstani Som',
                            'KHR' => 'KHR - Cambodian Riel',
                            'KMF' => 'KMF - Comorian Franc',
                            'KPW' => 'KPW - North Korean Won',
                            'KRW' => 'KRW - South Korean Won',
                            'KWD' => 'KWD - Kuwaiti Dinar',
                            'KYD' => 'KYD - Cayman Islands Dollar',
                            'KZT' => 'KZT - Kazakhstani Tenge',
                            'LAK' => 'LAK - Lao Kip',
                            'LBP' => 'LBP - Lebanese Pound',
                            'LKR' => 'LKR - Sri Lankan Rupee',
                            'LRD' => 'LRD - Liberian Dollar',
                            'LSL' => 'LSL - Lesotho Loti',
                            'LTL' => 'LTL - Lithuanian Litas',
                            'LVL' => 'LVL - Latvian Lats',
                            'LYD' => 'LYD - Libyan Dinar',
                            'MAD' => 'MAD - Moroccan Dirham',
                            'MDL' => 'MDL - Moldovan Leu',
                            'MGA' => 'MGA - Malagasy Ariary',
                            'MKD' => 'MKD - Macedonian Denar',
                            'MMK' => 'MMK - Myanmar Kyat',
                            'MNT' => 'MNT - Mongolian Tögrög',
                            'MRO' => 'MRO - Mauritanian Ouguiya',
                            'MUR' => 'MUR - Mauritian Rupee',
                            'MVR' => 'MVR - Maldivian Rufiyaa',
                            'MWK' => 'MWK - Malawian Kwacha',
                            'MXN' => 'MXN - Mexican Peso',
                            'MYR' => 'MYR - Malaysian Ringgit',
                            'MZN' => 'MZN - Mozambican Metical',
                            'NAD' => 'NAD - Namibian Dollar',
                            'NGN' => 'NGN - Nigerian Naira',
                            'NIO' => 'NIO - Nicaraguan Córdoba',
                            'NOK' => 'NOK - Norwegian Krone',
                            'NPR' => 'NPR - Nepalese Rupee',
                            'NZD' => 'NZD - New Zealand Dollar',
                            'OMR' => 'OMR - Omani Rial',
                            'PAB' => 'PAB - Panamanian Balboa',
                            'PEN' => 'PEN - Peruvian Nuevo Sol',
                            'PGK' => 'PGK - Papua New Guinean Kina',
                            'PHP' => 'PHP - Philippine Peso',
                            'PKR' => 'PKR - Pakistani Rupee',
                            'PLN' => 'PLN - Polish Złoty',
                            'PYG' => 'PYG - Paraguayan Guaraní',
                            'QAR' => 'QAR - Qatari Riyal',
                            'RON' => 'RON - Romanian Leu',
                            'RSD' => 'RSD - Serbian Dinar',
                            'RUB' => 'RUB - Russian Ruble',
                            'RWF' => 'RWF - Rwandan Franc',
                            'SAR' => 'SAR - Saudi Riyal',
                            'SBD' => 'SBD - Solomon Islands Dollar',
                            'SCR' => 'SCR - Seychellois Rupee',
                            'SDG' => 'SDG - Sudanese Pound',
                            'SEK' => 'SEK - Swedish Krona',
                            'SGD' => 'SGD - Singapore Dollar',
                            'SHP' => 'SHP - Saint Helenian Pound',
                            'SLL' => 'SLL - Sierra Leonean Leone',
                            'SOS' => 'SOS - Somali Shilling',
                            'SRD' => 'SRD - Surinamese Dollar',
                            'STD' => 'STD - São Tomé and Príncipe Dobra',
                            'SVC' => 'SVC - Salvadoran Colón',
                            'SYP' => 'SYP - Syrian Pound',
                            'SZL' => 'SZL - Swazi Lilangeni',
                            'THB' => 'THB - Thai Baht',
                            'TJS' => 'TJS - Tajikistani Somoni',
                            'TND' => 'TND - Tunisian Dinar',
                            'TOP' => 'TOP - Tongan Paʻanga',
                            'TRY' => 'TRY - Turkish Lira',
                            'TTD' => 'TTD - Trinidad and Tobago Dollar',
                            'TWD' => 'TWD - New Taiwan Dollar',
                            'TZS' => 'TZS - Tanzanian Shilling',
                            'UAH' => 'UAH - Ukrainian Hryvnia',
                            'UGX' => 'UGX - Ugandan Shilling',
                            'USD' => 'USD - United States Dollar',
                            'UYU' => 'UYU - Uruguayan Peso',
                            'UZS' => 'UZS - Uzbekistani Som',
                            'VEF' => 'VEF - Venezuelan Bolívar',
                            'VND' => 'VND - Vietnamese Đồng',
                            'XAF' => 'XAF - Central African Cfa Franc',
                            'XCD' => 'XCD - East Caribbean Dollar',
                            'XOF' => 'XOF - West African Cfa Franc',
                            'XPF' => 'XPF - Cfp Franc',
                            'YER' => 'YER - Yemeni Rial',
                            'ZAR' => 'ZAR - South African Rand',
                            'ZMK' => 'ZMK - Zambian Kwacha'
                          );
                          foreach ($currency_array as $currency_key => $currency_value)
                          {
                            hotelrunner_currency_options($currency_key, $currency_value);
                          }
                          ?>
                        </select>
                      </div>
                      <!-- Drop Option End -->
                    </div>
                    <!-- COLUMN END -->

                  </div>
                  <!-- row end -->
                </div>
                <div class="tab-pane fade" id="info" role="tabpanel" aria-labelledby="info-tab">
                  <div class="row my-3">
                    <div class="col-12">
                      <h4><?php esc_attr_e('Help', HOTELRUNNER_TEXT_DOMAIN) ?></h4>
                      <hr class="">
                      <div class="box px-3">
                        <ul class="list-square">
                          <li>
                            <h6><?php esc_attr_e('What is the property code?', HOTELRUNNER_TEXT_DOMAIN) ?></h6>
                            <p>
                              <img src="https://github.com/melihozsecgin/hotelrunner-booking-plugin/blob/master/assets/propertycode.png?raw=true" alt="">
                              <div class="mb-2">
                                (EN) Copy the [my-hotel] section at the link address of your HotelRunner panel into this field. (my-hotel.hotelrunner.com/admin)
                              </div>
                              <div class="">
                                (TR) HotelRunner panelizin bağlantı adresinde yer alan [my-hotel] bölümünü bu alana kopyalayınız. (my-hotel.hotelrunner.com/admin)
                              </div>
                            </p>
                          </li>
                          <li>
                          <div>

                            <h6><?php esc_attr_e('Usage:', HOTELRUNNER_TEXT_DOMAIN) ?></h6>
                              <div>You can use this plugin in two different ways:</div>
                              <div><b>1.</b> You can make it appear on the pages you specify with <code>[hotelrunner]</code> shortcode in WordPress.</div>
                              <div><b>2.</b> You can drag the HotelRunner Module to the desired section from the View > Widgets menu.</div>
                              <div class="mt-3">
                                <h6 class="my-0">First Use:</h6>
                                <div>You can adjust the <code>[hotelrunner]</code> shortcode settings in the HotelRunner Widget tab in the left menu.</div>
                                <h6 class="mt-3 my-0">Second Use:</h6>
                                <div>You can use the HotelRunner widget by dragging it from the Widgets tab to the required field.</div>
                              </div>
                          </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="parameters" role="tabpanel" aria-labelledby="parameters-tab">
                  <div class="row my-3">
                    <div class="col-12">
                      <h4><?php esc_attr_e('Shortcode Parameters', HOTELRUNNER_TEXT_DOMAIN) ?></h4>
                      <p>Shortcode is <code class="text-dark">[hotelrunner]</code> </p>
                      <div class="box px-3">
                        <span class="font-weight-bold">(EN)</span>
                        <div class="h5 mt-3">
                          (WARNING!)</b> Shortcode <code class="text-dark">[hotelrunner]</code> should be pasted on the relevant page
                        </div>
                        <p>You can quickly change the widget settings with shortcode parameters.</p>
                        <ul class="list-square">
                          <li>
                            <code class="text-dark">[hotelrunner currency="usd"]</code> You can quickly change the currency with the currency parameter.
                          </li>
                          <li>
                            <code class="text-dark">[hotelrunner target="_blank"]</code> You can quickly set the how open module with the target parameter.
                          </li>
                          <li>
                            <code class="text-dark">[hotelrunner textcolor="#111"]</code> The textcolor parameter determines the text color of the module.
                          </li>
                          <li>
                            <code class="text-dark">[hotelrunner layout="inline"]</code> You can quickly set the widget layout with the layout parameter.
                          </li>
                          <li>
                            <code class="text-dark">[hotelrunner drop="down"]</code> You can quickly set the dropdown option with the drop parameter.
                          </li>
                          <li>
                            <code class="text-dark">[hotelrunner lang="en-US"]</code> You can quickly change the widget language with the lang parameter.
                          </li>
                          <li>
                            <code class="text-dark">[hotelrunner bg="#111"]</code> You can quickly change the widget background color with the bg parameter.
                          </li>
                          <li>
                            <code class="text-dark">[hotelrunner inputcolor="#333"]</code> You can quickly change the input background color with the inputcolor parameter.
                          </li>
                          <li>
                            <code class="text-dark">[hotelrunner propertycode="hotel code"]</code> You can quickly change your hotel property code with this paramater
                          </li>
                        </ul>
                        <hr>
                        <span class="font-weight-bold">(TR)</span>
                        <div class="h5 mt-3">
                          (UYARI)</b> Shortcode <code class="text-dark">[hotelrunner]</code> ilgili sayfadaki yere yapıştırılmalı
                        </div>
                        <p>Shortcode parametreleri sayesinde bileşen ayarlarını hızlıca değiştirebilirsiniz.</p>
                        <ul class="list-square">
                          <li>
                            <code class="text-dark">[hotelrunner currency="try"]</code> currency parametresi para birimini belirler.
                          </li>
                          <li>
                            <code class="text-dark">[hotelrunner target="_blank"]</code> target parametresi modülün nasıl açılacağını belirler.
                          </li>
                          <li>
                            <code class="text-dark">[hotelrunner textcolor="#111"]</code> textcolor parametresi modülün yazı rengini belirler.
                          </li>
                          <li>
                            <code class="text-dark">[hotelrunner layout="inline"]</code> layout parametresi ile widget (bileşen) düzenini hızlıca ayarlayabilirsiniz.
                          </li>
                          <li>
                            <code class="text-dark">[hotelrunner drop="down"]</code> drop parametresi ile hızlıca açılır menü ayarlarını yapabilirsiniz.
                          </li>
                          <li>
                            <code class="text-dark">[hotelrunner lang="en-US"]</code> lang parametresi ile hızlıca widget (bileşen) dilini değiştirebilirsiniz.
                          </li>
                          <li>
                            <code class="text-dark">[hotelrunner bg="#111"]</code> bg parametresi ile arkaplan rengini hızlıca değiştirebilirsiniz.
                          </li>
                          <li>
                            <code class="text-dark">[hotelrunner inputcolor="#333"]</code> inputcolor parametresi ile bileşenin iç rengini hızlıca değiştirebilirsiniz.
                          </li>
                          <li>
                            <code class="text-dark">[hotelrunner propertycode="hotel code"]</code> propertycode parametresi ile otel kodunuzu hızlıca değiştirebilirsiniz.
                          </li>

                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- row start -->
              <div class="row justify-content-center border-0 bg-transparent mt-3 pb-4 py-2">
                <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-xs-12 col-sm-12">
                  <!-- Save Button -->
                  <button type="submit" name="hr-submit" id="hr-submit" class="btn btn-danger hotelrunner_button py-2 px-4"><?php esc_attr_e('Save Changes', HOTELRUNNER_TEXT_DOMAIN); ?></button>
                  <!-- SAVE BUTTON END -->
                </div>
              </div>
              <!-- row end -->

            </form>
          </div>
        </div>
        <!-- COLUMN END -->
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="propertcodeModal" tabindex="-1" role="dialog" aria-labelledby="propertcodeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="propertcodeModalLabel"><?php echo esc_html( esc_attr_e('What is the property code?', HOTELRUNNER_TEXT_DOMAIN)); ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <img src="https://github.com/melihozsecgin/hotelrunner-booking-plugin/blob/master/assets/propertycode.png?raw=true" alt="What ist the hotel property code" class="card-img-top">
          </div>
        </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <?php
}
