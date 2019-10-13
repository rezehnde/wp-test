<?php
class newsletter_Widget extends WP_Widget {

    public function __construct() {
        $widget_options = array( 'classname' => 'newsletter_widget', 'description' => 'This is a Newsletter Widget' );
        parent::__construct( 'newsletter_widget', 'Newsletter Widget', $widget_options );
    }

    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance[ 'title' ] );
        echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title'];
        ?>
        <form action="#" method="post">
            <div class="input-group mb-3">
                <input type="text" class="form-control border-secondary text-white bg-transparent" placeholder="Enter Email" aria-label="Enter Email" aria-describedby="button-addon2">
                <div class="input-group-append">
                    <button class="btn btn-primary text-white" type="button" id="button-addon2">Send</button>
                </div>
            </div>
        </form>
        <?php
        echo $args['after_widget'];
    }
  
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" class="widefat title" />
        </p>        
        <?php
    }
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
        return $instance;
    }
}
// Register the widget.
function wptest_register_newsletter_widget() { 
    register_widget( 'newsletter_Widget' );
}
add_action( 'widgets_init', 'wptest_register_newsletter_widget' );
