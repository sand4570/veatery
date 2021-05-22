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
<h1>Bestilling</h1>

<section id="info">
    <h2>Personlig information</h2>
    <div id="info-container">
        <p>Fornavn</p>
        <input id="f-name" type="text">
        <p>Efternavn</p>
        <input id="e-name" type="text">
        <p>E-mail</p>
        <input id="mail" type="email">
        <p>Telefon</p>
        <input id="phone" type="tel">
    </div>
</section>

<section id="order">
    <h2>Maden</h2>
    <div id="food-section"></div>
    <p>Samlet pris</p>
</section>

<section id="delivery">
    <h2>Levering</h2>
    <input type="radio" id="del1" name="delivery" value="0">
    <label for="del1">Afhentning på Slagtehusgade 11 (Gratis)</label><br>
    <input type="radio" id="del2" name="delivery" value="30">
    <label for="del2">Levering med byexpressen (30kr/km)</label>

</section>

<section id="payment">
    <h2>Betalling</h2>
    <input type="radio" id="pay1" name="payment" value="0">
    <label for="del1">Kontant ved afhentning</label><br>
    <input type="radio" id="del2" name="delivery" value="1">
    <label for="del2">Mobilepay</label>

</section>

<template>
    <article class="article">
        <p id="day"></p>
        <p id="food"></p>
        <input type="number">
    </article>
</template>

<script>
    let order;

    const temp = document.querySelector("template");
    const foodSection = document.querySelector("#food-section");

    const url = "https://neanderpetersen.dk/kea/10_eksamen/veatery/wp-json/wp/v2/menu?per_page=100";

    document.addEventListener("DOMContentLoaded", start);

    function start() {
        getJson();
    }

    async function getJson() {
        let response = await fetch(url);
        order = await response.json();
        console.log(order);
        showFood();
    }

    function showFood() {
        console.log(order);

        order.forEach(order => {

            const klon = temp.cloneNode(true).content;
            klon.querySelector("#day").textContent = order.title.rendered;
            klon.querySelector("#food").textContent = order.titel;

            foodSection.appendChild(klon);

        })

    }

</script>





<?php get_footer(); ?>
