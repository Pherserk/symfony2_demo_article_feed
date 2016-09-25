<?php

namespace AppBundle\Service\JsonApi\Parser\Request\User;


use AppBundle\Service\JsonApi\Deserializer\JsonApiRequestDeserializer;
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
        JsonApiRequestDeserializer $jrd,
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
        $deserializedRequest = $this->jrd->deserialize($request);
        $errors = [];

        if (!isset($deserializedRequest->data)) {
            $errors['data'][] = 'Missing field';
        } else {
            if (!isset($deserializedRequest->data->type)) {
                $errors['data']['type'][] = 'Missing field';
            } else if ($deserializedRequest->data->type !== 'users') {
                $errors['data']['type'][] = sprintf('Expected users, got %s', $deserializedRequest->data->type);
            }

            if (!isset($deserializedRequest->data->attributes)) {
                $errors['data']['attributes'][] = 'Missing field';
            } else {
                if (!isset($deserializedRequest->data->attributes->username)) {
                    $errors['data']['attributes']['username'][] = 'Missing field';
                } else {
                    $usernameErrors = $this->unv->validate($deserializedRequest->data->attributes->username);
                    if (count($usernameErrors)) {
                        $errors['data']['attributes']['username'] = $usernameErrors;
                    }
                }

                if (!isset($deserializedRequest->data->attributes->password)) {
                    $errors['data']['attributes']['password'][] = 'Missing field';
                } else {
                    $passwordErrors = $this->ppv->validate($deserializedRequest->data->attributes->password);
                    if (count($passwordErrors)) {
                        $errors['data']['attributes']['password'] = $passwordErrors;
                    }
                }

                if (!isset($deserializedRequest->data->attributes->email)) {
                    $errors['data']['attributes']['email'][] = 'Missing field';
                } else {
                    $emailErrors = $this->ev->validate($deserializedRequest->data->attributes->email);
                    if (count($emailErrors)) {
                        $errors['data']['attributes']['email'] = $emailErrors;
                    }
                }

                if (!isset($deserializedRequest->data->attributes->mobileNumber)) {
                    $errors['data']['attributes']['mobileNumber'][] = 'Missing field';
                } else {
                    $mobileNumberErrors = $this->mnv->validate($deserializedRequest->data->attributes->mobileNumber);
                    if (count($mobileNumberErrors)) {
                        $errors['data']['attributes']['mobileNumber'] = $mobileNumberErrors;
                    }
                }
            }
        }

        return new ValidatedRequest($deserializedRequest, $errors);
    }
}
