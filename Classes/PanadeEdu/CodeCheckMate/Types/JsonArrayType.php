<?php
namespace PanadeEdu\CodeCheckMate\Types;

/**
 * Array Type which can be used to generate json arrays.
 *
 * @author Florian Tatzel <panadeedu@googlemail.com>
 */
class JsonArrayType
{
    public function convertToDatabaseValue($value)
    {
        var_dump('db');
        if (null === $value) {
            return null;
        }

        return json_encode($value);
    }

    public function convertToPHPValue($value)
    {
        var_dump('php');
        if ($value === null) {
            return array();
        }

        $value = (is_resource($value)) ? stream_get_contents($value) : $value;

        return json_decode($value, true);
    }

    public function getName()
    {
        var_dump('name');
        return Type::JSON_ARRAY;
    }
}
