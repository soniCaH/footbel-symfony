<?php

namespace KevinVR\FootbalistoBackendBundle;


/**
 * Class DivisionsMapping
 * @package KevinVR\FootbalistoBackendBundle
 */
class DivisionsMapping {
    /**
     * Map a shorthand division code to a managed human-readable name.
     *
     * @param string $division_code
     *   Shorthand division code as saved in the database.
     *
     * @return string|null
     *   Authored mapping of the shorthand > full division description/name.
     */
    public static function getMapping($division_code) {
        static $mapping = array(
            'BCD' => "Beker van Brabant (A ploeg)",
            'BPB' => "Beker van Brabant (B ploeg)",
            'N3B' => "3e Provinciale B",
            'N4D' => "4e Provinciale D",
            '3E' => "3e Provinciale E",
            '4G' => "4e Provinciale G",
            'N10J' => "U10 - Reeks J",
            'N7AM' => "U7 - Reeks AM",
            'N9M' => "U9 - Reeks M",
            'N11I' => "U11 - Reeks I",
            'N8M' => "U8 - Reeks M",
            'N6H' => "U6 - Reeks H",
        );

        if (array_key_exists($division_code, $mapping)) {
            return $mapping[$division_code];
        }
        else {
            return NULL;
        }
    }
}