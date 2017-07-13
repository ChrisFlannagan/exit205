<?php

    /**
     * Set the content width based on the theme's design and stylesheet.
     */
    if ( ! isset( $content_width ) ) {
        $content_width = 1170; /* pixels */
    }

    if ( ! function_exists( 'shaped_blog_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function shaped_blog_setup() {

        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on shaped-blog, use a find and replace
         * to change 'shaped-blog' to the name of your theme in all the template files
         */
        load_theme_textdomain( 'shaped-blog', get_template_directory() . '/languages' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );


        // Register menu.
        function shaped_blog_register_menus() {
            register_nav_menus( array( 'primary'      => __( 'Primary Menu','shaped-blog' ) ) );
        }
        add_action('init', 'shaped_blog_register_menus');

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
        ) );

        // Post Formats.
        add_theme_support( 'post-formats', array( 
            'aside', 'image', 'audio', 'video', 'gallery', 'quote', 'link', 'chat'
        ) );

        // Post thumbnails
        add_theme_support( 'post-thumbnails' );
        add_image_size('shaped-blog-thumb', 1140, 560, TRUE);


        // Set up the WordPress core custom background feature.
        add_theme_support( 'custom-background', apply_filters( 'shaped_blog_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        ) ) );
    }
    endif; // shaped_blog_setup
    add_action( 'after_setup_theme', 'shaped_blog_setup' );




    //////////////////////////////////////////////////////////////////
    // Register widget area.
    //////////////////////////////////////////////////////////////////
    function shaped_blog_widgets_init()
    {
        register_sidebar(array(
            'name'          => __('Blog Sidebar', 'shaped-blog'),
            'id'            => 'shaped-blog-sidebar',
            'description'   => __('Appears in the blog sidebar.', 'shaped-blog'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));

        register_sidebar(array(
            'name'          => __('Page Sidebar', 'shaped-blog'),
            'id'            => 'shaped-blog-page-sidebar',
            'description'   => __('Appears in the Page sidebar.', 'shaped-blog'),
            'before_widget' => '<div id="%1$s" class="page-widget widget %2$s clear">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));

        
    }

    add_action('widgets_init', 'shaped_blog_widgets_init');



    //////////////////////////////////////////////////////////////////
    // Enqueue scripts and styles.
    //////////////////////////////////////////////////////////////////

    function shaped_blog_scripts() {
        
        // CSS

        wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '3.3.5');
        wp_enqueue_style('font-awesome-css', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), '4.4.0');
        wp_enqueue_style( 'shaped-blog-stylesheet', get_stylesheet_uri() );
        wp_enqueue_style('responsive-css', get_template_directory_uri() . '/assets/css/responsive.css', array(), NULL);

        // JS Files
        wp_enqueue_script( 'jquery');
        wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), '3.3.5', TRUE );
        wp_enqueue_script( 'shaped-blog-scripts-js', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), NULL, TRUE );
        wp_enqueue_script( 'fitvids-js', get_template_directory_uri() . '/assets/js/jquery.fitvids.js', array('jquery'), NULL, TRUE );
        wp_enqueue_script( 'smoothscroll-js', get_template_directory_uri() . '/assets/js/smoothscroll.js', array('jquery'), NULL, TRUE );

        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
    }
    add_action( 'wp_enqueue_scripts', 'shaped_blog_scripts' );


    //////////////////////////////////////////////////////////////////
    // Comment
    //////////////////////////////////////////////////////////////////

    if(!function_exists('shaped_blog_comment')):

        function shaped_blog_comment($comment, $args, $depth)
        {
            $GLOBALS['comment'] = $comment;
            switch ( $comment->comment_type ) :
                case 'pingback' :
                case 'trackback' :
                // Display trackbacks differently than normal comments.
            ?>
            <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
                <p>Pingback: <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'shaped-blog' ), '<span class="edit-link">', '</span>' ); ?></p>
            <?php
                    break;
                default :
                
                global $post;
            ?>
            <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                <div id="comment-<?php comment_ID(); ?>" class="comment-body media">
                    
                        <div class="comment-avartar pull-left">
                            <?php
                                echo get_avatar( $comment, $args['avatar_size'] );
                            ?>
                        </div>
                        <div class="comment-context media-body">
                            <div class="comment-head">
                                <?php
                                    printf( '<h3 class="comment-author">%1$s</h3>',
                                        get_comment_author_link());
                                ?>
                                <span class="comment-date"><?php echo get_comment_date() ?></span>
                            </div>

                            <?php if ( '0' == $comment->comment_approved ) : ?>
                            <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'shaped-blog' ); ?></p>
                            <?php endif; ?>

                            <div class="comment-content">
                                <?php comment_text(); ?>
                            </div>

                            <?php edit_comment_link( __( 'Edit', 'shaped-blog' ), '<span class="edit-link">', '</span>' ); ?>
                            <span class="comment-reply">
                                <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'shaped-blog' ), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                            </span>

                        </div>
                    
                </div>
            <?php
                break;
            endswitch; 
        }

    endif;





// Navwalker
require_once get_template_directory() . "/includes/wp_bootstrap_navwalker.php";

// Custom template tags for this theme.
require get_template_directory() . '/includes/template-tags.php';

// Custom functions that act independently of the theme templates.
require get_template_directory() . '/includes/extras.php';

// Load Jetpack compatibility file.
require get_template_directory() . '/includes/jetpack.php';

// Theme Customizer
include('admin/functions/customizer/shaped_blog_customizer_settings.php');
include('admin/functions/customizer/shaped_blog_color_customize.php');



