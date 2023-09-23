<?php
// Inclua o cabeçalho do WordPress
get_header();
$taxonomy_terms = array('filmes', 'series', 'documentarios');

foreach ($taxonomy_terms as $term) :
    $term_object = get_term_by('name', $term); // Obtém o objeto da taxonomia
    echo $term_object;
    $term_id = $term_object->term_id;
    $term_name = $term_object->name;
    $term_description = $term_object->description;
    $term_link = get_term_link($term_object);
    $videos_query = new WP_Query(array(
        'post_type' => 'video', // Seu tipo de postagem personalizado
        'tax_query' => array(
            array(
                'taxonomy' => 'video_type',
                'field' => 'term_id',
                'terms' => $term_id,
            ),
        ),
        'posts_per_page' => 6, // Quantidade de vídeos a serem exibidos
    ));
    ?>

    <section class="py-12">
        <div class="container mx-auto">
            <h2 class="text-2xl font-semibold mb-4"><?php echo esc_html($term_name); ?></h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                <?php
                if ($videos_query->have_posts()) :
                    while ($videos_query->have_posts()) :
                        $videos_query->the_post();
                        $video_title = get_the_title();
                        $video_thumbnail = get_the_post_thumbnail_url();
                        $video_description = get_the_excerpt();
                        $video_link = get_permalink();
                        ?>

                        <div class="group relative">
                            <a href="<?php echo esc_url($video_link); ?>">
                                <img src="<?php echo esc_url($video_thumbnail); ?>" alt="<?php echo esc_attr($video_title); ?>" class="w-full rounded-lg shadow-lg transform transition-transform group-hover:scale-105" />
                            </a>
                            <div class="mt-2">
                                <a href="<?php echo esc_url($video_link); ?>" class="text-xl font-semibold text-gray-800 hover:text-white hover:bg-red-500 px-2 py-1 transition-colors duration-300 ease-in-out bg-gray-200 rounded-lg group-hover:text-red-500 group-hover:bg-transparent group-hover:border-2 group-hover:border-red-500">
                                    <?php echo esc_html($video_title); ?>
                                </a>
                                <p class="text-gray-600"><?php echo esc_html($video_description); ?></p>
                            </div>
                        </div>

                    <?php endwhile;
                else :
                    echo 'Nenhum vídeo encontrado.';
                endif;
                ?>
            </div>
        </div>
    </section>

<?php endforeach;

wp_reset_postdata();
get_footer();
?>