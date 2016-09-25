<?php

namespace AppBundle\Service\JsonApi\Parser\Request;


use AppBundle\Service\JsonApi\Deserializer\JsonApiRequestDeserializer;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AbstractRequestParser
 * @package AppBundle\Service\JsonApi\Validator\Request
 */
abstract class AbstractRequestParser
{
    protected $jrd;

    /**
     * AbstractRequestValidator constructor.
     * @param JsonApiRequestDeserializer $jrd
     */
    public function __construct(JsonApiRequestDeserializer $jrd)
    {
        $this->jrd = $jrd;
    }

    abstract public function parse(Request $request);
}
