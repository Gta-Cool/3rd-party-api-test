<?php

namespace PlaceOrder\Factory;

use PlaceOrder\Client\ClientInterface;
use PlaceOrder\Exception\UnknownRepositoryNameException;
use PlaceOrder\Repository\AbstractRepository;
use PlaceOrder\Repository\PostRepository;
use PlaceOrder\Repository\UserRepository;
use Symfony\Component\Serializer\SerializerInterface;

class RepositoryFactory
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @param ClientInterface $client
     * @param SerializerInterface $serializer
     */
    public function __construct(ClientInterface $client, SerializerInterface $serializer)
    {
        $this->client = $client;
        $this->serializer = $serializer;
    }

    /**
     * @param string $name
     *
     * @return AbstractRepository
     */
    public function getByName($name)
    {
        switch ($name) {
            case 'post':
                $className = PostRepository::class;
                break;
            case 'user':
                $className = UserRepository::class;
                break;
            default:
                throw new UnknownRepositoryNameException(sprintf('"%s" repository does not exist.', $name));
        }

        /** @var AbstractRepository $repositoryObject */
        $repositoryObject = new $className();
        $repositoryObject->setClient($this->client);
        $repositoryObject->setSerializer($this->serializer);

        return $repositoryObject;
    }
}
