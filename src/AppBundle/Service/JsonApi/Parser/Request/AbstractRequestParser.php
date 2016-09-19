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
    protected $rv;

    /**
     * AbstractRequestValidator constructor.
     * @param JsonRequestDeserializer $jrd
     * @param JsonRequestValidator $jrv
     */
    public function __construct(JsonRequestDeserializer $jrd, JsonRequestValidator $jrv)
    {
        $this->jrd = $jrd;
        $this->jrv = $jrv;
    }

    abstract public function parse(Request $request);
}
