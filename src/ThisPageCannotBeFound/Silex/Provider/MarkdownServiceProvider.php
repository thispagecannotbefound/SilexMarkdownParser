<?php

namespace ThisPageCannotBeFound\Silex\Provider;

use Michelf\Markdown;
use Michelf\MarkdownExtra;
use Silex\Application;
use Silex\ServiceProviderInterface;
use ThisPageCannotBeFound\Twig\Extension\MarkdownTwigExtension;

/**
 * Simple markdown service provider
 */
class MarkdownServiceProvider implements ServiceProviderInterface {

	/**
	 * {@inheritdoc}
	 */
	public function register(Application $app) {
		$app['markdown'] = $app->share(function() use($app) {
					if (!empty($app['markdown.factory'])) {
						return $app[$app['markdown.factory']];
					}

					$parser = !(empty($app['markdown.parser'])) ? $app['markdown.parser'] : 'markdown';

					switch ($parser) {
						case 'markdown':
							return new Markdown;
							break;
						case 'extra':
							return new MarkdownExtra;
							break;
						default:
							throw new \RuntimeException("Unknown Markdown parser '$parser' specified");
					}
				});
	}

	/**
	 * {@inheritdoc}
	 */
	public function boot(Application $app) {
		if (isset($app['twig'])) {
			$app['twig'] = $app->share($app->extend('twig',
							function($twig, $app) {
								$twig->addExtension(new MarkdownTwigExtension($app['markdown']));

								return $twig;
							}));
		}
	}

}

