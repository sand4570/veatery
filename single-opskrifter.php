<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package OnePress
 */

get_header(); ?>

<section id="primary" class="content-area">
    <main id="main" class="site-main">
        <button class="singletilbage">Tilbage</button>

        <article>
            <div id="col-right">
                <img src="" alt="" class="billede">
                <div>
                    <p class="ingredeents"></p>
                    <img src="" alt="" class="ikon1">
                    <img src="" alt="" class="ikon2">
                    <img src="" alt="" class="ikon3">
                </div>
            </div>
            <div id="col-left">
                <h2 class="title"></h2>
                <p class="description"></p>
            </div>
        </article>
    </main>
</section>

<?php get_footer(); ?>
