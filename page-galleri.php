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

<div id="page-galleri" class="page-style">
    <h1 class="voresh1">Galleri</h1>
    <p id="galleribeskriv">I vores galleri kan du nyde de smukke, plantebaserede retter. <br>Hop forbi vores Instagram og se mere!</p>

    <section id="galleri-main"></section>

</div>

<template>
    <article class="article">
        <a href="https://www.instagram.com/veaterycph/" target="_blank">
            <img id="glimg" src="" alt="" class="image">
        </a>
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

        galleri.forEach(galleri => {

            const klon = temp.cloneNode(true).content;
            klon.querySelector("img").src = galleri.billede.guid;

            galleriMain.appendChild(klon);


        })

    }

</script>





<?php get_footer(); ?>
