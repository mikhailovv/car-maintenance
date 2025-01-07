<?php

namespace App\Tests\Api;

use App\Authorization\User\Domain\Entity\User;
use App\ProductCatalog\Part\Domain\Entity\Category;
use App\ProductCatalog\Part\Domain\Entity\Part;
use App\ProductCatalog\Service\Domain\Entity\Service;
use Doctrine\ORM\EntityManager;
use Money\Currency;
use Money\Money;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\HttpKernel\KernelInterface;

class ApiTestCase extends WebTestCase
{
    public $authToken;
    public static $apiClient;
    private static $needResetDatabase = true;
    private EntityManager $entityManager;

    protected function setUp(): void
    {
        parent::setUp();

        // Boot the kernel to access the application
        $kernel = self::bootKernel();

        // Reset the database schema
        //self::$needResetDatabase && $this->resetDatabaseSchema($kernel, $kernel->getEnvironment());

        self::$apiClient = $this->getApiClient($kernel);

        $this->entityManager = self::getContainer()->get('doctrine')->getManager();
    }

    private function resetDatabaseSchema(KernelInterface $kernel, string $env): void
    {
        // Run migrations to ensure schema is up to date
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $application->run(new ArrayInput([
            'command' => 'doctrine:database:drop',
            '--force' => true,
            '--env' => $env,
        ]));

        $application->run(new ArrayInput([
            'command' => 'doctrine:database:create',
            '--env' => $env,
        ]));

        $application->run(new ArrayInput([
            'command' => 'doctrine:migrations:migrate',
            '--no-interaction' => true,
            '--env' => $env,
        ]));

        // Load fixtures
        $application->run(new ArrayInput([
            'command' => 'doctrine:fixtures:load',
            '--no-interaction' => true,
            '--env' => $env,
        ]));

        self::$needResetDatabase = false;
    }

    private function getApiClient(KernelInterface $kernel): KernelBrowser
    {
        try {
            $client = $kernel->getContainer()->get('test.client');
        } catch (ServiceNotFoundException) {
            if (class_exists(KernelBrowser::class)) {
                throw new \LogicException('You cannot create the client used in functional tests if the "framework.test" config is not set to true.');
            }
            throw new \LogicException('You cannot create the client used in functional tests if the BrowserKit component is not available. Try running "composer require symfony/browser-kit".');
        }

        return self::getClient($client);
    }

    protected function login(): string
    {

        $this->post('/api/login', [
            'email' => 'bmw-owner@admin.com',
            'password' => 'bmw-owner',
        ]);
        $response = json_decode(self::$apiClient->getResponse()->getContent(), true);
        $this->authToken = $response['token'];

        return $this->authToken;
    }

    protected function post(string $uri, array $data): array
    {
        self::$apiClient->request('POST', $uri, [], [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_AUTHORIZATION' => 'Bearer ' . $this->authToken,
        ], json_encode($data));

        return json_decode(
            self::$apiClient->getResponse()->getContent(),
            true
        );
    }

    protected function get(string $uri): array
    {
        self::$apiClient->request('GET', $uri, [], [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_AUTHORIZATION' => 'Bearer ' . $this->authToken,
        ]);

        return json_decode(
            self::$apiClient->getResponse()->getContent(),
            true
        );
    }

    protected function arrayContainsArrayValues(array $needle, array $haystack): bool
    {
        foreach ($needle as $key => $value) {
            if (!array_key_exists($key, $haystack) || $haystack[$key] !== $value) {
                return false;
            }
        }

        return true;
    }

    protected function createCategory(
        string $mainCategoryName,
        string $subCategoryName
    ): Category
    {
        $category = new Category($mainCategoryName);
        $this->entityManager->persist($category);
        $subCategory = new Category($subCategoryName, $category);
        $this->entityManager->persist($subCategory);

        $this->entityManager->flush();

        return $subCategory;
    }

    protected function createPart(
        string $name,
        User $user,
        Category $category
    ): Part
    {
        $partNumber = 'X-'. random_int(1000, 9999) . '-'. random_int(1000, 9999);
        $part = new Part(
            $category,
            'Brand',
            $partNumber,
            $partNumber,
            $name,
            new Money(random_int(10, 1000), new Currency('EUR')),
            random_int(1, 10),
            $user
        );

        $this->entityManager->persist($part);
        $this->entityManager->flush();

        return $part;
    }

    protected function createService(User $user, string $name): Service
    {
        $service = new Service(
            $user,
            $name,
            new Money(random_int(35, 90), new Currency('EUR')),
            random_int(1, 10),
        );

        $this->entityManager->persist($service);
        $this->entityManager->flush();

        return $service;
    }

    protected function getLoggedUser(): User
    {
        return $this->entityManager->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.email = :email')
            ->setParameter('email', 'bmw-owner@admin.com')
            ->getQuery()
            ->getOneOrNullResult();
    }

}
