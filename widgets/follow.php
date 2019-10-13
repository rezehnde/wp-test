<?php
class follow_Widget extends WP_Widget {

    private $networks = array('facebook', 'twitter', 'instagram', 'linkedin');

    public function __construct() {
        $widget_options = array( 'classname' => 'follow_widget', 'description' => 'This is a Follow Us Widget' );
        parent::__construct( 'follow_widget', 'Follow Us Widget', $widget_options );
    }

    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance[ 'title' ] );
        echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title'];
        foreach ($this->networks as $network) {
            ?>
            <a href="<?php echo esc_attr($instance[$network]); ?>" class="pl-0 pr-3"><span class="icon-<?php echo esc_attr($network); ?>"></span></a>
            <?php
        }
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
        foreach ($this->networks as $network) {
            $value = ! empty( $instance[$network] ) ? $instance[$network] : '';
            ?>
            <p>
                <label for="<?php echo $this->get_field_id( $network ); ?>"><?php echo ucfirst($network); ?>:</label>
                <input type="text" id="<?php echo $this->get_field_id( $network ); ?>" name="<?php echo $this->get_field_name( $network ); ?>" value="<?php echo esc_attr( $value ); ?>" class="widefat <?php echo $network; ?>" />
            </p>
            <?php
        }
    }
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
        foreach ($this->networks as $network) {
            $instance[ $network ] = strip_tags( $new_instance[ $network ] );
        }
        return $instance;
    }
}
// Register the widget.
function wptest_register_follow_widget() { 
    register_widget( 'follow_Widget' );
}
add_action( 'widgets_init', 'wptest_register_follow_widget' );
