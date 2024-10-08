<?php
declare(strict_types=1);
/**
 * This file is part of microGears\Stdlib.
 *
 * (C) 2009-2024 Maxim Kirichenko <kirichenko.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 namespace WebStone\Stdlib\Helpers;

/**
 * This class provides helper methods for working with arrays.
 */
class ArrayHelper
{
    /**
     * Retrieves the value of a specified key from an array.
     *
     * @param mixed $key The key to retrieve the value for.
     * @param array $haystack The array to search for the key.
     * @param mixed $default The default value to return if the key is not found (optional).
     * @param mixed $expected_type The expected type of the value (optional).
     * @return mixed The value of the specified key, or the default value if the key is not found.
     */
    public static function element($key, array $haystack, $default = false, $expected_type = null):mixed
    {
        if (!is_array( $haystack )) {
            return $default;
        }

        $result = $default;
        if (array_key_exists( $key, $haystack )) {
            if (in_array( $expected_type, TypeHelper::TYPES )) {
                if (TypeHelper::isType( $haystack[$key], $expected_type )) {
                    $result = $haystack[$key];
                }
            } else {
                $result = $haystack[$key];
            }
        }

        return $result;
    }

    
    /**
     * Extracts specified elements from an array.
     *
     * @param mixed $keys The keys of the elements to extract.
     * @param array $haystack The array to extract elements from.
     * @param mixed $default The default value to return if an element is not found.
     * @param mixed $expected_type The expected type of the extracted elements.
     * @param bool $keys_preserve Whether to preserve the keys of the extracted elements.
     * @return array The extracted elements as an associative array.
     */
    public static function elements(mixed $keys, array $haystack,mixed $default = false, mixed $expected_type = null, bool $keys_preserve = false):array
    {
        if (!is_array( $haystack )) {
            return $haystack;
        }

        $result = [];

        if (!is_array( $keys )) {
            $keys = [$keys];
        }
        $keysCount = count( $keys );

        if (!is_array( $default )) {
            $default = array_fill( 0, $keysCount, $default );
        }

        if (!is_array( $expected_type )) {
            $expected_type = array_fill( 0, $keysCount, $expected_type );
        }

        for ($i = 0; $i < $keysCount; $i++) {
            $keyPlaceholder = isset( $default[$i] ) ? $default[$i] : null;
            if (array_key_exists( $keys[$i], $haystack )) {
                $keyValue = $haystack[$keys[$i]];
                if (isset( $expected_type[$i] ) && in_array( $expected_type[$i], TypeHelper::TYPES )) {
                    if (!TypeHelper::isType( $haystack[$keys[$i]], $expected_type[$i] )) {
                        $keyValue = $keyPlaceholder;
                    }
                }

                if ($keys_preserve == true) {
                    $result[$keys[$i]] = $keyValue;
                } else {
                    $result[] = $keyValue;
                }
            } else {
                if ($keys_preserve == true) {
                    $result[$keys[$i]] = $keyPlaceholder;
                } else {
                    $result[] = $keyPlaceholder;
                }
            }
        }

        return $result;
    }

    /**
     * Filters an array by removing specified elements.
     *
     * @param mixed $keys The keys of the elements to remove.
     * @param array $haystack The array to filter.
     * @return array The filtered array.
     */
    public static function filter(mixed $keys, array $haystack):array
    {
        if (!is_array( $haystack )) {
            return $haystack;
        }

        $result = [];

        if (!is_array( $keys )) {
            $keys = [$keys];
        }

        foreach ($haystack as $key => $value) {
            if (!in_array( $key, $keys )) {
                $result[$key] = $value;
            }
        }

        return $result;
    }
    
    /**
     * Get the first key of the given array without affecting
     * the internal array pointer.
     *
     * @param array $array
     *
     * @return mixed|null
     */
    public static function keyFirst(array $array):mixed
    {
        if (is_array( $array ) && count( $array )) {
            reset( $array );

            return key( $array );
        }

        return null;
    }

    /**
     * Get the last key of the given array without affecting
     * the internal array pointer.
     *
     * @param array $array
     *
     * @return mixed|null
     */
    public static function keyLast(array $array):mixed
    {
        $result = null;
        if (is_array( $array )) {
            end( $array );
            $result = key( $array );
        }

        return $result;
    }


    /**
     * Checks if all the specified keys exist in the given array.
     *
     * @param array $keys The keys to check for existence.
     * @param array $haystack The array to search for the keys.
     * @return bool Returns true if all the keys exist, false otherwise.
     */
    public static function keysExists(array $keys, array $haystack):bool
    {
        return count( array_intersect_key( array_flip( $keys ), $haystack ) ) > 0;
    }


    /**
     * Searches for a value in an array.
     *
     * @param mixed $needle The value to search for.
     * @param array $haystack The array to search in.
     * @param bool $strict (optional) Whether to perform a strict comparison. Default is false.
     * @param mixed $column (optional) The column to search in multi-dimensional arrays. Default is null.
     * @return mixed|false The key of the found element, or false if not found.
     */
    public static function search(mixed $needle, array $haystack, bool $strict = false, mixed $column = null)
    {
        return array_search( $needle, $column !== null ? array_column( $haystack, $column ) : $haystack, $strict );
    }

}

/* End of file ArrayHelper.php */
