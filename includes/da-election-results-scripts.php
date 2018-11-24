<?php

// Add Scripts

function da_election_results_add_scripts() {
	//Add Main CSS
	wp_enqueue_style( 'da-election-results-style', plugins_url().'/da-election-results/assets/css/style.css' );
	//Add Main JS
	wp_enqueue_script( 'da-election-results-script', plugins_url().'/da_election-results/assets/js/script.js' );
}

add_action( 'wp_enqueue_scripts', 'da_election_results_add_scripts' ); 