<?php
declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Account;
use App\Tests\TestTool as Tool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;

class AccountTest extends KernelTestCase
{
    public function getEntity(): Account
    {
        return (new Account())
            ->setId(1)
            ->setCivility('Mr')
            ->setName('DOE')
            ->setFirstname('John')
            ->setEmail('john.doe@example.com')
            ->setLogin('john.doe')
            ->setPassword('azerty$123456')
            ->setRoles(['ROLE_USER'])
            ->setActive(true)
            ->setCreatedAt(new \DateTime('2022-01-01'))
            ->setUpdatedAt(new \DateTime('2022-11-01'));
    }

    public function assertHasErrors(Account $account, int $number = 0)
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
        $this->assertHasErrors($this->getEntity()->setId(0), 1);
        $this->assertEquals(1, $this->getEntity()->getId());
    }

    public function testCivility()
    {
        $this->assertHasErrors($this->getEntity()->setCivility('Dr'), 1);
        $this->assertEquals('Mr', $this->getEntity()->getCivility());
    }

    public function testName()
    {
        $this->assertHasErrors($this->getEntity()->setName(Tool::generateString(1)));
        $this->assertHasErrors($this->getEntity()->setName(Tool::generateString(256)), 1);
        $this->assertEquals('DOE', $this->getEntity()->getName());
    }

    public function testFirstName()
    {
        $this->assertHasErrors($this->getEntity()->setFirstname(Tool::generateString(1)));
        $this->assertHasErrors($this->getEntity()->setFirstname(Tool::generateString(256)), 1);
        $this->assertEquals('John', $this->getEntity()->getFirstname());
    }

    public function testEmail()
    {
        $this->assertHasErrors($this->getEntity()->setEmail('test'), 1);
        $this->assertHasErrors($this->getEntity()->setEmail('test@tld'), 1);
        $this->assertEquals('john.doe@example.com', $this->getEntity()->getEmail());
    }

    public function testLogin()
    {
        $this->assertHasErrors($this->getEntity()->setLogin(Tool::generateString(1)), 1);
        $this->assertEquals('john.doe', $this->getEntity()->getLogin());
    }

    public function testPassword()
    {
        $this->assertHasErrors($this->getEntity()->setPassword(''), 1);
        $this->assertEquals('azerty$123456', $this->getEntity()->getPassword());
    }

    public function testRole()
    {
        $this->assertHasErrors($this->getEntity()->setRoles(['ROLE_USER']));
        $this->assertHasErrors($this->getEntity()->setRoles(['ROLE_ADMIN']));
        $this->assertHasErrors($this->getEntity()->setRoles(['ROLE_SUPERADMIN']));
        $this->assertEquals(['ROLE_USER'], $this->getEntity()->getRoles());
    }

    public function testCreatedAt()
    {
        $this->assertHasErrors($this->getEntity()->setCreatedAt(new \DateTime()));
        $this->assertEquals(new \DateTime('2022-01-01'), $this->getEntity()->getCreatedAt());
    }

    public function testUpdatedAt()
    {
        $this->assertHasErrors($this->getEntity()->setUpdatedAt(null));
        $this->assertHasErrors($this->getEntity()->setUpdatedAt(new \DateTime()));
        $this->assertEquals(new \DateTime('2022-11-01'), $this->getEntity()->getUpdatedAt());
    }

    public function testActive()
    {
        $this->assertHasErrors($this->getEntity()->setActive(true));
        $this->assertHasErrors($this->getEntity()->setActive(false));
        $this->assertEquals(true, $this->getEntity()->isActive());
    }

}
