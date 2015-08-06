<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\db\Connection;
use yii\db\Query;
use yii\helpers\Inflector;
use yii\helpers\Console;
use common\models\User;
use Faker;

/**
 * @property Connection $db
 * @property Faker\Generator $faker
 */
class DataController extends Controller
{
    private $_db;
    private $_faker;

    public function actionGenerate()
    {
        $this->generate();
    }

    public function actionClear()
    {
        $this->clear();
    }

    public function actionRefresh()
    {
        $this->clear();
        $this->generate();
    }

    private function generate()
    {
        $this->generateSections();
        $this->generateUsers();
        $this->generatePosts();
    }

    private function generateSections()
    {
        $sections = [
            'Cycling & Bikes' => [
                'Road bikes',
                'Cyclocross bikes',
                'Mountain biking',
                'Touring',
            ],
            'Video and computer games' => [
                'Strategies',
                'FPS',
                'Role playing game',
            ],
            'Computer programming' => [
                'Game development',
                'Web development',
                'Data bases and RDBMSes',
                'Networking',
                'ERP, CRM',
            ],
            'Other' => [
                'Flame',
            ],
        ];

        $count = count($sections);
        Console::startProgress(0, $count, 'Generating sections: ');

        $i = 0;
        foreach ($sections as $title => $children) {
            ++$i;

            $this->getDb()->createCommand()->insert('{{%section}}', [
                'title' => $title,
                'slug' => Inflector::slug($title),
                'created_at' => time(),
                'updated_at' => time(),
            ])->execute();
            $parent = $this->getDb()->getLastInsertID();

            foreach ($children as $title) {
                $this->getDb()->createCommand()->insert('{{%section}}', [
                    'title' => $title,
                    'slug' => Inflector::slug($title),
                    'section_id' => $parent,
                    'created_at' => time(),
                    'updated_at' => time(),
                ])->execute();
            }

            Console::updateProgress($i, $count);
        }

        Console::endProgress();
    }

    private function generateUsers()
    {
        $count = mt_rand(50, 100);
        Console::startProgress(0, $count + 1, 'Generating users: ');

        $security = Yii::$app->getSecurity();

        $this->getDb()->createCommand()->insert('{{%user}}', [
            'username' => 'resurtm',
            'auth_key' => $security->generateRandomString(),
            'password_hash' => $security->generatePasswordHash('123123'),
            'email' => 'resurtm@gmail.com',
            'status' => User::STATUS_ACTIVE,
            'created_at' => time(),
            'updated_at' => time(),
        ])->execute();
        Console::updateProgress(1, $count + 1);

        for ($i = 1; $i <= $count; ++$i) {
            $this->getDb()->createCommand()->insert('{{%user}}', [
                'username' => $this->getFaker()->userName,
                'auth_key' => $security->generateRandomString(),
                'password_hash' => $security->generatePasswordHash('123123', 4),
                'email' => $this->getFaker()->email,
                'status' => User::STATUS_ACTIVE,
                'created_at' => time(),
                'updated_at' => time(),
            ])->execute();
            Console::updateProgress($i + 1, $count + 1);
        }

        Console::endProgress();
    }

    private function generatePosts()
    {
        $count = mt_rand(300, 500);
        Console::startProgress(0, $count, 'Generating posts: ');

        $sectionIds = (new Query())
            ->select('id')
            ->from('{{%section}}')
            ->where('section_id IS NOT NULL')
            ->column($this->getDb());

        $authorIds = (new Query())
            ->select('id')
            ->from('{{%user}}')
            ->column($this->getDb());

        for ($i = 1; $i <= $count; ++$i) {
            $title = rtrim($this->getFaker()->sentence(mt_rand(3, 10)), '.');

            $this->getDb()->createCommand()->insert('{{%post}}', [
                'title' => $title,
                'slug' => Inflector::slug($title),

                'section_id' => $sectionIds[array_rand($sectionIds)],
                'author_id' => $authorIds[array_rand($authorIds)],

                'text' => implode("\n\n", $this->getFaker()->paragraphs(mt_rand(1, 5))),

                'created_at' => time(),
                'updated_at' => time(),
            ])->execute();

            Console::updateProgress($i, $count);
        }

        Console::endProgress();
    }

    private function clear()
    {
        $tables = [
            '{{%comment_al}}',
            '{{%comment_ns}}',
            '{{%comment_mp}}',
            '{{%post}}',
            '{{%section}}',
            '{{%user}}',
        ];

        foreach ($tables as $table) {
            $this->getDb()->createCommand()->delete($table)->execute();
        }
    }

    private function getDb()
    {
        if ($this->_db === null) {
            $this->_db = Yii::$app->getDb();
        }
        return $this->_db;
    }

    private function getFaker()
    {
        if ($this->_faker === null) {
            $this->_faker = Faker\Factory::create();
        }
        return $this->_faker;
    }
}
