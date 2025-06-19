<?php

namespace Drupal\custom_module\Plugin\Block;

use Drupal\Core\Url;
use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a user authentication status block.
 */
#[Block(
  id: 'custom_module_user_status',
  admin_label: new TranslatableMarkup('User Status Block'),
  category: new TranslatableMarkup('Custom Module')
)]
class UserStatusBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The current user service.
   */
  protected AccountProxyInterface $currentUser;

  /**
   * Constructs a new UserStatusBlock object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   The current user service.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    AccountProxyInterface $current_user,
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->currentUser = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $build = [];

    if ($this->currentUser->isAnonymous()) {
      // Anonymous user - show "Log In".
      $build['content'] = [
        '#type' => 'link',
        '#title' => $this->t('Log In'),
        '#url' => Url::fromRoute('user.login'),
        '#attributes' => [
          'class' => ['user-status-login'],
        ],
      ];
    }
    else {
      // Authenticated user - show welcome message.
      $username = $this->currentUser->getDisplayName();
      $build['content'] = [
        '#markup' => $this->t('Welcome, @username!', ['@username' => $username]),
        '#prefix' => '<div class="user-status-welcome">',
        '#suffix' => '</div>',
      ];
    }

    // Add proper cache metadata.
    $build['#cache'] = [
      'contexts' => [
        'user',
      ],
      'tags' => [
        'user:' . $this->currentUser->id(),
      ],
      // Don't cache this block as user status can change.
      'max-age' => 0,
    ];

    // Attach CSS library.
    $build['#attached']['library'][] = 'custom_module/user_status_block';

    return $build;
  }

}
