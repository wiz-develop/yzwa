<?php

class cfs_init
{

    function __construct() {
        add_action( 'init', [ $this, 'init' ] );
    }


    function init() {

        if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
            $this->load_textdomain();
        }

        add_action( 'admin_head',                       [ $this, 'admin_head' ] );
        add_action( 'admin_menu',                       [ $this, 'admin_menu' ] );
        add_action( 'admin_footer',                     [ $this, 'show_credits' ] );
        add_action( 'save_post',                        [ $this, 'save_post' ] );
        add_action( 'delete_post',                      [ $this, 'delete_post' ] );
        add_action( 'add_meta_boxes',                   [ $this, 'add_meta_boxes' ] );
        add_action( 'wp_ajax_cfs_ajax_handler',         [ $this, 'ajax_handler' ] );
        add_filter( 'manage_cfs_posts_columns',         [ $this, 'cfs_columns' ] );
        add_action( 'manage_cfs_posts_custom_column',   [ $this, 'cfs_column_content' ], 10, 2 );

        include( CFS_DIR . '/includes/api.php' );
        include( CFS_DIR . '/includes/upgrade.php' );
        include( CFS_DIR . '/includes/field.php' );
        include( CFS_DIR . '/includes/field_group.php' );
        include( CFS_DIR . '/includes/session.php' );
        include( CFS_DIR . '/includes/form.php' );
        include( CFS_DIR . '/includes/third_party.php' );
        include( CFS_DIR . '/includes/revision.php' );


        $this->register_post_type();
        CFS()->fields = $this->get_field_types();

