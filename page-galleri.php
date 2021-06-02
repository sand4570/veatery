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
<!--    Overskrift og beskrivelse på siden-->
    <h1 id="gallerih1" class="voresh1">Galleri</h1>
    <p id="galleribeskriv">I vores galleri kan du nyde de smukke, plantebaserede retter. <br>Hop forbi vores Instagram og se mere!</p>

<!--    Section hvor indholdet skal sættes ind-->
    <section id="galleri-main"></section>

</div>

<!--template til indholdet som kan klones-->
<template>
    <article class="article">
        <a href="https://www.instagram.com/veaterycph/" target="_blank">
            <img id="glimg" src="" alt="" class="image">
        </a>
    </article>
</template>

<script>
    //variabel som vi bruger til at sætte lig JSON data som vi senre henter
    let galleri;

    //Konstanter der definere elementer fra vores html
    const temp = document.querySelector("template");
    const galleriMain = document.querySelector("#galleri-main");

    //Url vi bruger til at komme frem til vores json data via wordpress' restAPI
    const url = "https://neanderpetersen.dk/kea/10_eksamen/veatery/wp-json/wp/v2/image?per_page=100";

    //Vi sikre at siden er loadrd og kører funktionen start
    document.addEventListener("DOMContentLoaded", start);

    //funktionen getJson køres
    function start() {
        getJson();
    }

    //Her benytter vi fetch til at hente json data for billeder, og sætter det derefter lig vores globale variant. funktionen showGalleri køres
    async function getJson() {
        let response = await fetch(url);
        galleri = await response.json();
        console.log(galleri);
        showGalleri();
    }

    //Her vises alle billederne
    function showGalleri() {
        console.log(galleri);

        galleri.forEach(galleri => {

            //Billet tilføjes til klonen af templaten
            const klon = temp.cloneNode(true).content;
            klon.querySelector("img").src = galleri.billede.guid;

            //Indholdet vises på siden
            galleriMain.appendChild(klon);


        })

    }

</script>





<?php get_footer(); ?>
