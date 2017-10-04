<?php
/**
 * Contains the Client interface.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-07-24
 *
 */


namespace Konekt\Client\Contracts;


interface Client
{
    /**
     * Update a client (also handles type conversion)
     *
     * @param array $attributes
     */
    public function updateClient(array $attributes);

    /**
     * Creates an individual client (along with underlying person object)
     * If is_active flag is unset, it defaults to true
     *
     * @param array $attributes
     *
     * @return static
     */
    public static function createIndividualClient(array $attributes);

    /**
     * Creates an individual client (along with underlying organization object)
     * If is_active flag is unset, it defaults to true
     *
     * @param array $attributes
     *
     * @return static
     */
    public static function createOrganizationClient(array $attributes);

    /**
     * Creates a client of the specified type
     *
     * @param ClientType        $type
     * @param array             $attributes
     *
     * @return static
     */
    public static function createClient(ClientType $type, array $attributes);

}