<?php

namespace AppBundle\Service\JsonApi\Parser\Request\User;


use AppBundle\Service\JsonApi\Deserializer\JsonRequestDeserializer;
use AppBundle\Service\JsonApi\Parser\Request\AbstractRequestParser;
use AppBundle\Service\JsonApi\Parser\Request\ValidatedRequest;
use AppBundle\Service\Validator\EmailValidator;
use AppBundle\Service\Validator\MobileNumberValidator;
use AppBundle\Service\Validator\PlainPasswordValidator;
use AppBundle\Service\Validator\UsernameValidator;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class NewUserRequestParser
 * @package AppBundle\Service\JsonApi\Validator\Request
 */
class NewUserRequestParser extends AbstractRequestParser
{
    /** @var UsernameValidator  */
    private $unv;
    /** @var PlainPasswordValidator  */
    private $ppv;
    /** @var EmailValidator  */
    private $ev;
    /** @var MobileNumberValidator  */
    private $mnv;

    /**
     * NewUserRequestValidator constructor.
     * @param UsernameValidator $unv
     * @param PlainPasswordValidator $ppv
     * @param EmailValidator $ev
     * @param MobileNumberValidator $mnv
     */
    public function __construct(
        JsonRequestDeserializer $jrd,
        UsernameValidator $unv,
        PlainPasswordValidator $ppv,
        EmailValidator $ev,
        MobileNumberValidator $mnv
    )
    {
        parent::__construct($jrd);

        $this->unv = $unv;
        $this->ppv = $ppv;
        $this->ev = $ev;
        $this->mnv = $mnv;
    }

    /**
     * @param request $request
     * @return ValidatedRequest
     * 
     */
    public function parse(Request $request)
    {
        $data = $this->jrd->deserialize($request, true);
        $errors = [];

        if (!isset($data['username'])) {
            $errors['username'][] = 'Missing field';
        } else {
            $usernameErrors = $this->unv->validate($data['username']);
            if (count($usernameErrors)) {
                $errors['username'] = $usernameErrors;
            }
        }

        if (!isset($data['password'])) {
            $errors['password'][] = 'Missing field';
        } else {
            $passwordErrors = $this->ppv->validate($data['password']);
            if (count($passwordErrors)) {
                $errors['password'] = $passwordErrors;
            }
        }

        if (!isset($data['email'])) {
            $errors['email'][] = 'Missing field';
        } else {
            $emailErrors = $this->ev->validate($data['email']);
            if (count($emailErrors)) {
                $errors['email'] = $emailErrors;
            }
        }

        if (!isset($data['mobileNumber'])) {
            $errors['mobileNumber'][] = 'Missing field';
        } else {
            $mobileNumberErrors = $this->mnv->validate($data['mobileNumber']);
            if (count($mobileNumberErrors)) {
                $errors['mobileNumber'] = $mobileNumberErrors;
            }
        }

        return new ValidatedRequest($data, $errors);
    }
}