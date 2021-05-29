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
    <h1 class="voresh1">Opskrifter</h1>
    <p id="opskrift-beskrivelse">Her kan du få inspiration til hvordan du selv kan lave dine egne plantebaserede retter. <br> Retterne er udarbejdet af Team Veatery, og de er alle enten vegetariske eller veganske. <br> Vi har opdelt retterne i årstider, så du kan se hvilke råvarer der er i sæson.</p>

<!--    Her laves knappen, der viser alle opskrifter, og den får class = valgt-->
    <nav id="filter">
        <button data-opskrift="alle" class="valgt alleknap buttons">Alle opskrifter</button>
    </nav>

    <!--    Section hvor opskrifterne loades ind-->
    <section id="recipe-main"></section>
</div>

<!--template til visning af opskrifterne -->
<template>
    <article class="article opskrift-article">
        <div class="opskrift-div">
            <img id="opimg" src="" alt="" class="image">
            <h2 class="title voresh2"></h2>
        </div>
    </article>
</template>

<script>
    //variabler som vi bruger til at sætte lig JSON data som vi senre henter
    let recipes;
    let categories;
    let filterOps = "alle";

    //Konstanter der definere elementer fra vores html
    const temp = document.querySelector("template");
    const recipeMain = document.querySelector("#recipe-main");

    //Url'er vi bruger til at komme frem til vores json data via wordpress' restAPI
    const url = "https://neanderpetersen.dk/kea/10_eksamen/veatery/wp-json/wp/v2/opskrift?per_page=100";
    const catUrl = "https://neanderpetersen.dk/kea/10_eksamen/veatery/wp-json/wp/v2/categories";

    //Vi sikre at siden er loadrd og kører funktionen start
    document.addEventListener("DOMContentLoaded", start);

    //funktionen getJson køres
    function start() {
        getJson();
    }

    //Her benytter vi fetch til at hente json data for opskrifter og tags, og sætter det derefter lig vores globale variabler. funktionerne showRecipe og showButtons køres
    async function getJson() {
        let response = await fetch(url);
        let catresponse = await fetch(catUrl);
        recipes = await response.json();
        categories = await catresponse.json();
        showRecipe();
        showButtons();
    }

    //Her tilføjer vi knapper til filtrering
    function showButtons() {

        //For each loop, der for hver categori, der er oprettet i wordpress, opretter en knap i nav menuen. knappen får tekst alt efter hvilket name den har i wordpress.
        categories.forEach(cat => {

            document.querySelector("#filter").innerHTML += `<button class="filter" data-opskrift="${cat.id}">${cat.name}</button>`
        })

        //funktionen clickbutton køres
        clickbutton();
    }


    //denne funktion gør knapperne i menuen klikbare
    function clickbutton() {
        console.log("clickbutton");
        document.querySelectorAll("#filter button").forEach(elm => {
            elm.addEventListener("click", filtrering);
        })
    }


    //Når der klikkes på knappen bliver der kun vist de opskrifter der indeholder den valgte kategori
    function filtrering() {
        //filterOps sættes lig den valgte kategori
        filterOps = this.dataset.opskrift;
        console.log("filterOps");

        //Klassen valgt fjernes fra tidligere elementer og tilføjes der hvor der er klikket
        document.querySelector(".valgt").classList.remove("valgt");
        this.classList.add("valgt");

        //funktionen showRecipe køres
        showRecipe();

    }

    //Her vises menuerne for de forskellige opskrifter
    function showRecipe() {
        console.log(recipes);
        console.log("opskrifter");

        recipeMain.innerHTML = "";
        recipes.forEach(recipe => {

            //Hvis filterops er lig alle eller hvis opskriften indeholder den kategori der er lig filterOps, udskrives de på siden
            if (filterOps == "alle" || recipe.categories.includes(parseInt(filterOps))) {

                //opskrifterne tilføjes til klonen af templaten
                const klon = temp.cloneNode(true).content;
                klon.querySelector("img").src = recipe.billede.guid;
                klon.querySelector("h2").textContent = recipe.title.rendered;
                klon.querySelector("article").addEventListener("click", () => {
                    location.href = recipe.link;
                })

                //Indholdet vises på siden
                recipeMain.appendChild(klon);

            }
        })

    }

</script>





<?php get_footer(); ?>
