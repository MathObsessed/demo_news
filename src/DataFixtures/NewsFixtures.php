<?php

namespace App\DataFixtures;

use App\Entity\News;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class NewsFixtures extends Fixture {
    public function load(ObjectManager $manager) {
        $news1 = new News();
        $news1
            ->setCreated(new \DateTimeImmutable('2019-05-03 20:00:00'))
            ->setTitle('Domain Model')
            ->setThumbnail('/img/domain_model_thumb.jpg')
            ->setImage('/img/domain_model.png')
            ->setUrl('https://en.wikipedia.org/wiki/Domain_model')
            ->setText("A domain model is a system of abstractions that describes selected aspects of a sphere of knowledge, influence or activity (a domain). The model can then be used to solve problems related to that domain. The domain model is a representation of meaningful real-world concepts pertinent to the domain that need to be modeled in software. The concepts include the data involved in the business and rules the business uses in relation to that data.\n\nA domain model generally uses the vocabulary of the domain, thus allowing a representation of the model to be communicated to non-technical stakeholders. It should not refer to any technical implementations such as databases or software components that are being designed.");

        $news2 = new News();
        $news2
            ->setCreated(new \DateTimeImmutable('2019-05-03 20:15:27'))
            ->setTitle('Behaviour-Driven Development')
            ->setThumbnail('/img/bdd_thumb.png')
            ->setImage('/img/bdd.png')
            ->setUrl('https://en.wikipedia.org/wiki/Behavior-driven_development')
            ->setText("In software engineering, behavior-driven development (BDD) is an Agile software development process that encourages collaboration between developers, QA and non-technical or business participants in a software project. It encourages teams to use conversation and concrete examples to formalize a shared understanding of the application should behave. It emerged from test-driven development (TDD).\n\nBehavior-driven development combines the general techniques and principles of TDD with ideas from domain-driven design and object-oriented analysis and design to provide software development and management teams with shared tools and a shared process to collaborate on software development.");

        $news3 = new News();
        $news3
            ->setCreated(new \DateTimeImmutable('2019-05-03 20:18:09'))
            ->setTitle('Clean Code')
            ->setThumbnail('/img/clean_code_thumb.jpg')
            ->setImage('/img/clean_code.png')
            ->setUrl('https://dzone.com/articles/what-clean-code-%E2%80%93-quotes')
            ->setText("Clean code can be read, and enhanced by a developer other than its original author. It has unit and acceptance tests. It has meaningful names. It provides one way rather than many ways for doing one thing. It has minimal dependencies, which are explicitly defined, and provides a clear and minimal API. Code should be literate since, depending on the language, not all necessary information can be expressed clearly in code alone.\n\n'Big' Dave Thomas");

        $news4 = new News();
        $news4
            ->setCreated(new \DateTimeImmutable('2019-05-03 20:28:13'))
            ->setTitle('Docker')
            ->setThumbnail('/img/docker_thumb.png')
            ->setImage('/img/docker.png')
            ->setUrl('https://opensource.com/resources/what-docker')
            ->setText("Docker is a tool designed to make it easier to create, deploy, and run applications by using containers. Containers allow a developer to package up an application with all of the parts it needs, such as libraries and other dependencies, and ship it all out as one package. By doing so, thanks to the container, the developer can rest assured that the application will run on any other Linux machine regardless of any customized settings that machine might have that could differ from the machine used for writing and testing the code.");

        $news5 = new News();
        $news5
            ->setCreated(new \DateTimeImmutable('2019-05-03 20:36:29'))
            ->setTitle('Continuous Integration')
            ->setThumbnail('/img/continuous_integration_thumb.png')
            ->setImage('/img/continuous_integration.png')
            ->setUrl('https://docs.microsoft.com/en-us/azure/devops/learn/what-is-continuous-integration')
            ->setText("Continuous Integration (CI) is the process of automating the build and testing of code every time a team member commits changes to version control. CI encourages developers to share their code and unit tests by merging their changes into a shared version control repository after every small task completion. Committing code triggers an automated build system to grab the latest code from the shared repository and to build, test, and validate the full master branch (also known as the trunk or main).");

        $manager->persist($news1);
        $manager->persist($news2);
        $manager->persist($news3);
        $manager->persist($news4);
        $manager->persist($news5);

        $manager->flush();
    }
}
