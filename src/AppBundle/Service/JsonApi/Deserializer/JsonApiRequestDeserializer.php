<?php

namespace AppBundle\Service\JsonApi\Deserializer;


use Symfony\Component\HttpFoundation\Request;

/**
 * Class JsonApiRequestDeserializer
 * @package AppBundle\Service\JsonApi\Deserializer
 */
class JsonApiRequestDeserializer
{
    public function deserialize(Request $request, $assoc = false)
    {
        return json_decode($request->getContent(), $assoc);
    }
}
