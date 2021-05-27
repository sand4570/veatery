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

<head>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond&family=Noto+Sans+JP:wght@300;400;500&display=swap" rel="stylesheet">
</head>

<div class="page-style">

    <h1 class="voresh1">Opskrifter</h1>
    <p id="opskrift-beskrivelse">Her kan du få inspiration til hvordan du selv kan lave dine egne plantebaserede retter. <br> Retterne er udarbejdet af Team Veatery, og de er alle enten vegetariske eller veganske. <br> Vi har opdelt retterne i årstider, så du kan se hvilke råvarer der er i sæson.</p>

    <nav id="filter">
        <button data-opskrift="alle" class="valgt alleknap buttons">Alle opskrifter</button>
    </nav>

    <section id="recipe-main"></section>
</div>

<template>
    <article class="article opskrift-article">
        <div class="opskrift-div">
            <img id="opimg" src="" alt="" class="image">
            <h2 class="title voresh2"></h2>
        </div>
    </article>
</template>

<script>
    let recipes;
    let categories;
    let filterOps = "alle";

    const temp = document.querySelector("template");
    const recipeMain = document.querySelector("#recipe-main");

    const url = "https://neanderpetersen.dk/kea/10_eksamen/veatery/wp-json/wp/v2/opskrift?per_page=100";
    const catUrl = "https://neanderpetersen.dk/kea/10_eksamen/veatery/wp-json/wp/v2/categories";

    document.addEventListener("DOMContentLoaded", start);

    function start() {
        getJson();
    }

    async function getJson() {
        let response = await fetch(url);
        let catresponse = await fetch(catUrl);
        recipes = await response.json();
        categories = await catresponse.json();
        showRecipe();
        showButtons();
    }

    function showButtons() {


        categories.forEach(cat => {
            //if (cat.id == 12 || cat.id == 9 || cat.id == 10 ||cat.id == 11 ) {
            document.querySelector("#filter").innerHTML += `<button class="filter" data-opskrift="${cat.id}">${cat.name}</button>`
            //}
        })

        clickbutton();
    }


    function clickbutton() {
        console.log("clickbutton");
        document.querySelectorAll("#filter button").forEach(elm => {
            elm.addEventListener("click", filtrering);
        })
    }


    function filtrering() {
        filterOps = this.dataset.opskrift;
        console.log("filterOps");
        document.querySelector(".valgt").classList.remove("valgt");
        this.classList.add("valgt");

        showRecipe();

    }

    function showRecipe() {
        console.log(recipes);
        console.log("opskrifter");

        recipeMain.innerHTML = "";
        recipes.forEach(recipe => {
            if (filterOps == "alle" || recipe.categories.includes(parseInt(filterOps))) {

                const klon = temp.cloneNode(true).content;
                klon.querySelector("img").src = recipe.billede.guid;
                klon.querySelector("h2").textContent = recipe.title.rendered;
                klon.querySelector("article").addEventListener("click", () => {
                    location.href = recipe.link;
                })

                recipeMain.appendChild(klon);

            }
        })

    }

</script>





<?php get_footer(); ?>
