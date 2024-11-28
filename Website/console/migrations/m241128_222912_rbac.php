<?php

use yii\db\Migration;

/**
 * Class m241128_222912_rbac
 */
class m241128_222912_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        /* roles */
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $user = $auth->createRole('user');
        $auth->add($user);
        $reviwer = $auth->createRole('reviwer');
        $auth->add($reviwer);

        /* permissions for admin*/
        $userManagement = $auth->createPermission('userManagement');
        $auth->add($userManagement);

        /* permissions for users */
        $myOwnAdvertisement = $auth->createPermission('myOwnAdvertisement');
        $auth->add($myOwnAdvertisement);
        $donateItem = $auth->createPermission('donateItem');
        $auth->add($donateItem);
        $proposalManagement = $auth->createPermission('proposalManagement');
        $auth->add($proposalManagement);
        $reviewManagement = $auth->createPermission('reviewManagement');
        $auth->add($reviewManagement);
        $report = $auth->createPermission('report');
        $auth->add($report);
        $editMyOwnInformation = $auth->createPermission('editMyOwnInformation');
        $auth->add($editMyOwnInformation);
        $usersInformation = $auth->createPermission('usersInformation');
        $auth->add($usersInformation);
        $favorites = $auth->createPermission('favorites');
        $auth->add($favorites);
        $cart = $auth->createPermission('cart');
        $auth->add($cart);

        /* permissions for reviewer */
        $advertisementManagement = $auth->createPermission('advertisementManagement');
        $auth->add($advertisementManagement);
        $reportManagement = $auth->createPermission('reportManagement');
        $auth->add($reportManagement);

        /* assing permissions */
        $auth->addChild($admin, $userManagement);
        $auth->addChild($user, $myOwnAdvertisement);
        $auth->addChild($user, $donateItem);
        $auth->addChild($user, $proposalManagement);
        $auth->addChild($user, $reviewManagement);
        $auth->addChild($user, $report);
        $auth->addChild($user, $editMyOwnInformation);
        $auth->addChild($user, $usersInformation);
        $auth->addChild($user, $favorites);
        $auth->addChild($user, $cart);
        $auth->addChild($reviwer, $advertisementManagement);
        $auth->addChild($reviwer, $reportManagement);

        $auth->addChild($admin, $reviwer);

        $auth->assign($admin, 1);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;

        // Remover atribuições de roles a usuários
        $auth->revokeAll(1); // Revoga todas as permissões e roles do usuário com ID 1 (ajuste conforme necessário)

        // Remover permissões
        $auth->remove($auth->getPermission('userManagement'));
        $auth->remove($auth->getPermission('myOwnAdvertisement'));
        $auth->remove($auth->getPermission('donateItem'));
        $auth->remove($auth->getPermission('proposalManagement'));
        $auth->remove($auth->getPermission('reviewManagement'));
        $auth->remove($auth->getPermission('report'));
        $auth->remove($auth->getPermission('editMyOwnInformation'));
        $auth->remove($auth->getPermission('usersInformation'));
        $auth->remove($auth->getPermission('favorites'));
        $auth->remove($auth->getPermission('cart'));
        $auth->remove($auth->getPermission('advertisementManagement'));
        $auth->remove($auth->getPermission('reportManagement'));

        // Remover roles
        $auth->remove($auth->getRole('admin'));
        $auth->remove($auth->getRole('user'));
        $auth->remove($auth->getRole('reviwer'));

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241128_222912_rbac cannot be reverted.\n";

        return false;
    }
    */
}
