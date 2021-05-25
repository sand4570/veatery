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
<h1 id="h1-bestilling" class="voresh1">Bestilling</h1>

<div id="bestilling-style">
<section id="info">
    <h2>Personlig information</h2>
    <div id="info-container">
        <label for="f-name" id="p1">Fornavn</label>
        <input id="f-name" type="text">
        <p id="p2">Efternavn</p>
        <input id="e-name" type="text">
        <p id="p3">E-mail</p>
        <input id="mail" type="email">
        <p id="p4">Telefon</p>
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
    <label for="pay1">Kontant ved afhentning</label><br>
    <input type="radio" id="pay2" name="payment" value="1">
    <label for="pay2">Mobilepay</label>

</section>
</div>
</div>

<template>
    <article id="art-order" class="article">
        <p id="day"></p>
        <p id="food"></p>
        <div id="counter">
            <button class="minus" data-order-amount="" onclick="minus(this.dataset.orderAmount)">-</button>
            <input type="number" id="order-amount-" class="amount" value="0" min=0>
            <button class="plus" data-order-amount="" onclick="plus(this.dataset.orderAmount)">+</button>
        </div>
    </article>
</template>

<script>
    let order;
    let count = 0

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

        let idCounter = 1;

        order.forEach(order => {

            const klon = temp.cloneNode(true).content;
            klon.querySelector("#order-amount-").id += idCounter;
            klon.querySelector("#day").textContent = order.title.rendered;
            klon.querySelector("#food").textContent = order.titel;

            klon.querySelector(".plus").dataset.orderAmount = idCounter;
            klon.querySelector(".minus").dataset.orderAmount = idCounter;

            foodSection.appendChild(klon);


            idCounter++;
        })

    }

    function plus(id) {
        document.querySelector("#order-amount-" + id).stepUp(1);
    }

    function minus(id) {
        document.querySelector("#order-amount-" + id).stepDown(1);
    }

</script>





<?php get_footer(); ?>
