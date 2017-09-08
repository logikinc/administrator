<?php

use Terranet\Administrator\Filters\FilterElement;

require_once __DIR__ . '/../MocksValidator.php';

class FilterElementTest extends PHPUnit_Framework_TestCase
{
    use MocksValidator;

    public function setUp()
    {
        parent::setUp();

        $this->mockValidator();
    }

    /** @test */
    public function it_creates_appropriate_form_element()
    {
        $elements = [
            'text' => \Terranet\Administrator\Form\Type\Text::class,
            'search' => \Terranet\Administrator\Form\Type\Search::class,
            'select' => \Terranet\Administrator\Form\Type\Select::class,
            'datalist' => \Terranet\Administrator\Form\Type\Datalist::class,
            'number' => \Terranet\Administrator\Form\Type\Number::class,
            'date' => \Terranet\Administrator\Form\Type\Date::class,
            'daterange' => \Terranet\Administrator\Form\Type\Daterange::class,
        ];

        foreach ($elements as $type => $instance) {
            $element = FilterElement::$type('test');

            $input = $element->getInput();

            $this->assertInstanceOf(FilterElement::class, $element);
            $this->assertInstanceOf($instance, $input);
        }
    }

    /** @test */
    public function it_allows_options_for_select_and_datalist_elements()
    {
        $select = FilterElement::select('select');
        $datalist = FilterElement::datalist('datalist');
        $select->getInput()->setOptions($options = [1,2,3,4,5]);
        $datalist->getInput()->setOptions($options);

        $this->assertEquals(
            $options, $select->getInput()->getOptions()
        );

        $this->assertEquals(
            $options, $datalist->getInput()->getOptions()
        );
    }

    /** @test */
    public function it_allows_callable_options_for_select_and_datalist_elements()
    {
        $select = FilterElement::select('select');
        $datalist = FilterElement::datalist('datalist');

        $realOptions = [1,2,3,4,5];
        $options = function () use ($realOptions) {
            return $realOptions;
        };

        $select->getInput()->setOptions($options);
        $datalist->getInput()->setOptions($options);

        $this->assertEquals(
            $realOptions, $select->getInput()->getOptions()
        );

        $this->assertEquals(
            $realOptions, $datalist->getInput()->getOptions()
        );
    }

    /** @test */
    public function it_allows_a_data_url_for_search_form_element()
    {
        $search = FilterElement::search('user');
        $search->getInput()->setDataUrl('/search/users');

        $this->assertEquals(
            '/search/users', $search->getInput()->getDataUrl()
        );
        $this->assertArrayHasKey('data-type', $attributes = $search->getInput()->getAttributes());
        $this->assertEquals('livesearch', $attributes['data-type']);
    }

    /** @test */
    public function it_allows_a_query_attribute()
    {
        $select = FilterElement::select('test');
        $input = $select->getInput();
        $input->setOptions([1,2,3,4,5]);

        $input->setQuery($query = function ($query, $value = null) {
            return $query->where('test', $value);
        });

        $this->assertEquals(
            $query,
            $input->getQuery()
        );
    }
}