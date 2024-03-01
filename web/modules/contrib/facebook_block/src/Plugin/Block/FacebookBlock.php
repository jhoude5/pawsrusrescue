<?php

namespace Drupal\facebook_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a facebook block block type.
 *
 * @Block(
 *   id = "facebook_block",
 *   admin_label = @Translation("Facebook Block"),
 *   category = @Translation("Facebook Block"),
 * )
 */
class FacebookBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'fb_id' => 'facebook',
      'width' => 500,
      'height' => 700,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['fb_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Facebook ID'),
      '#description' => $this->t('Your Facebook ID. Eg. facebook'),
      '#default_value' => $this->configuration['fb_id'],
    ];
    $form['width'] = [
      '#type' => 'number',
      '#title' => $this->t('Image width in pixels'),
      '#default_value' => $this->configuration['width'],
    ];
    $form['height'] = [
      '#type' => 'number',
      '#title' => $this->t('Image height in pixels'),
      '#default_value' => $this->configuration['height'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    if ($form_state->hasAnyErrors()) {
      return;
    }
    else {
      $this->configuration['fb_id'] = $form_state->getValue('fb_id');
      $this->configuration['width'] = $form_state->getValue('width');
      $this->configuration['height'] = $form_state->getValue('height');
    }
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $render['root-div'] = [
      '#type' => 'container',
      '#attributes' => [
        'id' => ['fb-root'],
      ],
    ];
    $render['block'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => ['fb-page'],
        'data-href' => 'https://www.facebook.com/'.$this->configuration['fb_id'],
        'data-width' => $this->configuration['width'] ?? '',
        'data-height' => $this->configuration['height'] ?? '',
        'data-show-posts' => 'TRUE',
      ],
    ];
    $render['block']['child'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => ['fb-xfbml-parse-ignore'],
      ],
    ];
    $render['block']['child']['blockquote'] = [
      '#type' => 'link',
      '#title' => 'Facebook',
      '#href' => 'https://www.facebook.com/'.$this->configuration['fb_id'],
      '#prefix' => '<blockquote cite="https://www.facebook.com/"'.$this->configuration['fb_id'].'>',
      '#suffix' => '</blockquote>',
    ];
    $render['#attached']['library'][] = 'facebook_block/facebook_block';

    return $render;
  }

}
