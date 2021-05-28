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

<!--template til visning af 3 opskrifter, der passer til ugensstjerne-->
<template>
    <article id="art-forside" class="article">
        <img src="" alt="">
        <p></p>
    </article>
</template>

<script>
    //variabler som vi bruger til at sætte lig JSON data som vi senre henter
    let recipes;
    let tags;

    //Konstanter der definere elementer fra vores html
    const temp = document.querySelector("template");
    const opskriftSection = document.querySelector("#opskrift-section");
    //constant, der er sat lig med id for den grøntsag/det tag der er ugens stjerne. Vil man ændre grøntsag/tag er det derfor nok at ændre tallet her
    const vegetableOfTheWeek = 16;

    //Url'er vi bruger til at komme frem til vores json data via wordpress' restAPI
    const url = "https://neanderpetersen.dk/kea/10_eksamen/veatery/wp-json/wp/v2/opskrift?per_page=100";
    const tagUrl = "https://neanderpetersen.dk/kea/10_eksamen/veatery/wp-json/wp/v2/tags";

    //Vi sikre at siden er loadrd og kører funktionen start
    document.addEventListener("DOMContentLoaded", start);

    //funktionen getJson køres
    function start() {
        getJson();
    }

    //Her benytter vi fetch til at hente json data for opskrifter og tags, og sætter det derefter lig vores globale variabler. funktionen showRecipe køres
    async function getJson() {
        let response = await fetch(url);
        let tagresponse = await fetch(tagUrl);
        recipes = await response.json();
        tags = await tagresponse.json();
        showRecipe();
    }

    //Her viser vi 3 opskrifter
    function showRecipe() {
        console.log(recipes);
        console.log("opskrifter");
        console.log(tags)

        //maxRecipe sættes lig 3, da der max skal udskrives 3 opskrifter til siden
        let maxRecipes = 3;
        //recipeCount sættes lig 0, da der til at starte med ikke er nogle opskrifter på siden
        let recipeCount = 0;

        //Vi starter et forEach loop, der tjekker om hver enkelt opskrift indeholder id'et for denne uges grøntsag, så længe recipeCount er mindre end maxRecipies
        recipes.forEach(recipe => {
            if (recipe.tags.find(id => id === vegetableOfTheWeek) != undefined && recipeCount < maxRecipes) {

                console.log(recipe)

                //Hvis opskrifterne har det rigtige tag, sættes billede og titel ind i vores template.
                const klon = temp.cloneNode(true).content;
                klon.querySelector("img").src = recipe.billede.guid;
                klon.querySelector("p").textContent = recipe.title.rendered;

                //opskriften gøres klikbar så den fører til singleview for opskriften
                klon.querySelector("article").addEventListener("click", () => {
                    location.href = recipe.link;
                })

                //template med indhold placeres på den valgte section
                opskriftSection.appendChild(klon);

                //vi lægger 1 til recipeCount så den ved at der nu er 1 (eller flere) opskrift(er) på siden
                recipeCount++;
            }
        })
    }

</script>

<?php get_footer(); ?>
