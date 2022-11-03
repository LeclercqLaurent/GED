<?php
declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\UserGroup;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;

class UserTest extends KernelTestCase
{
    public function getEntity(): User
    {
        $userGroup = new UserGroup();
        $userGroup->setId(1)
            ->setLabel('Groupe de test')
            ->setActive(true)
            ->setCreatedAt(new \DateTime());

        return (new User())
            ->setId(1)
            ->setLogin('john.doe')
            ->setCivility('Mr')
            ->setName('DOE')
            ->setFirstname('John')
            ->setEmail('john.doe@example.com')
            ->setPassword('azerty$123456')
            ->setRoles(['ROLE_USER'])
            ->setActive(true)
            ->setCreatedAt(new \DateTime())
            ->setUserGroup($userGroup);
    }

    public function assertHasErrors(User $account, int $number = 0)
    {
        self::bootKernel();
        $container = static::getContainer();
        $errors = $container->get('validator')->validate($account);
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
        $this->expectError();
        $this->getEntity()->setId('1a345');
        $this->assertHasErrors($this->getEntity()->setId(0), 1);
    }

    public function testCivility()
    {
        $this->expectError();
        $this->getEntity()->setCivility(null);
        $this->assertHasErrors($this->getEntity()->setCivility('Dr'), 1);
    }

    public function testName()
    {
        $this->expectError();
        $this->getEntity()->setName(null);
        $this->assertHasErrors($this->getEntity()->setName(''), 1);
    }

    public function testFirstName()
    {
        $this->expectError();
        $this->getEntity()->setFirstname(null);
        $this->assertHasErrors($this->getEntity()->setFirstname(''), 1);
    }

    public function testEmail()
    {
        $this->expectError();
        $this->getEntity()->setEmail(null);
        $this->expectError();
        $this->getEntity()->setEmail(1);
        $this->assertHasErrors($this->getEntity()->setEmail('test'), 1);
        $this->assertHasErrors($this->getEntity()->setEmail('test@tld'), 1);
    }

    public function testPassword()
    {
        $this->expectError();
        $this->getEntity()->setPassword(null);
        $this->assertHasErrors($this->getEntity()->setPassword(''), 1);
    }

    public function testRole()
    {
        $this->expectError();
        $this->getEntity()->setRoles([]);
        $this->assertHasErrors($this->getEntity()->setRoles(null), 1);
        $this->assertHasErrors($this->getEntity()->setRoles(['ROLE_EDITOR']), 1);
        $this->assertHasErrors($this->getEntity()->setRoles(['ROLE_USER']));
        $this->assertHasErrors($this->getEntity()->setRoles(['ROLE_ADMIN']));
        $this->assertHasErrors($this->getEntity()->setRoles(['ROLE_SUPERADMIN']));
    }

    public function testCreatedAt()
    {
        $this->expectError();
        $this->getEntity()->setCreatedAt('');
        $this->assertHasErrors($this->getEntity()->setCreatedAt(null), 1);
        $this->assertHasErrors($this->getEntity()->setUpdatedAt(new \DateTime()));
    }

    public function testUpdatedAt()
    {
        $this->expectError();
        $this->getEntity()->setUpdatedAt('');
        $this->assertHasErrors($this->getEntity()->setUpdatedAt(null));
        $this->assertHasErrors($this->getEntity()->setUpdatedAt(new \DateTime()));
    }

    public function testActive()
    {
        $this->expectError();
        $this->getEntity()->setActive(null);
        $this->expectError();
        $this->getEntity()->setActive('');
        $this->assertHasErrors($this->getEntity()->setActive(true));
        $this->assertHasErrors($this->getEntity()->setActive(false));
    }

    public function testUserGroup()
    {
        $this->assertHasErrors($this->getEntity()->setUserGroup(new UserGroup()));
    }

}
