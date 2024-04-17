<?php

require_once base_path('/app/Blasta/Classes/Body.php');

/**
 * Runs just after the opening body tag
 */
function startBody()
{
    // $body = Body::getInstance();
    return Body::getPrepends();
}

/**
 * Runs just before the closing body tag
 */
function endBody()
{
    // $body = Body::getInstance();
    return Body::getAppends();
}

/**
 * Appends to body
 */
function appendToBody(string $entity)
{
    // $body = Body::getInstance();
    Body::append($entity);
}

/**
 * Prepends to body
 */
function prependToBody(string $entity)
{
    // $body = Body::getInstance();
    Body::prepend($entity);
}
