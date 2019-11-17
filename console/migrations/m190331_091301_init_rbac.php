<?php

use yii\db\Migration;

/**
 * Class m190331_091301_init_rbac
 */
class m190331_091301_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // add "createUser" permission
        $createUser = $auth->createPermission('createUser');
        $createUser->description = 'Create a user';
        $auth->add($createUser);

        // add "listUser" permission
        $listUser = $auth->createPermission('listUser');
        $listUser->description = 'list user';
        $auth->add($listUser);

        // add "updateUser" permission
        $updateUser = $auth->createPermission('updateUser');
        $updateUser->description = 'Update User';
        $auth->add($updateUser);

        // add "deleteUser" permission
        $deleteUser = $auth->createPermission('deleteUser');
        $deleteUser->description = 'Delete User';
        $auth->add($deleteUser);

        // add "viewUser" permission
        $viewUser = $auth->createPermission('viewUser');
        $viewUser->description = 'View User';
        $auth->add($viewUser);

        // add "author" role and give this role the "createPost" permission
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $createUser);
        $auth->addChild($admin,$updateUser);
        $auth->addChild($admin,$viewUser);
        $auth->addChild($admin,$listUser);
        $auth->addChild($admin,$deleteUser);

        // add "author" role and give this role the "createPost" permission
        $superAdmin = $auth->createRole('super admin');
        $auth->add($superAdmin);
        $auth->addChild($superAdmin, $createUser);
        $auth->addChild($superAdmin,$updateUser);
        $auth->addChild($superAdmin,$viewUser);
        $auth->addChild($superAdmin,$listUser);
        $auth->addChild($superAdmin,$deleteUser);
        $auth->addChild($superAdmin, $admin);


        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $listUser);
        $auth->addChild($user,$viewUser);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($user, 2);
        $auth->assign($admin, 1);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190331_091301_init_rbac cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190331_091301_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
