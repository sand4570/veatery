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

<div class="page-style">
    <h1 class="voresh1">Uge 24</h1>
    <p>Hos Veatery arbejder vi med ugebaserede menuer, da alle vores retter er sæsonbaseret. <br>
        Du kan enten bestille til én dag, eller til hele ugen. <br> Bestilling skal foregå inden kl. 22.00 på dagen før, da vi kun laver et bestemt antal kuverter om dagen for at undgå madspil. </p>

    <section id="menu-main"></section>
</div>

<template>
    <article id="art-menu" class="article">
        <img src="" alt="" class="image">
        <div id="txt">
            <h2 class="title"></h2>
            <h3 class="subtite"></h3>
            <p class="beskrivelse"></p>
            <a href="https://neanderpetersen.dk/kea/10_eksamen/veatery/bestilling/">
                <button>BESTIL NU</button>
            </a>
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