        // CFS is ready
        do_action( 'cfs_init' );
    }


    /**
     * Register the field group post type
     */
    function register_post_type() {
        register_post_type( 'cfs', [
            'public'            => false,
            'show_ui'           => true,
            'show_in_menu'      => 'options-general.php',
            'capability_type'   => 'page',
            'hierarchical'      => false,
            'supports'          => [ 'title' ],
            'query_var'         => false,
            'labels'            => [
                'name'                  => __( 'Field Groups', 'cfs' ),
                'singular_name'         => __( 'Field Group', 'cfs' ),
                'all_items'             => __( 'Custom Field Suite', 'cfs' ),
                'add_new_item'          => __( 'Add New Field Group', 'cfs' ),
                'edit_item'             => __( 'Edit Field Group', 'cfs' ),
                'new_item'              => __( 'New Field Group', 'cfs' ),
                'view_item'             => __( 'View Field Group', 'cfs' ),
                'search_items'          => __( 'Search Field Groups', 'cfs' ),
                'not_found'             => __( 'No Field Groups found', 'cfs' ),
                'not_found_in_trash'    => __( 'No Field Groups found in Trash', 'cfs' ),
            ],
        ] );
    }


    function load_textdomain() {
        $locale = apply_filters( 'plugin_locale', get_locale(), 'cfs' );
        $mofile = WP_LANG_DIR . '/custom-field-suite/cfs-' . $locale . '.mo';

        if ( file_exists( $mofile ) ) {
            load_textdomain( 'cfs', $mofile );
        }
        else {
            load_plugin_textdomain( 'cfs', false, 'custom-field-suite/languages' );
        }
    }


    /**
     * Register field types
     */
    function get_field_types() {

        // support custom field types
        $field_types = apply_filters( 'cfs_field_types', [
            'text'          => CFS_DIR . '/includes/fields/text.php',
            'textarea'      => CFS_DIR . '/includes/fields/textarea.php',
            'wysiwyg'       => CFS_DIR . '/includes/fields/wysiwyg.php',
            'hyperlink'     => CFS_DIR . '/includes/fields/hyperlink.php',
            'date'          => CFS_DIR . '/includes/fields/date/date.php',
            'color'         => CFS_DIR . '/includes/fields/color/color.php',
            'true_false'    => CFS_DIR . '/includes/fields/true_false.php',
            'select'        => CFS_DIR . '/includes/fields/select.php',
            'relationship'  => CFS_DIR . '/includes/fields/relationship.php',
            'term'          => CFS_DIR . '/includes/fields/term.php',
            'user'          => CFS_DIR . '/includes/fields/user.php',
            'file'          => CFS_DIR . '/includes/fields/file.php',
            'loop'          => CFS_DIR . '/includes/fields/loop.php',
            'tab'           => CFS_DIR . '/includes/fields/tab.php',
        ] );

        foreach ( $field_types as $type => $path ) {
            $class_name = 'cfs_' . $type;

            // allow for multiple classes per file
            if ( ! class_exists( $class_name ) ) {
                include_once( $path );
            }

            $field_types[ $type ] = new $class_name();
        }

        return $field_types;
    }


    /**
     * admin_head
     */
    function admin_head() {
        $screen = get_current_screen();

        if ( is_object( $screen ) && 'post' == $screen->base ) {
            include( CFS_DIR . '/templates/admin_head.php' );
        }
    }


    /**
     * show_credits
     */
    function show_credits() {
        $screen = get_current_screen();

        if ( is_object( $screen ) && 'edit' == $screen->base && 'cfs' == $screen->post_type ) {
            include( CFS_DIR . '/templates/credits.php' );
        }
    }

    /**
    * admin_menu
    */
    function admin_menu() {
        if ( false === apply_filters( 'cfs_disable_admin', false ) ) {
            add_submenu_page( 'tools.php', __( 'CFS Tools', 'cfs' ), __( 'CFS Tools', 'cfs' ), 'manage_options', 'cfs-tools', [ $this, 'page_tools' ] );
        }
    }

    /**
     * add_meta_boxes
     */
    function add_meta_boxes() {
        add_meta_box( 'cfs_fields', __('Fields', 'cfs'), [ $this, 'meta_box' ], 'cfs', 'normal', 'high', [ 'box' => 'fields' ] );
        add_meta_box( 'cfs_rules', __('Placement Rules', 'cfs'), [ $this, 'meta_box' ], 'cfs', 'normal', 'high', [ 'box' => 'rules' ] );
        add_meta_box( 'cfs_extras', __('Extras', 'cfs'), [ $this, 'meta_box' ], 'cfs', 'normal', 'high', [ 'box' => 'extras' ] );
    }


    /**
     * meta_box
     * @param object $post
     * @param array $metabox
     */
    function meta_box( $post, $metabox ) {
        $box = $metabox['args']['box'];
        include( CFS_DIR . "/templates/meta_box_$box.php" );
    }


    /**
     * page_tools
     */
    function page_tools() {
        include( CFS_DIR . '/templates/page_tools.php' );
    }


    /**
     * save_post
     */
    function save_post( $post_id ) {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        $cfs_post = isset( $_POST['cfs'] ) && is_array( $_POST['cfs'] ) ? wp_unslash( $_POST['cfs'] ) : [];

        if ( ! isset( $cfs_post['save'] ) ) {
            return;
        }

        if ( false !== wp_is_post_revision( $post_id ) ) {
            return;
        }

        if ( 'cfs' !== get_post_type( $post_id ) || ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        $nonce = sanitize_text_field( $cfs_post['save'] );

        if ( wp_verify_nonce( $nonce, 'cfs_save_fields' ) ) {
            $fields = isset( $cfs_post['fields'] ) ? $this->sanitize_recursive_textarea( $cfs_post['fields'] ) : [];
            $rules = isset( $cfs_post['rules'] ) ? $this->sanitize_recursive_textarea( $cfs_post['rules'] ) : [];
            $extras = isset( $cfs_post['extras'] ) ? $this->sanitize_recursive_textarea( $cfs_post['extras'] ) : [];

            CFS()->field_group->save( [
                'post_id'   => $post_id,
                'fields'    => $fields,
                'rules'     => $rules,
                'extras'    => $extras,
            ] );
        }
    }


    /**
     * delete_post
     * @return boolean
     */
    function delete_post( $post_id ) {
        global $wpdb;

        if ( 'cfs' != get_post_type( $post_id ) ) {
            $wpdb->query(
                $wpdb->prepare(
                    "DELETE FROM {$wpdb->prefix}cfs_values WHERE post_id = %d",
                    absint( $post_id )
                )
            );
        }

        return true;
    }


    /**
     * ajax_handler
     */
    function ajax_handler() {
        if ( ! current_user_can( 'manage_options' ) ) {
            exit;
        }

        if ( ! check_ajax_referer( 'cfs_admin_nonce', 'nonce', false ) ) {
            exit;
        }

        $cfs_post = isset( $_POST ) && is_array( $_POST ) ? wp_unslash( $_POST ) : [];
        $ajax_method = isset( $cfs_post['action_type'] ) ? sanitize_key( $cfs_post['action_type'] ) : '';

        if ( $ajax_method && is_admin() ) {
            include( CFS_DIR . '/includes/ajax.php' );
            $ajax = new cfs_ajax();

            if ( 'import' == $ajax_method ) {
                $options = [
                    'import_code' => isset( $cfs_post['import_code'] ) ? json_decode( (string) $cfs_post['import_code'], true ) : [],
                ];
                echo wp_kses_post( CFS()->field_group->import( $options ) );
            }
            elseif ('export' == $ajax_method) {
                $options = [
                    'field_groups' => isset( $cfs_post['field_groups'] ) ? array_map( 'absint', (array) $cfs_post['field_groups'] ) : [],
                ];
                echo wp_json_encode( CFS()->field_group->export( $options ) );
            }
            elseif ('reset' == $ajax_method) {
                $ajax->reset();
                deactivate_plugins( plugin_basename( __FILE__ ) );
                echo admin_url( 'plugins.php' );
            }
            elseif ( 'search_posts' == $ajax_method ) {
                $options = [ 'q' => isset( $cfs_post['q'] ) ? sanitize_text_field( $cfs_post['q'] ) : '' ];
                echo wp_json_encode( $ajax->search_posts( $options ) );
            }
        }

        exit;
    }


    private function sanitize_recursive_textarea( $value ) {
        if ( is_array( $value ) ) {
            $sanitized = [];
            foreach ( $value as $key => $item ) {
                $sanitized_key = is_int( $key ) ? $key : sanitize_key( (string) $key );
                $sanitized[ $sanitized_key ] = $this->sanitize_recursive_textarea( $item );
            }
            return $sanitized;
        }

        if ( is_scalar( $value ) || null === $value ) {
            return sanitize_textarea_field( (string) $value );
        }

        return '';
    }


    /**
     * Customize table columns on the Field Group listing
     */
    function cfs_columns() {
        return [
            'cb'            => '<input type="checkbox" />',
            'title'         => __( 'Title', 'cfs' ),
            'placement'     => __( 'Placement', 'cfs' ),
        ];
    }


    /**
     * Populate the "Placement" column on the Field Group listing
     */
    function cfs_column_content( $column_name, $post_id ) {
        if ( 'placement' == $column_name ) {
            global $wpdb;

            $labels = [
                'post_types'        => __( 'Post Types', 'cfs' ),
                'user_roles'        => __( 'User Roles', 'cfs' ),
                'post_ids'          => __( 'Posts', 'cfs' ),
                'term_ids'          => __( 'Term IDs', 'cfs' ),
                'page_templates'    => __( 'Page Templates', 'cfs' ),
                'post_formats'      => __( 'Post Formats', 'cfs' )
            ];

            $field_groups = CFS()->field_group->load_field_groups();

            // Make sure the field group exists
            $rules = [];
            if ( isset( $field_groups[ $post_id ] ) ) {
                $rules = $field_groups[ $post_id ]['rules'];
            }

            foreach ( $rules as $criteria => $data ) {
                if ( ! isset( $labels[ $criteria ] ) || ! is_array( $data ) ) {
                    continue;
                }

                $label = $labels[ $criteria ];
                $values = isset( $data['values'] ) ? (array) $data['values'] : [];
                $operator = ( isset( $data['operator'] ) && '==' == $data['operator'] ) ? '=' : '!=';

                // Get post titles
                if ( 'post_ids' == $criteria ) {
                    $temp = [];
                    foreach ( $values as $val ) {
                        $temp[] = get_the_title( (int) $val );
                    }
                    $values = $temp;
                }

                echo '<div><strong>' . esc_html( $label ) . '</strong> ' . esc_html( $operator ) . ' ' . esc_html( implode( ', ', $values ) ) . '</div>';
            }
        }
    }
}

new cfs_init();
