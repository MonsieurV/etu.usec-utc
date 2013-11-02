<?php

/*
 * This file is part of the Plateforme étudiante USEC.
*
* (c) USEC <contact@usec-utc.fr>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace USEC\StudentBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\SubmitType as SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CustomSubmitType extends SubmitType {
	
	/**
	 * {@inheritDoc}
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$options = parent::setDefaultOptions($resolver);
		$resolver->setDefaults(array(
			'return_path' => false,
		));
	}
	
	public function getKnownOptions(array $options) {
		$options = parent::getKnownOptions($options);
		$options[] = 'return_path';
		
		return $options;
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function buildView(FormView $view, FormInterface $form, array $options) {
		parent::buildView($view, $form, $options);
		$view->vars = array_replace($view->vars, array(
				'return_path'   => $options['return_path'],
		));
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		parent::buildForm($builder, $options);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getParent() {
		return 'submit';
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getName() {
		return 'custom_submit';
	}
}
