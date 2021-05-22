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

?>
<h1>Gallei</h1>
<p>Her skal der skrives en beskrivelse</p>

<section id="galleri-main"></section>

<template>
    <article class="article">
        <img src="" alt="" class="image">
    </article>
</template>

<script>
    let galleri;

    const temp = document.querySelector("template");
    const galleriMain = document.querySelector("#galleri-main");

    const url = "https://neanderpetersen.dk/kea/10_eksamen/veatery/wp-json/wp/v2/image?per_page=100";

    document.addEventListener("DOMContentLoaded", start);

    function start() {
        getJson();
    }

    async function getJson() {
        let response = await fetch(url);
        galleri = await response.json();
        console.log(galleri);
        showGalleri();
    }

    function showGalleri() {
        console.log(galleri);

        galleri.forEach(galleri=> {

                const klon = temp.cloneNode(true).content;
                klon.querySelector("img").src = galleri.billede.guid;

                galleriMain.appendChild(klon);


        })

    }

</script>





<?php get_footer(); ?>
