<?php

require_once __DIR__ . '/../CreatesElement.php';
require_once __DIR__ . '/../MocksObjects.php';

use Terranet\Administrator\Collection\Group;

class CollectionGroupTest extends PHPUnit_Framework_TestCase
{
    use CreatesElement, MocksObjects;

    /**
     * @var Group
     */
    protected $group;

    public function setUp()
    {
        parent::setUp();

        $this->createGroup('test');
    }

    /** @test */
    public function it_returns_id_and_title()
    {
        $this->group->setTranslator($this->mockTranslator());

        $this->assertEquals(
            'test', $this->group->id()
        );

        $this->assertEquals(
            'Test', $this->group->title()
        );
    }

    /** @test */
    public function it_excludes_stop_words_from_the_title()
    {
        $group = $this->createGroup('group_id');
        $group->setTranslator($this->mockTranslator());
        $group->setModule($this->mockModule());

        $this->assertEquals(
            'Group', $group->title()
        );
    }

    /** @test */
    public function it_allows_to_change_a_title()
    {
        $this->group->setTitle($title = 'New title');

        $this->assertEquals(
            $title, $this->group->title()
        );
    }

    /** @test */
    public function it_allows_elements()
    {
        $this->group->push($this->e('first'))->push($this->e('second'));

        $this->assertCount(2, $this->group->elements());
    }


    protected function createGroup($title)
    {
        $this->group = new Group($title);

        $this->group->setTranslator($this->mockTranslator());
        $this->group->setModule($this->mockModule());

        return $this->group;
    }
}