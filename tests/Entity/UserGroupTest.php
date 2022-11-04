<?php
declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Media;
use App\Entity\UserGroup;
use App\Tests\TestTool as Tool;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;

class UserGroupTest extends KernelTestCase
{
    public function getEntity(): UserGroup
    {
        $media = $this->createMock(Media::class);
        return (new UserGroup())
            ->setId(1)
            ->setLabel('Groupe de test')
            ->setActive(true)
            ->setCreatedAt(new \DateTime('2022-01-01'))
            ->setUpdatedAt(null)
            ->addMedium($media);
    }

    public function assertHasErrors(UserGroup $userGroup, int $number = 0)
    {
        parent::bootKernel();
        $container = static::getContainer();
        $errors = $container->get('validator')->validate($userGroup);
        $messages = [];
        /** @var ConstraintViolation $error */
        foreach($errors as $error) {
            $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }
        $this->assertCount($number, $errors, implode(', ', $messages));
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity());
    }

    public function testId()
    {
        $this->assertHasErrors($this->getEntity()->setId(0), 1);
        $this->assertEquals(1, $this->getEntity()->getId());
    }

    public function testLabel()
    {
        $this->assertHasErrors($this->getEntity()->setLabel(Tool::generateString(4)), 1);
        $this->assertHasErrors($this->getEntity()->setLabel(Tool::generateString(260)), 1);
        $this->assertEquals('Groupe de test', $this->getEntity()->getLabel());
    }

    public function testCreatedAt()
    {
        $this->assertHasErrors($this->getEntity()->setUpdatedAt(new \DateTime()));
        $this->assertEquals(new \DateTime('2022-01-01'), $this->getEntity()->getCreatedAt());
    }

    public function testUpdatedAt()
    {
        $this->assertHasErrors($this->getEntity()->setUpdatedAt(null));
        $this->assertHasErrors($this->getEntity()->setUpdatedAt(new \DateTime()));
        $this->assertEquals(null, $this->getEntity()->getUpdatedAt());
    }

    public function testActive()
    {
        $this->assertHasErrors($this->getEntity()->setActive(true));
        $this->assertHasErrors($this->getEntity()->setActive(false));
        $this->assertEquals(true, $this->getEntity()->isActive());
    }

    public function testMedia()
    {
        $media = $this->createMock(Media::class);
        $userGroup  = (new UserGroup())
            ->setId(1)
            ->setLabel('Test UserGroup')
            ->setCreatedAt(new \DateTime())
            ->setActive(true)
            ->addMedium($media);
        $this->assertHasErrors($userGroup->addMedium($media));
        $this->assertEquals(new ArrayCollection([$media]), $userGroup->getMedia());
        $this->assertHasErrors($userGroup->removeMedium($media));
        $this->assertEquals(new ArrayCollection(), $userGroup->getMedia());
    }

}
