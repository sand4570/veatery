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
    <h1 id="h1-bestilling" class="voresh1">Bestilling</h1>
    <p id="bestil-beskriv">Bestilling skal foregå inden kl. 22.00 dagen før, da vi kun laver et bestemt antal kuverter om dagen for at undgå madspil. <br>
        Maden skal afhentes på dagen på vores adresse i Kødbyen mellem kl. 17.00-18.30. <br>Vi bor i køkkenfællesskabet Kitchen Collective der er et start-upfælleskab med andre madiværksættere. <br> <br>

        Vil du bestille catering til et event eller en begivenhed? Så <a href="https://neanderpetersen.dk/kea/10_eksamen/veatery/kontakt/" class="kontaktos">kontakt os</a> gerne. </p>

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
            <div id="peice-wrapper">
                <p>Samlet pris</p>
                <p id="samlet-pris">0 kr</p>
            </div>
        </section>

        <section id="delivery">
            <h2>Levering</h2>
            <input type="radio" id="del1" name="delivery" value="0">
            <label for="del1">Afhentning på Slagtehusgade 11 (Gratis)</label><br>
            <input type="radio" id="del2" name="delivery" value="30">
            <label for="del2">Levering med byexpressen (30kr/km)</label>

        </section>

        <section id="payment">
            <h2>Betaling</h2>
            <input type="radio" id="pay1" name="payment" value="0">
            <label for="pay1">Kontant ved afhentning</label><br>
            <input type="radio" id="pay2" name="payment" value="1">
            <label for="pay2">Mobilepay</label>

        </section>

        <a href="https://neanderpetersen.dk/kea/10_eksamen/veatery/tak/">
            <button class="bestilknap">BESTIL</button>
        </a>
    </div>
</div>

<template>
    <article id="art-order" class="article">
        <p id="day"></p>
        <p id="food"></p>
        <p id="pris"></p>
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

    const priceContainer = document.querySelector("#samlet-pris")
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
        let stripeCounter = 1;

        order.forEach(order => {

            const klon = temp.cloneNode(true).content;
            klon.querySelector("#order-amount-").id += order.id;
            klon.querySelector("#day").textContent = order.title.rendered;
            klon.querySelector("#food").textContent = order.titel;
            klon.querySelector("#pris").innerHTML = order.pris + ' kr';

            klon.querySelector(".plus").dataset.orderAmount = order.id;
            klon.querySelector(".minus").dataset.orderAmount = order.id;

            if (stripeCounter % 2 == 0) {
                klon.querySelector("#art-order").classList.add("stripe");
            }

            foodSection.appendChild(klon);

            stripeCounter++;
            idCounter++;
        })

    }

    function plus(id) {
        document.querySelector("#order-amount-" + id).stepUp(1);
        total();
    }

    function minus(id) {
        document.querySelector("#order-amount-" + id).stepDown(1);
        total();
    }

    function total() {
        let sum = 0;
        order.forEach(order => {
            sum += Number(order.pris) * Number(document.querySelector("#order-amount-" + order.id).value);
        });

        priceContainer.innerHTML = sum + ' kr';
    }

</script>





<?php get_footer(); ?>
