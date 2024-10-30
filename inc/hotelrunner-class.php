<?php
/**
 * Adds HotelRunner booking widget.
 */
 class HotelRunner_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct()
    {
      parent::__construct(
        'hotelrunner_widget', // Base ID
        'HotelRunner', // Name
        array( 'description' => esc_attr( 'Widget to HotelRunner Booking Widget', HOTELRUNNER_TEXT_DOMAIN ), ) // Args
      );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance )
    {
      echo $args['before_widget']; // Whatever you want to display before widget (<div>, etc)
      if ( ! empty( $instance['title'] ) )
      {
        echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
      }
      // Widget Content Output
      $newColor = $hr_color;
      debug_to_console($instance['hr_color']);
      echo load_widget( false,
        $instance['hr_color'],
        $instance['hr_inputbg'],
        $instance['hr_textcolor'],
        $instance['hr_layout'],
        $instance['hr_drop'],
        $instance['hotelrunner_lang'],
        $instance['hotel_code'],
        '_blank',
        'usd',
        $instance['hotelrunner_target_domain']
      );
      echo $args['after_widget']; // Whatever you want to display after widget (</div>, etc)
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */


    public function form( $instance )
    {
      // DEFAULTS
      $title      = ! empty( $instance['title'] )      ? $instance['title']      : esc_attr('Book Now');
      $hotel_code = ! empty( $instance['hotel_code'] ) ? $instance['hotel_code'] : esc_attr('hr-template');
      $hr_layout  = ! empty( $instance['hr_layout'] )  ? $instance['hr_layout']  : esc_attr('inline');
      $hr_drop    = ! empty( $instance['hr_drop'] )    ? $instance['hr_drop']    : esc_attr('down');
      $hr_color   = ! empty( $instance['hr_color'] )   ? $instance['hr_color']   : esc_attr('f15f22');
      $hr_inputbg   = ! empty( $instance['hr_inputbg'] )   ? $instance['hr_inputbg']   : esc_attr('333');
      $hr_textcolor   = ! empty( $instance['hr_textcolor'] )   ? $instance['hr_textcolor']   : esc_attr('fff');
      $hr_lang   = ! empty( $instance['hotelrunner_lang'] )   ? $instance['hotelrunner_lang']   : esc_attr('en-US');
      $hr_widget_lang = ! empty( $instance['hotelrunner_widget_lang'] )   ? $instance['hotelrunner_widget_lang']   : '';
      $hotelrunner_target_domain = ! empty( $instance['hotelrunner_target_domain'] )   ? $instance['hotelrunner_target_domain']   : '';
      ?>

      <!-- BOOK NOW TITLE START -->
      <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
          <?php esc_attr_e( 'Title:', HOTELRUNNER_TEXT_DOMAIN ); ?>
        </label>

        <input
          class="widefat"
          id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
          name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
          type="text"
          value="<?php esc_attr_e( $title, HOTELRUNNER_TEXT_DOMAIN ); ?>">
      </p>
      <!-- TITLE END -->

      <!-- language (soon) -->
      <!--<p>

        <label for="<?php echo esc_attr( $this->get_field_id( 'hotelrunner_widget_lang' ) ); ?>">
          <?php esc_attr_e( 'Language:', HOTELRUNNER_TEXT_DOMAIN ); ?>
        </label>

        <select
          class=""
          name="<?php echo esc_attr( $this->get_field_id( 'hotelrunner_widget_lang' ) ); ?>"
          id="<?php echo esc_attr( $this->get_field_id( 'hotelrunner_widget_lang' ) ); ?>"
          style="width: 100%;margin-top: 5px;padding-top: 0px !important; padding-bottom: 0px !important;">
          <option value="none" disabled><?php esc_attr_e('Select Language', HOTELRUNNER_TEXT_DOMAIN); ?></option>
          <option value="tr" <?php echo ($hr_widget_lang == 'tr') ? 'selected' : ''; ?>>
            <?php esc_attr_e( 'Turkce ', HOTELRUNNER_TEXT_DOMAIN ); ?>
          </option>
          <option value="en-US" <?php echo ($hr_widget_lang == 'en-US') ? 'selected' : ''; ?>>
            <?php esc_attr_e( 'English', HOTELRUNNER_TEXT_DOMAIN ); ?>
          </option>
        </select>
      </p>-->

      <!-- Hotel Property Code -->
      <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'hotel_code' ) ); ?>">
          <?php esc_attr_e( 'Hotel Code:', HOTELRUNNER_TEXT_DOMAIN ); ?>
        </label>

        <input
          class="widefat"
          id="<?php echo esc_attr( $this->get_field_id( 'hotel_code' ) ); ?>"
          name="<?php echo esc_attr( $this->get_field_name( 'hotel_code' ) ); ?>"
          type="text"
          value="<?php echo esc_attr( $hotel_code ); ?>">
      </p>
      <!-- HOTEL CODE END -->

      <!-- TARGET DOMAIN -->
      <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'hotelrunner_target_domain' ) ); ?>">
          <?php esc_attr_e( 'Target Domain:', HOTELRUNNER_TEXT_DOMAIN ); ?>
        </label>

        <input
          class="widefat"
          id="<?php echo esc_attr( $this->get_field_id( 'hotelrunner_target_domain' ) ); ?>"
          name="<?php echo esc_attr( $this->get_field_name( 'hotelrunner_target_domain' ) ); ?>"
          type="text"
          value="<?php echo esc_attr( $hotelrunner_target_domain ); ?>">
      </p>
      <!-- TARGET DOMAIN END -->

      <!-- WIDGET LAYOUT (square, inline) -->
      <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'hr_layout' ) ); ?>">
          <?php esc_attr_e( 'Layout:', HOTELRUNNER_TEXT_DOMAIN ); ?> <b><?php esc_attr_e( '(If you adding to sidebar, we recommended Square)', HOTELRUNNER_TEXT_DOMAIN ); ?></b>
        </label>

        <select
          class="widefat hotelrunner-form-control"
          id="<?php echo esc_attr( $this->get_field_id( 'hr_layout' ) ); ?>"
          name="<?php echo esc_attr( $this->get_field_name( 'hr_layout' ) ); ?>">
          <option value="square" <?php echo ($hr_layout == 'square') ? 'selected' : ''; ?>>
            <?php esc_attr_e( 'Square', HOTELRUNNER_TEXT_DOMAIN ); ?>
          </option>
          <option value="inline" <?php echo ($hr_layout == 'inline') ? 'selected' : ''; ?>>
            <?php esc_attr_e( 'Inline', HOTELRUNNER_TEXT_DOMAIN ); ?>
          </option>
        </select>
      </p>
      <!-- WIDGET LAYOUT END -->

      <!-- BG COLOR -->
      <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'hr_color' ) ); ?>">
          <?php esc_attr_e( 'Background Color:', HOTELRUNNER_TEXT_DOMAIN ); ?>
        </label>

        <input
          class="widefat jscolor"
          id="<?php echo esc_attr( $this->get_field_id( 'hr_color' ) ); ?>"
          name="<?php echo esc_attr( $this->get_field_name( 'hr_color' ) ); ?>"
          type="text"
          value="<?php esc_attr_e( $hr_color, HOTELRUNNER_TEXT_DOMAIN ); ?>">
      </p>
      <!-- BG COLOR END -->

      <!-- INPUT BG COLOR -->
      <p>
          <label for="<?php echo esc_attr( $this->get_field_id( 'hr_inputbg' ) ); ?>">
            <?php esc_attr_e( 'Input Background Color:', HOTELRUNNER_TEXT_DOMAIN ); ?>
          </label>

          <input
            class="widefat jscolor"
            id="<?php echo esc_attr( $this->get_field_id( 'hr_inputbg' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'hr_inputbg' ) ); ?>"
            type="text"
            value="<?php esc_attr_e( $hr_inputbg, HOTELRUNNER_TEXT_DOMAIN ); ?>">
      </p>
      <!-- INPUT BG COLOR END -->

      <!-- TEXT COLOR -->
      <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'hr_textcolor' ) ); ?>">
          <?php esc_attr_e( 'Text Color:', HOTELRUNNER_TEXT_DOMAIN ); ?>
        </label>

        <input
          class="widefat jscolor"
          id="<?php echo esc_attr( $this->get_field_id( 'hr_textcolor' ) ); ?>"
          name="<?php echo esc_attr( $this->get_field_name( 'hr_textcolor' ) ); ?>"
          type="text"
          value="<?php esc_attr_e( $hr_textcolor, HOTELRUNNER_TEXT_DOMAIN ); ?>">
      </p>
      <!-- TEXT COLOR END -->

      <!-- DROP OPTION -->
      <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'hr_drop' ) ); ?>">
          <?php esc_attr_e( 'Drop Option:', HOTELRUNNER_TEXT_DOMAIN ); ?>
        </label>

        <select
          class="widefat"
          id="<?php echo esc_attr( $this->get_field_id( 'hr_drop' ) ); ?>"
          name="<?php echo esc_attr( $this->get_field_name( 'hr_drop' ) ); ?>">
          <option value="down" <?php echo ($hr_drop == 'down') ? 'selected' : ''; ?>>
            <?php esc_attr_e( 'Down', HOTELRUNNER_TEXT_DOMAIN ); ?>
          </option>
          <option value="up" <?php echo ($hr_drop == 'up') ? 'selected' : ''; ?>>
            <?php esc_attr_e( 'Up', HOTELRUNNER_TEXT_DOMAIN ); ?>
          </option>
        </select>
      </p>

      <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */

    public function update( $new_instance, $old_instance )
    {
      $instance = array();
      $instance['title']      = ( ! empty( $new_instance['title'] ) )      ? strip_tags( $new_instance['title'] )      : '';
      $instance['hotel_code'] = ( ! empty( $new_instance['hotel_code'] ) ) ? strip_tags( $new_instance['hotel_code'] ) : '';
      $instance['hr_layout']  = ( ! empty( $new_instance['hr_layout'] ) )  ? strip_tags( $new_instance['hr_layout'] )  : '';
      $instance['hr_drop']    = ( ! empty( $new_instance['hr_drop'] ) )    ? strip_tags( $new_instance['hr_drop'] )    : '';
      $instance['hr_color']   = ( ! empty( $new_instance['hr_color'] ) )   ? strip_tags( $new_instance['hr_color'] )   : '';
      $instance['hr_inputbg'] = ( ! empty( $new_instance['hr_inputbg'] ) ) ? strip_tags( $new_instance['hr_inputbg'] ) : '';
      $instance['hr_textcolor'] = ( ! empty( $new_instance['hr_textcolor'] ) ) ? strip_tags( $new_instance['hr_textcolor'] ) : '';
      $instance['hr_domain']  = ( ! empty( $new_instance['hr_domain'] ) )  ? strip_tags( $new_instance['hr_domain'] )  : '';
      $instance['hotelrunner_widget_lang']  = ( ! empty( $new_instance['hotelrunner_widget_lang'] ) )  ? strip_tags( $new_instance['hotelrunner_widget_lang'] )  : '';
      $instance['hotelrunner_target_domain']  = ( ! empty( $new_instance['hotelrunner_target_domain'] ) )  ? strip_tags( $new_instance['hotelrunner_target_domain'] )  : '';
      //$instance['hotelrunner_lang']  = ( ! empty( $new_instance['hotelrunner_lang'] ) )  ? strip_tags( $new_instance['hotelrunner_lang'] )  : '';
      return $instance;
    }

  }
