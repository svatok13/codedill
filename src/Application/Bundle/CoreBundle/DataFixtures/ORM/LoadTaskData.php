<?php
/*
 * This file is part of the Codedill project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Bundle\CoreBundle\DataFixtures\ORM;

use Application\Bundle\CoreBundle\Entity\Task;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Load Task fixtures
 */
class LoadTaskData extends AbstractFixture
{
    /**
     * Load fixtures
     *
     * @param ObjectManager $manager Manager
     */
    public function load(ObjectManager $manager)
    {
        $task = (new Task())->setTitle('Game')
                            ->setDescription(<<<DESC
У двух игроков есть строка s, состоящая из строчных букв латинского алфавита. Они играют в игру, которая описывается следующими правилами:

Игроки ходят по очереди; За один ход игрок может удалить из строки s произвольную букву. Если игрок перед своим ходом может перемешать буквы в строке s таким образом, чтобы получился палиндром, этот игрок побеждает. Палиндром — строка, которая одинаково читается в обоих направлениях. Например, строка «abba» — палиндром, а строка «abc» — нет.

Определите, кто из игроков победит при оптимальной игре обеих сторон — тот, кто ходит первым, или тот, кто ходит вторым.
DESC
                            );
        $this->addReference('task-1', $task);
        $manager->persist($task);

        $task = (new Task())->setTitle('Crossword')
                            ->setDescription(<<<DESC
Вася тренируется составлять кроссворды. Пока он умеет составлять кроссворды только очень простого вида. Все они состоят ровно из шести слов, слова можно читать только сверху вниз по вертикали и слева направо по горизонтали. Слова расположены в виде прямоугольной восьмерки, не обязательно симметричной. Восьмерка упирается одной половиной в левый верхний угол, а другой — в правый нижний угол некоторого прямоугольника. Кроссворд не может вырождаться, т. е. в нем всегда содержится ровно четыре пустые области, две из которых окружены буквами. В качестве примеров смотрите входные/выходные данные в провайдерах данных для тестов.

Помогите Васе — составьте кроссворд описанного вида из заданных шести слов. Разрешается использовать слова в любом порядке.
DESC
                            );
        $this->addReference('task-2', $task);
        $manager->persist($task);

        $manager->flush();
    }
}
