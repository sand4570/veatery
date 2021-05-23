<?php
/**
 * The template for displaying all single posts.
 *
 */

get_header(); ?>

<section id="primary" class="content-area">
    <main id="main" class="site-main">
        <button class="singletilbage">Tilbage</button>

        <article>
            <!--
            <div id="col-left">
                <img src="" alt="" class="billede">
                <div>
                    <p class="ingredients"></p>
                    <img src="" alt="" class="ikon1">
                    <img src="" alt="" class="ikon2">
                    <img src="" alt="" class="ikon3">
                </div>
            </div>
-->
            <div id="col-right">
                <h2 class="title"></h2>
                <p class="description"></p>
            </div>
        </article>
    </main>
</section>


<script>
    let opskrift;
    // let episoder;
    let aktuelopskrift = <?php echo get_the_ID() ?>;
    console.log("opskrift:", aktuelopskrift);



    const dbUrl = "https://neanderpetersen.dk/kea/10_eksamen/veatery/wp-json/wp/v2/opskrift" + aktuelopskrift;
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
        document.querySelector(".description").textContent = opskrift.beskrivelse;
        //document.querySelector(".txt").textContent = podcast.beskrivelse;
        //        document.querySelector("img").src = opskrift.billede.guid;

    }


    //    function visEpisoder() {
    //        console.log("viserEpisoderne");
    //        let temp = document.querySelector("template");
    //        episoder.forEach(episode => {
    //            console.log("loop id:", aktuelpodcast);
    //            if (episode.horer_til_podcast[0].id == aktuelpodcast) {
    //                console.log("loop kører id:", aktuelpodcast);
    //                let klon = temp.cloneNode(true).content;
    //                klon.querySelector("h3").innerHTML = episode.title.rendered;
    //                klon.querySelector("img").src = episode.billede.guid;
    //                klon.querySelector(".beskrivelse").innerHTML = episode.episodenr;
    //
    //                klon.querySelector("article").addEventListener("click", () => {
    //                    location.href = episode.link;
    //                })
    //
    //                klon.querySelector("button").href = episode.link;
    //                console.log("episode", episode.link);
    //                container.appendChild(klon);
    //            }
    //        })
    //    }

    //tilbageKnap();
    //sendeplanKnap();

    //    function tilbageKnap() {
    //        document.querySelector(".singletilbage").addEventListener("click", visTilbage);
    //    }
    //
    //    function visTilbage() {
    //        window.history.back();
    //    }

    //    function sendeplanKnap() {
    //        document.querySelector("#sendeplan-knap").addEventListener("click", () => {
    //            window.location.href = "https://neanderpetersen.dk/kea/09_cms/radioloud/sendeplan/"
    //        })
    //    }

    getJson();

</script>

<?php get_footer(); ?>
