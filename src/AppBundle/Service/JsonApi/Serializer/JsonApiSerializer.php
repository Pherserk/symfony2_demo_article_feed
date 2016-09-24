<?php

namespace AppBundle\Service\JsonApi\Serializer;


use Doctrine\Common\Persistence\Proxy;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class JsonApiSerializer
 * @package AppBundle\Service\JsonApi\Serializer
 */
class JsonApiSerializer
{
    /** @var EntityManagerInterface $em */
    private $em;

    /**
     * JsonApiSerializer constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param $payLoad
     * @return string
     */
    public function serialize($payLoad, $type)
    {
        $serializedPayload = new \stdClass();
        $serializedPayload->data = new \stdClass();

        $serializedPayload->data->type = $type;

        if ($this->isDoctrineEntity($payLoad)) {
            $this->addEntityColumnValues($serializedPayload, $payLoad);
        }

        return json_encode($serializedPayload);
    }

    private function isDoctrineEntity($payLoad)
    {
        if (is_object($payLoad)) {
            $payLoad = ($payLoad instanceof Proxy)
                ? get_parent_class($payLoad)
                : get_class($payLoad);
        }

        return !$this->em->getMetadataFactory()->isTransient($payLoad);
    }

    private function addEntityColumnValues(&$serializedPayload, $entity)
    {
        $classMetaData = $this->em->getClassMetadata(get_class($entity));
        $columnNames = $classMetaData->getColumnNames();
        $attributes = new \stdClass();
        foreach ($columnNames as $columnName){
            $fieldName = $classMetaData->getFieldForColumn($columnName);
            $getter = 'get'.ucfirst($fieldName);
            if ($fieldName === $classMetaData->getIdentifier()[0]) {
                $serializedPayload->data->id = $entity->$getter();
            } else {
                $attributes->$columnName = $entity->$getter();
            }
        }

        if (count($attributes) > 0) {
            $serializedPayload->data->attributes = $attributes;
        }
    }
}
