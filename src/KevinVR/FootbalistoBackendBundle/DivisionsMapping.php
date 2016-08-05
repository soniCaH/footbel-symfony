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
            'BCD' => "Beker van Brabant (A)",
            'BPB' => "Beker van Brabant (B)",
            'N3B' => "3e Prov B",
            'N4D' => "4e Prov D",
            '3E' => "3e Prov E",
            '4G' => "4e Prov G",
            'N10J' => "U10 J",
            'N7AM' => "U7 AM",
            'N9M' => "U9 M",
            'N11I' => "U11 I",
            'N8M' => "U8 M",
            'N6H' => "U6 H",
        );

        if (array_key_exists($division_code, $mapping)) {
            return $mapping[$division_code];
        }
        else {
            return NULL;
        }
    }
}