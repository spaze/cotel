<?php
namespace Cotel\Form;

class MediaForm extends \Nette\Application\UI\Form
{


	public function __construct(\Nette\ComponentModel\IContainer $parent, $name)
	{
		parent::__construct($parent, $name);
		$this->addText('url', 'URL:')
			->setRequired('Need URL');
		$this->addText('title', 'Title:');
		$this->addText('published', 'Date:');
		$field = new \Netxten\Forms\Controls\HiddenFieldWithLabel('Tags:');
		$field->setHtmlId('tags');
		$this->addComponent($field, 'tags');
		$this->addSubmit('submit', 'Add');
	}


}