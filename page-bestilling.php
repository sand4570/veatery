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
    <h1 id="h1-bestilling" class="voresh1">Bestilling</h1>
    <p id="bestil-beskriv">Bestilling skal foregå inden kl. 22.00 dagen før, da vi kun laver et bestemt antal kuverter om dagen for at undgå madspil. <br>
        Maden skal afhentes på dagen på vores adresse i Kødbyen mellem kl. 17.00-18.30. <br>Vi bor i køkkenfællesskabet Kitchen Collective der er et start-upfælleskab med andre madiværksættere. <br> <br>

        Vil du bestille catering til et event eller en begivenhed? Så <a href="https://neanderpetersen.dk/kea/10_eksamen/veatery/kontakt/" class="kontaktos">kontakt os</a> gerne. </p>

    <!--    section om personlig information fra brugeren-->
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

        <!--        section hvor ordren laves-->
        <section id="order">
            <h2>Maden</h2>
            <div id="food-section"></div>
            <div id="peice-wrapper">
                <p>Samlet pris</p>
                <p id="samlet-pris">0 kr</p>
            </div>
        </section>

        <!--        section om levering-->
        <section id="delivery">
            <h2>Levering</h2>
            <input type="radio" id="del1" name="delivery" value="0">
            <label for="del1">Afhentning på Staldgade 11 (Gratis)</label><br>
            <input type="radio" id="del2" name="delivery" value="30">
            <label for="del2">Levering med byexpressen (30kr/km)</label>

        </section>

        <!--        section om betallingsmuligheder-->
        <section id="payment">
            <h2>Betaling</h2>
            <input type="radio" id="pay1" name="payment" value="0">
            <label for="pay1">Kontant ved afhentning</label><br>
            <input type="radio" id="pay2" name="payment" value="1">
            <label for="pay2">Mobilepay</label>

        </section>

        <!--        knap der gennemfører bestilling-->
        <a href="https://neanderpetersen.dk/kea/10_eksamen/veatery/tak/">
            <button class="bestilknap">BESTIL</button>
        </a>
    </div>
</div>

<!--template til visning af ordremulighedder -->
<template>
    <article id="art-order" class="article">
        <p id="day"></p>
        <p id="food"></p>
        <p id="pris"></p>
        <div id="counter">
            <!--            tilhørende knapper til tilføjelse/fjernelse af varer. id for opskriften lægges til en dataatribut i html elementet og verdien refereres til i knappernes onclick funktioner, så knappen kædes sammen med opskriften-->
            <button class="minus" data-order-amount="" onclick="minus(this.dataset.orderAmount)">-</button>
            <input type="number" id="order-amount-" class="amount" value="0" min=0>
            <button class="plus" data-order-amount="" onclick="plus(this.dataset.orderAmount)">+</button>
        </div>
    </article>
</template>

<script>
    //variabel som vi bruger til at sætte lig JSON data som vi senere henter
    let order;

    //Konstanter der definere elementer fra vores html
    const priceContainer = document.querySelector("#samlet-pris")
    const temp = document.querySelector("template");
    const foodSection = document.querySelector("#food-section");

    //Url vi bruger til at komme frem til vores json data via wordpress' restAPI
    const url = "https://neanderpetersen.dk/kea/10_eksamen/veatery/wp-json/wp/v2/menu?per_page=100";

    //Vi sikre at siden er loadrd og kører funktionen start
    document.addEventListener("DOMContentLoaded", start);

    //funktionen getJson køres
    function start() {
        getJson();
    }

    //Her benytter vi fetch til at hente json data for opskrifter, og sætter det derefter lig vores globale variant. funktionen showFood køres
    async function getJson() {
        let response = await fetch(url);
        order = await response.json();
        console.log(order);
        showFood();
    }

    //her vises de mulighedder man kan bestille, og knapper og priser tilføjes
    function showFood() {
        console.log(order);

        //Denne varabel tæller op hver gang loopet køre
        let stripeCounter = 1;

        //et forEach loop der indsætter dataen om opskriften i de ønskede fælter fra templaten
        order.forEach(order => {

            const klon = temp.cloneNode(true).content;

            //Vi tilføjer opskriftens id til den tilhørende input hvor kunden angiver hvor mange af retten man ønsker at købe
            klon.querySelector("#order-amount-").id += order.id;

            //Dataen om retten indsættes i templatens klon
            klon.querySelector("#day").textContent = order.title.rendered;
            klon.querySelector("#food").textContent = order.titel;
            klon.querySelector("#pris").innerHTML = order.pris + ' kr';

            //Her lægges id'et for retten til html elementerne/knapperne + og -
            klon.querySelector(".plus").dataset.orderAmount = order.id;
            klon.querySelector(".minus").dataset.orderAmount = order.id;

            //her benytter vi modulus til at sætte en class på hvert anden template klon. Det fungere ved at man dividere stripeCounter med 2 og hvis der er 0 i rest (tallet er lige) tilføjes en class
            if (stripeCounter % 2 == 0) {
                klon.querySelector("#art-order").classList.add("stripe");
            }

            Her sættes template klonen ind i foodSection
            foodSection.appendChild(klon);

            //stipecounter tæller op med 1 så den skiftevis er et lige eller ulige tal
            stripeCounter++;
        })

    }

    //denne funktion aktiveres via onclick i stedet for en eventListener
    function plus(id) {
        //Her får vi mængden af retter man har valgt til at gå op
        document.querySelector("#order-amount-" + id).stepUp(1);
        total();
    }

    //denne funktion aktiveres via 0nclick i stedet for en eventListener
    function minus(id) {
        //Her får vi mængden af retter man har valgt til at gå ned
        document.querySelector("#order-amount-" + id).stepDown(1);
        total();
    }

    //denne funktion udregner det totale beløb for det valgte antal retter
    function total() {
        let sum = 0;

        //Et forEach loop der gør at udregningen sker for alle retterne
        order.forEach(order => {

            //den totale pris udrenes ved at tage prisen for ordren som vi kan finde som json og og mængden af valgte for det specifikke id. begge laves om til tal ved at bruge Number
            sum += Number(order.pris) * Number(document.querySelector("#order-amount-" + order.id).value);
        });

        //Her udskrives den smalede pris på siden
        priceContainer.innerHTML = sum + ' kr';
    }

</script>





<?php get_footer(); ?>
