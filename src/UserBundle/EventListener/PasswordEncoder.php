<?php

/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UserBundle\EventListener;

use CoreBundle\EventListener\AbstractEventListener;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use UserBundle\Entity\User;

class PasswordEncoder extends AbstractEventListener
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * PasswordEncoder constructor.
     *
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param LifecycleEventArgs $args
     *
     * @return null|User
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        return $this->handleEvent($args);
    }

    /**
     * @param LifecycleEventArgs $args
     *
     * @return null|User
     */
    protected function handleEvent(LifecycleEventArgs $args)
    {
        $entity = $this->getEntity($args);

        if (!$entity) {
            return;
        }

        return $this->encodePassword($entity);
    }

    /**
     * @param User $entity
     *
     * @return null|User
     */
    private function encodePassword(User $entity)
    {
        if (!$entity->getPlainPassword()) {
            return null;
        }

        $encodedPassword = $this->passwordEncoder->encodePassword($entity, $entity->getPlainPassword());
        $entity->setPassword($encodedPassword);

        return $entity;
    }

    /**
     * @param LifecycleEventArgs $args
     *
     * @return null|User
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        return $this->handleEvent($args);
    }

    /**
     * @param $entity
     *
     * @return bool
     */
    protected function isEntityValid($entity):bool
    {
        $package = 'UserBundle\Entity\\';
        return
            in_array(
                get_class($entity),
                [
                    $package . 'User',
                    $package . 'Coordinator',
                    $package . 'Teacher',
                    $package . 'Titular',
                    $package . 'CourseTitular',
                    $package . 'StudentParent',
                    $package . 'SuperAdmin',
                ]
            );
    }
}
