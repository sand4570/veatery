<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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

<div id="page-single" class="page-style">
    <section id="primary" class="content-area">
        <main id="main-single" class="site-main">

            <button class="singletilbage buttons">Tilbage</button>
            <h2 class="title singletitle"></h2>


            <article id="opskriftgrid">
                <div id="col-left">
                    <figure>
                        <img src="" alt="opskriftbillede" class="billede">
                    </figure>
                </div>

                <div id="col-right">

                    <h3 class="voresh3">Ingredienser</h3>
                    <ul class="ingredients"></ul>
                </div>
            </article>

            <h3 class="singleh3">Fremgangsmåde</h3>
            <p class="description"></p>
        </main>
    </section>
</div>

<script>
    let opskrift;
    // let episoder;
    let aktuelopskrift = <?php echo get_the_ID() ?>;
    console.log("opskrift:", aktuelopskrift);



    const dbUrl = "https://neanderpetersen.dk/kea/10_eksamen/veatery/wp-json/wp/v2/opskrift/" + aktuelopskrift;
    //const episodeUrl = "https://neanderpetersen.dk/kea/09_cms/radioloud/wp-json/wp/v2/episoder?per_page=100";

    //const container = document.querySelector("#episoder")


    async function getJson() {
        console.log("getJson");
        const data = await fetch(dbUrl);
        opskrift = await data.json();

        //const data2 = await fetch(episodeUrl);
        // episoder = await data2.json();
        //console.log("episoder:", episoder);

        visOpskrifter();
        //visEpisoder();
    }


    function visOpskrifter() {
        console.log("visOpskrifter");
        document.querySelector(".title").textContent = opskrift.title.rendered;
        document.querySelector(".description").textContent = opskrift.fremgang;
        document.querySelector(".ingredients").innerHTML = opskrift.ingredienser;
        document.querySelector(".billede").src = opskrift.billede.guid;
    }

    tilbageKnap();
    //sendeplanKnap();

    function tilbageKnap() {
        document.querySelector(".singletilbage").addEventListener("click", visTilbage);
    }

    function visTilbage() {
        window.history.back();
    }

    //    function sendeplanKnap() {
    //        document.querySelector("#sendeplan-knap").addEventListener("click", () => {
    //            window.location.href = "https://neanderpetersen.dk/kea/09_cms/radioloud/sendeplan/"
    //        })
    //    }

    getJson();

</script>

<?php get_footer(); ?>
