<?php
/**
 * Created by PhpStorm.
 * User: Wolverine
 * Date: 21.10.2019
 * Time: 21:26
 */

namespace classes;


/**
 * Класс формы
 *
 * Создаёт html-форму с её элементами и заполняет их атрибуты
 *
 * @author Wolverine <wolverine17sf@gmail.com>
 * @version 1.0
 * @copyright Copyright (c) 2019, Wolverine
 */
class Form
{
    /**
     * @var string action-формы
     */
    private $action = '';
    /**
     * @var string метод отправки данных формы
     */
    private $method;
    /**
     * @var string type-атрибут элемента формы
     */
    private $type;
    /**
     * @var string value-атрибут элемента формы
     */
    private $value;
    /**
     * @var string name-атрибут элемента формы
     */
    private $name;
    /**
     * @var string id элемента формы
     */
    private $idName;

    /**
     * Сеттер для value-свойства класса
     *
     * @param array $arr - содержит атрибуты тега
     */
    public function setValue($arr) {
        if (array_key_exists('value', $arr)) {
            $this->value = $arr['value'];
        }
    }

    /**
     * Сеттер для name-свойства класса
     *
     * @param array $arr - содержит атрибуты тега
     */
    public function setName($arr) {
        if (array_key_exists('name', $arr)) {
            $this->name = 'name="'. $arr['name'].'"';
        }
    }

    /**
     * Сеттер для id-свойства класса
     *
     * @param array $arr - содержит атрибуты тега
     */
    public function setId($arr) {
        if (array_key_exists('id', $arr)) {
            $this->idName = 'id="' . $arr['id'] . "\" ";
        }
    }

    /**
     * Формирует тег <input type="text"> формы и заполняет его атрибуты
     *
     * @param array $arr - содержит атрибуты формы: id, name, type, value
     * @return string сформированный открывающий тег <input>
     */
    public function input($arr) {
        $this->type = $arr['type'];
        $this->setId($arr);
        $this->setName($arr);
        $this->setValue($arr);
        return '<input ' . $this->idName . $this->name . ' type="' . $this->type . '" value="' . $this->value . '">';
    }

    /**
     * Формирует тег <input type="submit"> формы и заполняет его атрибуты
     *
     * @param array $arr - содержит атрибуты формы: id, name, type, value
     * @return string сформированный открывающий тег <input>
     */
    public function submit($arr) {
        $this->type = 'submit';
        $this->setId($arr);
        $this->setName($arr);
        $this->setValue($arr);
        return '<input ' . $this->idName . $this->name . ' type="' . $this->type . '" value="' . $this->value . '">';
    }

    /**
     * Формирует тег <form> формы и заполняет его атрибуты
     *
     * @param array $arr - содержит атрибуты формы: action, method
     * @return string сформированный открывающий тег <form>
     */
    public function open($arr) {
        $this->action = $arr['action'];
        $this->method = $arr['method'];
        $this->setId($arr);
        return '<form ' . $this->idName . ' action="' . $this->action . '" method="' . $this->method . '">';
    }

    /**
     * Формирует тег </form> формы
     *
     * @return string сформированный открывающий тег </form>
     */
    public function close() {
        return '</form>';
    }
}