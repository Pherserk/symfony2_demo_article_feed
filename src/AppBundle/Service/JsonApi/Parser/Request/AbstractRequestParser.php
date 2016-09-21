<?php

namespace AppBundle\Service\JsonApi\Parser\Request;


use AppBundle\Service\JsonApi\Deserializer\JsonRequestDeserializer;
use AppBundle\Service\JsonApi\Validator\JsonRequestValidator;
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
     * @param JsonRequestDeserializer $jrd
     */
    public function __construct(JsonRequestDeserializer $jrd)
    {
        $this->jrd = $jrd;
    }

    abstract public function parse(Request $request);
}
