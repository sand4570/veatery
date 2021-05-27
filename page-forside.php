<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package OnePress
 */

get_header();

$layout = onepress_get_layout();

/**
 * @since 2.0.0
 * @see onepress_display_page_title
 */
do_action( 'onepress_page_before_content' );

?>
<div id="content" class="site-content">
    <?php onepress_breadcrumb(); ?>
    <div id="content-inside" class="container <?php echo esc_attr( $layout ); ?>">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">

                <?php while ( have_posts() ) : the_post(); ?>

                <?php get_template_part( 'template-parts/content', 'page' ); ?>

                <?php
							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;
						?>

                <?php endwhile; // End of the loop. ?>

            </main><!-- #main -->
        </div><!-- #primary -->

        <?php if ( $layout != 'no-sidebar' ) { ?>
        <?php get_sidebar(); ?>
        <?php } ?>

    </div>
    <!--#content-inside -->
</div><!-- #content -->
<template>
    <article id="art-forside" class="article">
        <img src="" alt="">
        <p></p>
    </article>
</template>

<script>
    let recipes;
    let tags;
    let arraycount = 0;

    const temp = document.querySelector("template");
    const opskriftSection = document.querySelector("#opskrift-section");
    const vegetableOfTheWeek = 16;

    const url = "https://neanderpetersen.dk/kea/10_eksamen/veatery/wp-json/wp/v2/opskrift?per_page=100";
    const tagUrl = "https://neanderpetersen.dk/kea/10_eksamen/veatery/wp-json/wp/v2/tags";

    document.addEventListener("DOMContentLoaded", start);

    function start() {
        getJson();
    }

    async function getJson() {
        let response = await fetch(url);
        let tagresponse = await fetch(tagUrl);
        recipes = await response.json();
        tags = await tagresponse.json();
        showRecipe();
    }

    function showRecipe() {
        console.log(recipes);
        console.log("opskrifter");
        console.log(tags)

        let maxRecipes = 3;
        let recipeCount = 0;
        recipes.forEach(recipe => {
            if (recipe.tags.find(id => id === vegetableOfTheWeek) != undefined && recipeCount < maxRecipes) {
                //TODO: sæt opskrit ind på siden
                console.log(recipe)

                const klon = temp.cloneNode(true).content;
                klon.querySelector("img").src = recipe.billede.guid;
                klon.querySelector("p").textContent = recipe.title.rendered;
                klon.querySelector("article").addEventListener("click", () => {
                    location.href = recipe.link;
                })

                opskriftSection.appendChild(klon);
                recipeCount++;
            }
        })
    }

</script>

<?php get_footer(); ?>
