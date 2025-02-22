<?php
function formatLyrics($lyrics)
{
    $lines = explode("\n", $lyrics);
    $formattedLyrics = array_map(
        function ($line, $index) {
            return $line . ($index % 4 === 4 ? "<br><br>" : "<br>");
        },
        $lines,
        array_keys($lines)
    );

    return implode("", $formattedLyrics);
}
