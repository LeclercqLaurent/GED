<?php
declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Media;
use App\Entity\UserGroup;
use App\Tests\TestTool as Tool;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;

class MediaTest extends KernelTestCase
{
    public function getEntity(): Media
    {
        $userGroup = $this->createMock(UserGroup::class);
        return (new Media())
            ->setId(1)
            ->setLabel('Media test')
            ->setDescription(null)
            ->setPath('/path/to/file/file.json')
            ->setMimeType('application/json')
            ->setSize(2480000)
            ->setActive(true)
            ->setCreatedAt(new \DateTime('2022-01-01'))
            ->setUpdatedAt(null)
            ->addUserGroup($userGroup)
            ;
    }

    public function assertHasErrors(Media $media, int $number = 0)
    {
        parent::bootKernel();
        $container = static::getContainer();
        $errors = $container->get('validator')->validate($media);
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
        $this->assertEquals('Media test', $this->getEntity()->getLabel());
    }

    public function testDescription()
    {
        $this->assertHasErrors($this->getEntity()->setDescription(null));
        $this->assertHasErrors($this->getEntity()->setDescription(Tool::generateString(260000)), 1);
        $this->assertEquals(null, $this->getEntity()->getDescription());
    }

    public function testPath()
    {
        $this->assertHasErrors($this->getEntity()->setPath('/'), 1);
        $this->assertHasErrors($this->getEntity()->setPath(Tool::generateString(260000)), 1);
        $this->assertEquals('/path/to/file/file.json', $this->getEntity()->getPath());
    }

    public function testMimeType()
    {
        $this->assertHasErrors($this->getEntity()->setMimeType('app'), 1);
        $this->assertHasErrors($this->getEntity()->setMimeType(Tool::generateString(260)), 1);
        $this->assertEquals('application/json', $this->getEntity()->getMimeType());
    }

    public function testSize()
    {
        $this->assertHasErrors($this->getEntity()->setSize(0), 1);
        $this->assertHasErrors($this->getEntity()->setSize(-1), 1);
        $this->assertEquals(2480000, $this->getEntity()->getSize());
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

    public function testUserGroup()
    {
        $userGroup = $this->createMock(UserGroup::class);
        $media = (new Media())
            ->setId(1)
            ->setLabel('Media test')
            ->setDescription(null)
            ->setPath('/path/to/file/')
            ->setMimeType('application/json')
            ->setSize(2480000)
            ->setActive(true)
            ->setCreatedAt(new \DateTime('2022-01-01'))
            ->setUpdatedAt(null)
            ->addUserGroup($userGroup);

        $this->assertHasErrors($media->addUserGroup($userGroup));
        $this->assertEquals(new ArrayCollection([$userGroup]), $media->getUserGroup());
        $this->assertHasErrors($media->removeUserGroup($userGroup));
        $this->assertEquals(new ArrayCollection(), $media->getUserGroup());
    }

}
