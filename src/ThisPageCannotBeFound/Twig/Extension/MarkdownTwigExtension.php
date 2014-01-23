<?php

namespace ThisPageCannotBeFound\Twig\Extension;

use Michelf\MarkdownInterface;

/**
 * Twig Markdown extension
 */
class MarkdownTwigExtension extends \Twig_Extension {

	protected $parser;

	/**
	 * Public constructor
	 *
	 * @param MarkdownInterface $parser
	 *
	 * @return MarkdownTwigExtension
	 */
	public function __construct(MarkdownInterface $parser) {
		$this->parser = $parser;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getFilters() {
		return array(
			'markdown' => new \Twig_Filter_Method($this, 'markdown',
					array('is_safe' => array('html'))),
		);
	}

	/**
	 * Transform markdown text to html
	 *
	 * @param string $txt
	 *
	 * @return string
	 */
	public function markdown($txt) {
		return $this->parser->defaultTransform($txt);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getName() {
		return 'markdown';
	}

}

