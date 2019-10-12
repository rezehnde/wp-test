<?php 
function wptest_customize_register( $wp_customize ) {
    $wp_customize->add_section(
        'wptest_customize_options',
        array(
            'title'      => 'WP-Test Customization',
            'priority'   => 30,
        )
    );
    $wp_customize->add_setting(
        'wptest_copyright',
        array(
            'default'   => 'Teste',
        )
    );
    $wp_customize->add_control(
        'wptest_copyright',
        array(
            'label'     => __( 'Copyright notice', 'wp-test' ),
            'type'      => 'text',
            'section'   => 'title_tagline',
        )
    );
}
add_action( 'customize_register', 'wptest_customize_register' );
