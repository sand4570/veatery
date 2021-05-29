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

<!--links til de google fonte vi benytter på siden-->
<head>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond&family=Noto+Sans+JP:wght@300;400;500&display=swap" rel="stylesheet">
</head>


<div class="page-style">
    <!--    overskrift og beskrivelse på siden-->
    <h1 id="h1-menu" class="voresh1">Uge 24</h1>
    <p id="menu-beskrivelse">Hos Veatery arbejder vi med ugentlige menuer, da alle vores retter er sæsonbaseret. Hele menuen er vegetarisk med veganske alternativer. <br>
        Du kan enten bestille til én dag, eller til hele ugen, og til det antal personer du ønsker. <br>
        Husk at forudbestille din takeaway da vi altid har et max antal portion vi kan producere på en dag.
    </p>

<!--    Section hvor ugens menu loades ind-->
    <section id="menu-main"></section>
</div>

<!--template til visning af menuen -->
<template>
    <article id="art-menu" class="article">
        <img src="" alt="" class="menu-image">
        <div id="txt">
            <h2 id="h2-menu" class="title"></h2>
            <h3 class="subtite voresh3"></h3>
            <p class="beskrivelse"></p>
            <a href="https://neanderpetersen.dk/kea/10_eksamen/veatery/bestilling/">
                <button class="menubutton">BESTIL NU</button>
            </a>
        </div>
    </article>
</template>

<script>
    //variabel som vi bruger til at sætte lig JSON data som vi senere henter
    let menu;

    //Konstanter der definere elementer fra vores html
    const temp = document.querySelector("template");
    const menuMain = document.querySelector("#menu-main");

    //Url vi bruger til at komme frem til vores json data via wordpress' restAPI
    const url = "https://neanderpetersen.dk/kea/10_eksamen/veatery/wp-json/wp/v2/menu?per_page=100";

    //Vi sikre at siden er loadrd og kører funktionen start
    document.addEventListener("DOMContentLoaded", start);

    //funktionen getJson køres
    function start() {
        getJson();
    }

    //Her benytter vi fetch til at hente json data for opskrifter, og sætter det derefter lig vores globale variant. funktionen showMenu køres
    async function getJson() {
        let response = await fetch(url);
        menu = await response.json();
        console.log(menu);
        showMenu();
    }

    //Her vises menuerne for de forskellige dage
    function showMenu() {
        console.log(menu);

        menu.forEach(menu => {

            //menuerne tilføjes til klonen af templaten
            const klon = temp.cloneNode(true).content;
            klon.querySelector("img").src = menu.billede.guid;
            klon.querySelector("h2").textContent = menu.title.rendered;
            klon.querySelector("h3").textContent = menu.titel;
            klon.querySelector("p").textContent = menu.beskrivelse;

            //Indholdet vises på siden
            menuMain.appendChild(klon);
        })
    }

</script>





<?php get_footer(); ?>
