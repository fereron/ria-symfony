<?php

return [
    // Symfony dependencies
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle::class => ['all' => true],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => ['all' => true],
    Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class => ['all' => true],
    Symfony\Bundle\SecurityBundle\SecurityBundle::class => ['all' => true],
    Symfony\Bundle\TwigBundle\TwigBundle::class => ['all' => true],
    Twig\Extra\TwigExtraBundle\TwigExtraBundle::class => ['all' => true],
    Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class => ['dev' => true, 'test' => true],
    Symfony\Bundle\MonologBundle\MonologBundle::class => ['all' => true],
    Symfony\Bundle\DebugBundle\DebugBundle::class => ['dev' => true, 'test' => true],
    Symfony\Bundle\MakerBundle\MakerBundle::class => ['dev' => true],
    League\Tactician\Bundle\TacticianBundle::class => ['all' => true],

    // RIA bundles
    Ria\Bundle\UserBundle\RiaUserBundle::class => ['all' => true],
    Ria\Bundle\PostBundle\RiaPostBundle::class => ['all' => true],
    Ria\Bundle\AdminBundle\RiaAdminBundle::class => ['all' => true],
    Ria\Bundle\WebBundle\RiaWebBundle::class => ['all' => true],
];
