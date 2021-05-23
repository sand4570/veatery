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
<h1>Opskrifter</h1>

<nav id="filter">
    <button data-podcast="alle" class="valgt alleknap">Alle</button>
</nav>

<section id="recipe-main"></section>

<template>
    <article class="artickle">
        <img src="" alt="" class="image">
        <h2 class="title"></h2>
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
            document.querySelector("#filter").innerHTML += `<button class="filter" data-podcast="${cat.id}">${cat.name}</button>`

        })

        clickbutton();
    }


    function clickbutton() {
        console.log("clickbutton");
        document.querySelectorAll("#filter  button").forEach(elm => {
            elm.addEventListener("click", filtrering);
        })
    }


    function filtrering() {
        filterOps = this.dataset.podcast;
        console.log("filterOps");
        document.querySelector(".valgt").classList.remove("valgt");
        this.classList.add("valgt");


    }

    function showRecipe() {
        console.log(recipes);
        console.log("opskrifter");

        recipeMain.innerHTML = "";
        recipes.forEach(recipe => {
            if (filterOps == "alle" || recipes.categories.includes(parseInt(filterOps))) {

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
