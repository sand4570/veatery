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
<h1>Uge 24</h1>
<p>Her skal der skrives en beskrivelse</p>

<section id="menu-main"></section>

<template>
    <article class="article">
        <img src="" alt="" class="image">
        <div id="txt">
            <h2 class="title"></h2>
            <h3 class="subtitle"></h3>
            <p class="beskrivelse"></p>
        </div>
    </article>
</template>

<script>
    let menu;

    const temp = document.querySelector("template");
    const menuMain = document.querySelector("#menu-main");

    const url = "https://neanderpetersen.dk/kea/10_eksamen/veatery/wp-json/wp/v2/menu?per_page=100";

    document.addEventListener("DOMContentLoaded", start);

    function start() {
        getJson();
    }

    async function getJson() {
        let response = await fetch(url);
        menu = await response.json();
        console.log(menu);
        showMenu();
    }

    function showMenu() {
        console.log(menu);

        menu.forEach(menu => {

            const klon = temp.cloneNode(true).content;
            klon.querySelector("img").src = menu.billede.guid;
            klon.querySelector("h2").textContent = menu.title.rendered;
            klon.querySelector("h3").textContent = menu.titel;
            klon.querySelector("p").textContent = menu.beskrivelse;

            menuMain.appendChild(klon);
        })
    }

</script>





<?php get_footer(); ?>
