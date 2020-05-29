<?php
if ( class_exists( 'Kirki' ) ) {


Kirki::add_config( 'lumen', array(
	'capability'    => 'edit_theme_options',
	'option_type'   => 'theme_mod',
) );

// GENERAL
Kirki::add_section( 'general_1', array(
    'title'          => esc_html__( 'General', 'lumen_ambient' ),
    'description'    => esc_html__( 'General site setting', 'lumen_ambient' ),
    'priority'       => 1,
) );

/**
 * Default behaviour (saves data as a URL).
 */
Kirki::add_field( 'lumen', [
	'type'        => 'image',
	'settings'    => 'lumen_logo',
	'label'       => esc_html__( 'Site Logo', 'kirki' ),
	'description' => esc_html__( 'Add site logo Here', 'kirki' ),
	'section'     => 'general_1',
	'default'     => '',
] );

//TYPOGRAPHY
Kirki::add_section( 'lumen_typo', array(
    'title'          => esc_html__( 'Typography', 'lumen_ambient' ),
    'description'    => esc_html__( 'Font settings', 'lumen_ambient' ),
    'priority'       => 2,
) );

Kirki::add_field( 'lumen', [
	'type'        => 'typography',
	'settings'    => 'lumen_body',
	'label'       => esc_html__( 'Body Font', 'kirki' ),
	'section'     => 'lumen_typo',
	'default'     => [
		'font-family'    => 'Roboto',
		'variant'        => 'regular',
		'font-size'      => '14px',
		'line-height'    => '1.5',
		'letter-spacing' => '0',
		'color'          => '#333333',
		'text-transform' => 'none',
		'text-align'     => 'left',
	],
	'priority'    => 10,
	'transport'   => 'auto',
	'output'      => [
		[
			'element' => 'body',
		],
	],
] );
//Header
/*
Kirki::add_field( 'lumen', [
	'type'        => 'typography',
	'settings'    => 'lumen_head',
	'label'       => esc_html__( 'H1', 'kirki' ),
	'section'     => 'lumen_typo',
	'default'     => [
		'font-family'    => 'Roboto',
		'variant'        => 'regular',
		'font-size'      => '30px',
		'line-height'    => '1.5',
		'letter-spacing' => '0',
		'color'          => '#333333',
		'text-transform' => 'none',
		'text-align'     => 'left',
	],
	'priority'    => 10,
	'transport'   => 'auto',
	'output'      => [
		[
			'element' => 'h1',
		],
	],
] );

Kirki::add_field( 'lumen', [
	'type'        => 'typography',
	'settings'    => 'lumen_h2',
	'label'       => esc_html__( 'H2', 'kirki' ),
	'section'     => 'lumen_typo',
	'default'     => [
		'font-family'    => 'Roboto',
		'variant'        => 'regular',
		'font-size'      => '30px',
		'line-height'    => '1.5',
		'letter-spacing' => '0',
		'color'          => '#333333',
		'text-transform' => 'none',
		'text-align'     => 'left',
	],
	'priority'    => 10,
	'transport'   => 'auto',
	'output'      => [
		[
			'element' => 'h2',
		],
	],
] );

Kirki::add_field( 'lumen', [
	'type'        => 'typography',
	'settings'    => 'lumen_h3',
	'label'       => esc_html__( 'H3', 'kirki' ),
	'section'     => 'lumen_typo',
	'default'     => [
		'font-family'    => 'Roboto',
		'variant'        => 'regular',
		'font-size'      => '30px',
		'line-height'    => '1.5',
		'letter-spacing' => '0',
		'color'          => '#333333',
		'text-transform' => 'none',
		'text-align'     => 'left',
	],
	'priority'    => 10,
	'transport'   => 'auto',
	'output'      => [
		[
			'element' => 'h3',
		],
	],
] );

Kirki::add_field( 'lumen', [
	'type'        => 'typography',
	'settings'    => 'lumen_h4',
	'label'       => esc_html__( 'H4', 'kirki' ),
	'section'     => 'lumen_typo',
	'default'     => [
		'font-family'    => 'Roboto',
		'variant'        => 'regular',
		'font-size'      => '30px',
		'line-height'    => '1.5',
		'letter-spacing' => '0',
		'color'          => '#333333',
		'text-transform' => 'none',
		'text-align'     => 'left',
	],
	'priority'    => 10,
	'transport'   => 'auto',
	'output'      => [
		[
			'element' => 'h4',
		],
	],
] );

Kirki::add_field( 'lumen', [
	'type'        => 'typography',
	'settings'    => 'lumen_h5',
	'label'       => esc_html__( 'H5', 'kirki' ),
	'section'     => 'lumen_typo',
	'default'     => [
		'font-family'    => 'Roboto',
		'variant'        => 'regular',
		'font-size'      => '30px',
		'line-height'    => '1.5',
		'letter-spacing' => '0',
		'color'          => '#333333',
		'text-transform' => 'none',
		'text-align'     => 'left',
	],
	'priority'    => 10,
	'transport'   => 'auto',
	'output'      => [
		[
			'element' => 'h5',
		],
	],
] );

Kirki::add_field( 'lumen', [
	'type'        => 'typography',
	'settings'    => 'lumen_h6',
	'label'       => esc_html__( 'H6', 'kirki' ),
	'section'     => 'lumen_typo',
	'default'     => [
		'font-family'    => 'Roboto',
		'variant'        => 'regular',
		'font-size'      => '30px',
		'line-height'    => '1.5',
		'letter-spacing' => '0',
		'color'          => '#333333',
		'text-transform' => 'none',
		'text-align'     => 'left',
	],
	'priority'    => 10,
	'transport'   => 'auto',
	'output'      => [
		[
			'element' => 'h6',
		],
	],
] );
*/
//HEADER
Kirki::add_section( 'lumen_header', array(
    'title'          => esc_html__( 'Header & Navigation', 'lumen_ambient' ),
    'description'    => esc_html__( 'Header & Navigation settings', 'lumen_ambient' ),
    'priority'       => 2,
) );

Kirki::add_field( 'lumem', [
	'type'        => 'select',
	'settings'    => 'lumen_headers',
	'label'       => esc_html__( 'Header type selection', 'kirki' ),
	'section'     => 'lumen_header',
	'default'     => 'top-barnav',
	'placeholder' => esc_html__( 'Select an option...', 'kirki' ),
	'priority'    => 10,
	'multiple'    => 1,
	'choices'     => [
		'top-barnav' => esc_html__( 'Default', 'kirki' ),
		'overlay' => esc_html__( 'Overlay Menu', 'kirki' ),
		'curtain' => esc_html__( 'Curtain Menu', 'kirki' ),
		'big_header' => esc_html__( 'Big Header Center Nav', 'kirki' ),
	],
] );

Kirki::add_field( 'lumem', [
	'type'        => 'color',
	'settings'    => 'lumen_color_text',
	'label'       => __( 'Menu Link color', 'kirki' ),
	'description' => esc_html__( 'Menu text color', 'kirki' ),
	'section'     => 'lumen_header',
	'default'     => '#fff',
	'choices'     => [
		'alpha' => true,
    ],
    'active_callback'  => [
		[
			'setting'  => 'lumen_headers',
			'operator' => '==',
			'value'    => 'top-barnav',
		]
	]
] );

Kirki::add_field( 'lumem', [
	'type'        => 'color',
	'settings'    => 'lumen_color_menu_hover',
	'label'       => __( 'Menu color', 'kirki' ),
	'description' => esc_html__( 'Menu text color Hover', 'kirki' ),
	'section'     => 'lumen_header',
	'default'     => '#fefefe',
	'choices'     => [
		'alpha' => true,
    ],
    'active_callback'  => [
		[
			'setting'  => 'lumen_headers',
			'operator' => '==',
			'value'    => 'top-barnav',
		]
	]
] );
#fefefe
Kirki::add_field( 'lumem', [
	'type'        => 'color',
	'settings'    => 'lumen_color_back',
	'label'       => __( 'Navigation Background color', 'kirki' ),
	'section'     => 'lumen_header',
	'default'     => '#0088CC',
	'choices'     => [
		'alpha' => true,
    ],
        'active_callback'  => [
            [
                'setting'  => 'lumen_headers',
                'operator' => '==',
                'value'    => 'top-barnav',
            ]
        ]
] );
//FOOTER
Kirki::add_section( 'lumen_footer', array(
    'title'          => esc_html__( 'Footer', 'lumen_ambient' ),
    'description'    => esc_html__( 'Footer settings', 'lumen_ambient' ),
    'priority'       => 2,
) );
Kirki::add_field( 'html', [
	'type'        => 'code',
	'settings'    => 'lumen_copyright',
    'label'       => esc_html__( 'Add copyright info here', 'kirki' ),
    'description'    => esc_html__( 'Accepts html also', 'lumen_ambient' ),
	'section'     => 'lumen_footer',
	'default'     => '',
	'choices'     => [
		'language' => 'html',
	],
] );


//BLOG
Kirki::add_section( 'lumen_blog', array(
    'title'          => esc_html__( 'Blog', 'lumen_ambient' ),
    'description'    => esc_html__( 'Site Blog settings', 'lumen_ambient' ),
    'priority'       => 2,
) );

Kirki::add_field( 'lumen', [
	'type'        => 'toggle',
	'settings'    => 'lumen_full_content',
	'label'       => esc_html__( 'Show full blog content', 'kirki' ),
	'section'     => 'lumen_blog',
	'default'     => '0',
	'priority'    => 10,
] );
//CODE INTEGRATION

Kirki::add_section( 'lumen_integration', array(
    'title'          => esc_html__( 'Integration', 'lumen_ambient' ),
    'description'    => esc_html__( 'Code Integration', 'lumen_ambient' ),
    'priority'       => 2,
) );
Kirki::add_field( 'lumen', [
	'type'        => 'code',
	'settings'    => 'lumen_code',
	'label'       => esc_html__( 'Add code to the  head  of your blog', 'kirki' ),
	'section'     => 'lumen_integration',
	'default'     => '',
	'choices'     => [
		'language' => 'html',
	],
] );
Kirki::add_field( 'lumen', [
	'type'        => 'code',
	'settings'    => 'lumen_code2',
	'label'       => esc_html__( 'Add code to the  body  (good for tracking codes such as google analytics)', 'kirki' ),
	'section'     => 'lumen_integration',
	'default'     => '',
	'choices'     => [
		'language' => 'html',
	],
] );

Kirki::add_field( 'lumen', [
	'type'        => 'code',
	'settings'    => 'lumen_code3',
	'label'       => esc_html__( 'Add code to the /body ' , 'kirki' ),
	'section'     => 'lumen_integration',
	'default'     => '',
	'choices'     => [
		'language' => 'html',
	],
] );


}

function lumen_options($id){
    
    $kirki = get_theme_mod($id,'');
    return $kirki;
   }
