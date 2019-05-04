<?php

namespace App\Service;

use App\Exception\NewsNotFound;

class News {
    private $news = [
        1 => [
            'id' => 1,
            'thumbnail' => '/img/domain_model_thumb.jpg',
            'image' => '/img/domain_model.png',
            'created' => '2019-05-03 20:00:00',
            'title' => 'Domain Model',
            'url' => 'https://en.wikipedia.org/wiki/Domain_model',
            'text' => "A domain model is a system of abstractions that describes selected aspects of a sphere of knowledge, influence or activity (a domain). The model can then be used to solve problems related to that domain. The domain model is a representation of meaningful real-world concepts pertinent to the domain that need to be modeled in software. The concepts include the data involved in the business and rules the business uses in relation to that data.\n\nA domain model generally uses the vocabulary of the domain, thus allowing a representation of the model to be communicated to non-technical stakeholders. It should not refer to any technical implementations such as databases or software components that are being designed."
        ],
        2 => [
            'id' => 2,
            'thumbnail' => '/img/bdd_thumb.png',
            'image' => '/img/bdd.png',
            'created' => '2019-05-03 20:15:27',
            'title' => 'Behaviour-Driven Development',
            'url' => 'https://en.wikipedia.org/wiki/Behavior-driven_development',
            'text' => "In software engineering, behavior-driven development (BDD) is an Agile software development process that encourages collaboration between developers, QA and non-technical or business participants in a software project. It encourages teams to use conversation and concrete examples to formalize a shared understanding of the application should behave. It emerged from test-driven development (TDD).\n\nBehavior-driven development combines the general techniques and principles of TDD with ideas from domain-driven design and object-oriented analysis and design to provide software development and management teams with shared tools and a shared process to collaborate on software development."
        ],
        3 => [
            'id' => 3,
            'thumbnail' => '/img/clean_code_thumb.jpg',
            'image' => '/img/clean_code.png',
            'created' => '2019-05-03 20:18:09',
            'title' => 'Clean Code',
            'url' => 'https://dzone.com/articles/what-clean-code-%E2%80%93-quotes',
            'text' => "Clean code can be read, and enhanced by a developer other than its original author. It has unit and acceptance tests. It has meaningful names. It provides one way rather than many ways for doing one thing. It has minimal dependencies, which are explicitly defined, and provides a clear and minimal API. Code should be literate since, depending on the language, not all necessary information can be expressed clearly in code alone.\n\n'Big' Dave Thomas"
        ],
        4 => [
            'id' => 4,
            'thumbnail' => '/img/docker_thumb.png',
            'image' => '/img/docker.png',
            'created' => '2019-05-03 20:28:13',
            'title' => 'Docker',
            'url' => 'https://opensource.com/resources/what-docker',
            'text' => "Docker is a tool designed to make it easier to create, deploy, and run applications by using containers. Containers allow a developer to package up an application with all of the parts it needs, such as libraries and other dependencies, and ship it all out as one package. By doing so, thanks to the container, the developer can rest assured that the application will run on any other Linux machine regardless of any customized settings that machine might have that could differ from the machine used for writing and testing the code."
        ],
        5 => [
            'id' => 5,
            'thumbnail' => '/img/continuous_integration_thumb.png',
            'image' => '/img/continuous_integration.png',
            'created' => '2019-05-03 20:36:29',
            'title' => 'Continuous Integration',
            'url' => 'https://docs.microsoft.com/en-us/azure/devops/learn/what-is-continuous-integration',
            'text' => "Continuous Integration (CI) is the process of automating the build and testing of code every time a team member commits changes to version control. CI encourages developers to share their code and unit tests by merging their changes into a shared version control repository after every small task completion. Committing code triggers an automated build system to grab the latest code from the shared repository and to build, test, and validate the full master branch (also known as the trunk or main)."
        ]
    ];

    public function fetchAll():array {
        return $this->news;
    }

    public function fetchById(int $id):array {
        if (!isset($this->news[$id])) {
            throw new NewsNotFound($id);
        }

        return $this->news[$id];
    }
}
