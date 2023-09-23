<?php
// Registre os menus de navegação
function register_custom_menus() {
    register_nav_menus(
        array(
            'primary-menu' => __('Menu Principal'),
        )
    );
}
function register_custom_taxonomies() {
    $taxonomies = array(
        'filmes' => array(
            'singular_name' => 'Filme',
            'plural_name'   => 'Filmes',
            'slug'          => 'filmes',
        ),
        'series' => array(
            'singular_name' => 'Série',
            'plural_name'   => 'Séries',
            'slug'          => 'series',
        ),
        'documentarios' => array(
            'singular_name' => 'Documentário',
            'plural_name'   => 'Documentários',
            'slug'          => 'documentarios',
        ),
    );

    foreach ($taxonomies as $taxonomy => $args) {
        $labels = array(
            'name'              => _x($args['plural_name'], 'taxonomy general name'),
            'singular_name'     => _x($args['singular_name'], 'taxonomy singular name'),
            'search_items'      => __('Procurar ' . $args['plural_name']),
            'all_items'         => __('Todos os ' . $args['plural_name']),
            'edit_item'         => __('Editar ' . $args['singular_name']),
            'update_item'       => __('Atualizar ' . $args['singular_name']),
            'add_new_item'      => __('Adicionar Novo ' . $args['singular_name']),
            'new_item_name'     => __('Novo Nome de ' . $args['singular_name']),
            'menu_name'         => __($args['plural_name']),
        );

        $taxonomy_args = array(
            'labels'            => $labels,
            'public'            => true,
            'show_in_nav_menus' => true,
            'show_admin_column' => true,
            'hierarchical'      => true,
            'rewrite'           => array('slug' => $args['slug']),
        );

        register_taxonomy($taxonomy, array('video'), $taxonomy_args);
    }
}

// Registre as taxonomias personalizadas quando o WordPress é inicializado
add_action('init', 'register_custom_taxonomies');

add_action('init', 'register_custom_menus');
add_theme_support('post-thumbnails');