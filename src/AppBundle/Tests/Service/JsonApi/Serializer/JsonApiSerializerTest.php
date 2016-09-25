<?php

namespace AppBundle\Tests\Service\JsonApi\Serializer;


use AppBundle\Entity\UserRole;
use AppBundle\Service\JsonApi\Serializer\JsonApiSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\ClassMetadataFactory;
use Prophecy\Argument;

class JsonApiSerializerTest extends \PHPUnit_Framework_TestCase
{
    public function testSerialize_not_persisted_entity()
    {
        $payLoad = new UserRole('ROLE_BANANA');

        /** @var ClassMetadataFactory $mdf */
        $mdf = self::prophesize(ClassMetadataFactory::class);
        $mdf->isTransient(Argument::any())->willReturn(false);
        $mdf = $mdf->reveal();

        $columnNames = [
            'id',
            'role',
            'created_at',
        ];

        /** @var ClassMetadata $cmd */
        $cmd = self::prophesize(ClassMetadata::class);
        $cmd->getColumnNames()->willReturn($columnNames);
        $cmd->getFieldForColumn('id')->willReturn('id');
        $cmd->getFieldForColumn('role')->willReturn('role');
        $cmd->getFieldForColumn('created_at')->willReturn('createdAt');
        $cmd->getIdentifier()->willReturn(['id']);
        $cmd = $cmd->reveal();

        /** @var EntityManagerInterface $em */
        $em = self::prophesize(EntityManagerInterface::class);
        $em->getMetadataFactory()->willReturn($mdf);
        $em->getClassMetadata('AppBundle\Entity\UserRole')->willReturn($cmd);
        $em = $em->reveal();

        $serializer = new JsonApiSerializer($em);
        $serializedPayLoad = $serializer->serialize($payLoad, 'userRoles');
        $deserializedPayLoad = json_decode($serializedPayLoad);

        self::assertEquals('userRoles', $deserializedPayLoad->data->type);
        self::assertEquals('ROLE_BANANA', $deserializedPayLoad->data->attributes->role);
        self::assertObjectNotHasAttribute('id', $deserializedPayLoad->data);
    }

    public function testSerialize_persisted_entity()
    {
        /** @var UserRole $payLoad */
        $payLoad = self::prophesize(UserRole::class);
        $payLoad->getId()->willReturn(344);
        $payLoad->getRole()->willReturn('ROLE_BANANA');
        $payLoad->getCreatedAt()->willReturn(new \DateTime('-1 day'));
        $payLoad = $payLoad->reveal();

        /** @var ClassMetadataFactory $mdf */
        $mdf = self::prophesize(ClassMetadataFactory::class);
        $mdf->isTransient(Argument::any())->willReturn(false);
        $mdf = $mdf->reveal();

        $columnNames = [
            'id',
            'role',
            'created_at',
        ];

        /** @var ClassMetadata $cmd */
        $cmd = self::prophesize(ClassMetadata::class);
        $cmd->getColumnNames()->willReturn($columnNames);
        $cmd->getFieldForColumn('id')->willReturn('id');
        $cmd->getFieldForColumn('role')->willReturn('role');
        $cmd->getFieldForColumn('created_at')->willReturn('createdAt');
        $cmd->getIdentifier()->willReturn(['id']);
        $cmd = $cmd->reveal();

        /** @var EntityManagerInterface $em */
        $em = self::prophesize(EntityManagerInterface::class);
        $em->getMetadataFactory()->willReturn($mdf);
        $em->getClassMetadata(Argument::any())->willReturn($cmd);
        $em = $em->reveal();

        $serializer = new JsonApiSerializer($em);
        $serializedPayLoad = $serializer->serialize($payLoad, 'userRoles');
        $deserializedPayLoad = json_decode($serializedPayLoad);

        self::assertEquals('userRoles', $deserializedPayLoad->data->type);
        self::assertEquals('ROLE_BANANA', $deserializedPayLoad->data->attributes->role);
        self::assertEquals(344, $deserializedPayLoad->data->id);
    }
}
