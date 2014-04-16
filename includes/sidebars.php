<?php

/**
 * Register the dynamic sidebar just for the job board
 */
register_sidebar( array(
    'id'          => 'job-board',
    'name'        => 'Job Board',
    'description' => 'This sidebar is used on only the Job Board pages.',
) );