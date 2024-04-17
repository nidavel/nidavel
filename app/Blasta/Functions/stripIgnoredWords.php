<?php

function stripIgnoredWords(string $str) : string
{
    $words = [
        "a", "all", "also", "am", "an", "and", "any", "are", "as", "at", "be", "because",
        "been", "could", "did", "do", "does", "e.g.", "ever", "from", "had", "hardly",
        "has", "have", "having", "he", "hence", "her", "here", "hereby", "herein", "hereof",
        "hereon", "hereto", "herewith", "him", "his", "however", "i.e.", "if", "in", "into", "is",
        "it", "its", "me", "my", "no", "of", "on", "onto", "our", "really", "said",
        "she", "should", "so", "some", "such", "than", "that", "the", "their", "them",
        "then", "there", "thereby", "therefore", "therefrom", "therein", "thereof", "thereon", "thereto", "therewith",
        "these", "they", "this", "those", "thus", "to", "too", "unto", "us", "very",
        "viz", "was", "we", "were", "what", "when", "where", "wherever", "wherein", "whether",
        "which", "who", "whom", "whose", "why", "with", "would", "you", "i"
    ];

    $strChunks = explode(' ', $str);
    $newStrChunks = [];

    foreach ($strChunks as $strChunk) {
        if (in_array(strtolower($strChunk), $words)) {
            continue;
        }
        $newStrChunks[] = $strChunk;
    }

    $str = implode(' ', $newStrChunks);

    return $str;
}
