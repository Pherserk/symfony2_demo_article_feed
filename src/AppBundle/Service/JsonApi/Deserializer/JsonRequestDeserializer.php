<?php

namespace AppBundle\Service\JsonApi\Deserializer;


use Symfony\Component\HttpFoundation\Request;

/**
 * Class JsonRequestDeserializer
 * @package AppBundle\Service\JsonApi\Deserializer
 */
class JsonRequestDeserializer
{
    public function deserialize(Request $request, $assoc = false)
    {
        return json_decode($request->getContent(), $assoc);
    }
}