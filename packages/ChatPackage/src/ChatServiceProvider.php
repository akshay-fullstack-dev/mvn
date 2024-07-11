<?php

namespace IntersoftChat;

use Illuminate\Support\ServiceProvider;
use IntersoftChat\App\Repositories;
use IntersoftChat\App\Repositories\Interfaces as RepositoryInterfaces;
use IntersoftChat\App\Services;
use IntersoftChat\App\Services\Interfaces as ServiceInterface;

class ChatServiceProvider extends ServiceProvider
{
  public function boot()
  {
    $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    $this->loadPackageService();
    $this->loadPackageRepository();
  }

  private function loadPackageService()
  {
    $this->app->bind(ServiceInterface\IChatService::class, Services\ChatService::class);
  }
  private function loadPackageRepository()
  {
    $this->app->bind(RepositoryInterfaces\IConversationMessageRepository::class, Repositories\ConversationMessageRepository::class);
    $this->app->bind(RepositoryInterfaces\IConversationRepository::class, Repositories\ConversationRepository::class);
  }
}
