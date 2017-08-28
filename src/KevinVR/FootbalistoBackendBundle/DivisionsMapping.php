<?php

namespace KevinVR\FootbalistoBackendBundle;


/**
 * Class DivisionsMapping
 * @package KevinVR\FootbalistoBackendBundle
 */
class DivisionsMapping
{
    /**
     * Map a shorthand division code to a managed human-readable name.
     *
     * @param string $division_code
     *   Shorthand division code as saved in the database.
     *
     * @return string|null
     *   Authored mapping of the shorthand > full division description/name.
     */
    public static function getMapping($division_code)
    {
        static $mapping = array(
          'BCD' => "Beker van Brabant (A ploeg)",
          'BPB' => "Beker van Brabant (B ploeg)",
          'N3B' => "3e Provinciale B",
          'N4D' => "4e Provinciale D",
          '4D' => "4e Provinciale D",
          '3C' => "3e Provinciale C",
          '3E' => "3e Provinciale E",
          '4G' => "4e Provinciale G",
          'N10J' => "U10 - Reeks J",
          'N7AM' => "U7 - Reeks AM",
          'N9M' => "U9 - Reeks M",
          'N11I' => "U11 - Reeks I",
          'N8M' => "U8 - Reeks M",
          'N6H' => "U6 - Reeks H",
          'N10H2' => "U10 - Reeks J",
          'N7AM2' => "U7 - Reeks AM",
          'N9J2' => "U9 - Reeks J",
          'N11F2' => "U11 - Reeks F",
          'N8L2' => "U8 - Reeks L",
          '8K1' => "U8 - Reeks K",
          '12H1' => "U12 - Reeks H",
          '11L1' => "U11 - Reeks L",
          '10P1' => "U10 - Reeks P",
          '7X1' => "U7 - Reeks X",
          '9S1' => "U9 - Reeks S",
          '9N1' => "U9 - Reeks N",
        );

        if (array_key_exists($division_code, $mapping)) {
            return $mapping[$division_code];
        } else {
            return null;
        }
    }
}