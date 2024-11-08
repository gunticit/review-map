<?php

namespace App\Providers;

use App\Repositories\AdminFaq\AdminFaqRepository;
use App\Repositories\AdminFaq\AdminFaqRepositoryInterface;
use App\Repositories\Bank\BankRepositoryInterface;
use App\Repositories\Bank\BankRepositoryRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Project\ProjectRepository;
use App\Repositories\Project\ProjectRepositoryInterface;
use App\Repositories\ProjectImage\ProjectImageRepository;
use App\Repositories\ProjectImage\ProjectImageRepositoryInterface;
use App\Repositories\Support\SupportRepository;
use App\Repositories\Support\SupportRepositoryInterface;
use App\Repositories\Tag\TagRepository;
use App\Repositories\Tag\TagRepositoryInterface;
use App\Repositories\History\HistoryRepository;
use App\Repositories\History\HistoryRepositoryInterface;
use App\Repositories\Notification\NotificationRepository;
use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Repositories\Faq\FaqRepositoryInterface;
use App\Repositories\Faq\FaqRepository;
use App\Repositories\Comment\CommentRepository;
use App\Repositories\Comment\CommentRepositoryInterface;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Company\CompanyRepository;
use App\Repositories\Company\CompanyRepositoryInterface;
use App\Repositories\ExpenditureStatistic\ExpenditureStatisticRepository;
use App\Repositories\ExpenditureStatistic\ExpenditureStatisticRepositoryInterface;
use App\Repositories\Mission\MissionRepository;
use App\Repositories\Mission\MissionRepositoryInterface;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\PaymentMethod\PaymentMethodRepository;
use App\Repositories\PaymentMethod\PaymentMethodRepositoryInterface;
use App\Repositories\ProductImage\ProductImageRepository;
use App\Repositories\ProductImage\ProductImageRepositoryInterface;
use App\Repositories\Profile\ProfileRepository;
use App\Repositories\Profile\ProfileRepositoryInterface;
use App\Repositories\TransactionHistory\TransactionHistoryRepositoryInterface;
use App\Repositories\TransactionHistory\TransactionHistoryRepository;
use App\Repositories\Voucher\VoucherRepository;
use App\Repositories\Voucher\VoucherRepositoryInterface;
use App\Repositories\Wallet\WalletRepository;
use App\Repositories\Wallet\WalletRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
        $this->app->bind(ProjectImageRepositoryInterface::class, ProjectImageRepository::class);
        $this->app->bind(SupportRepositoryInterface::class, SupportRepository::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
        $this->app->bind(NotificationRepositoryInterface::class, NotificationRepository::class);
        $this->app->bind(HistoryRepositoryInterface::class, HistoryRepository::class);
        $this->app->bind(FaqRepositoryInterface::class, FaqRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
        $this->app->bind(VoucherRepositoryInterface::class, VoucherRepository::class);
        $this->app->bind(ProfileRepositoryInterface::class, ProfileRepository::class);
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(ProductImageRepositoryInterface::class, ProductImageRepository::class);
        $this->app->bind(MissionRepositoryInterface::class, MissionRepository::class);
        $this->app->bind(WalletRepositoryInterface::class, WalletRepository::class);
        $this->app->bind(TransactionHistoryRepositoryInterface::class, TransactionHistoryRepository::class);
        $this->app->bind(PaymentMethodRepositoryInterface::class, PaymentMethodRepository::class);
        $this->app->bind(BankRepositoryInterface::class, BankRepositoryRepository::class);
        $this->app->bind(ExpenditureStatisticRepositoryInterface::class, ExpenditureStatisticRepository::class);
        $this->app->bind(AdminFaqRepositoryInterface::class, AdminFaqRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
